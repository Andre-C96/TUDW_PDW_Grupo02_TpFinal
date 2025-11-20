<?php
require_once __DIR__ . '/../Modelo/compraItem.php';
require_once __DIR__ . '/../Modelo/producto.php';
require_once __DIR__ . '/../Modelo/compra.php';
// Agregamos BaseDatos por si acaso se necesita en listados
require_once __DIR__ . '/../Modelo/Conector/BaseDatos.php';

class CompraItemControl
{
    public function abm($datos)
    {
        $resp = false;
        if ($datos['action'] == 'eliminar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['action'] == 'modificar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['action'] == 'alta') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Método ROBUSTO que maneja tanto IDs como Objetos
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        // 1. VERIFICAR SI ES UN ITEM EXISTENTE O NUEVO
        if (array_key_exists('idcompraitem', $param) && $param['idcompraitem'] != null) {
            // Es una modificación o baja: cargamos el objeto existente
            $obj = new CompraItem();
            $obj->setID($param['idcompraitem']);
            if (!$obj->cargar()) {
                $obj = null;
            }
        } else {
            // Es un alta: creamos objeto vacío
            $obj = new CompraItem();
        }

        // 2. SI EL OBJETO ES VÁLIDO, CARGAMOS SUS DATOS
        if ($obj != null) {
            
            // --- CARGAR PRODUCTO ---
            $objProducto = null;
            if (array_key_exists('objproducto', $param) && is_object($param['objproducto'])) {
                $objProducto = $param['objproducto'];
            } elseif (array_key_exists('idproducto', $param) && $param['idproducto'] != null) {
                $objProducto = new Producto();
                $objProducto->setID($param['idproducto']);
                $objProducto->cargar();
            }
            // Usamos el setter individual si existe
            if ($objProducto != null) {
                $obj->setObjProducto($objProducto);
            }

            // --- CARGAR COMPRA ---
            $objCompra = null;
            if (array_key_exists('objcompra', $param) && is_object($param['objcompra'])) {
                $objCompra = $param['objcompra'];
            } elseif (array_key_exists('idcompra', $param) && $param['idcompra'] != null) {
                $objCompra = new Compra();
                $objCompra->setID($param['idcompra']);
                $objCompra->cargar();
            }
            // Usamos el setter individual
            if ($objCompra != null) {
                $obj->setObjCompra($objCompra);
            }

            // --- CARGAR CANTIDAD ---
            if (array_key_exists('cicantidad', $param)) {
                $obj->setCiCantidad($param['cicantidad']);
            }
        }

        return $obj;
    }

    /**
     * Método auxiliar para bajas (solo necesita el ID)
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraitem'])) {
            $obj = new CompraItem();
            $obj->setID($param['idcompraitem']);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraitem'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        // Usamos la función cargarObjeto mejorada
        $obj = $this->cargarObjeto($param);
        
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    // Mantenemos altaSinID por compatibilidad, pero alta() ya la cubre
    public function altaSinID($param)
    {
        return $this->alta($param);
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null and $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idcompraitem'])) {
                $where .= " and idcompraitem ='" . $param['idcompraitem'] . "'";
            }
            if (isset($param['idproducto'])) {
                $where .= " and idproducto ='" . $param['idproducto'] . "'";
            }
            if (isset($param['idcompra'])) {
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            }
            if (isset($param['cicantidad'])) {
                $where .= " and cicantidad ='" . $param['cicantidad'] . "'";
            }
        }
        $obj = new CompraItem();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function listarProductosPorCompra($datos)
    {
        $arreglo = [];
        $list = $this->buscar(['idcompra' => $datos['idcompra']]);
        if (count($list) > 0) {
            foreach ($list as $elem) {
                $nuevoElem = [
                    "pronombre" => $elem->getObjProducto()->getProNombre(),
                    "prodetalle" => $elem->getObjProducto()->getProDetalle(),
                    "precio" => $elem->getObjProducto()->getPrecio(),
                    "procantstock" => $elem->getCicantidad(),
                    "imagen" => $elem->getObjProducto()->getImagen()
                ];
                array_push($arreglo, $nuevoElem);
            }
        }
        return $arreglo;
    }
}
?>