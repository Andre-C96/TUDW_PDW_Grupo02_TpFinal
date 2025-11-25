<?php
require_once __DIR__ . '/../Modelo/compraEstado.php';
require_once __DIR__ . '/../Modelo/compra.php';
require_once __DIR__ . '/../Modelo/compraEstadoTipo.php';

class CompraEstadoControl
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
     * Método ROBUSTO para cargar objeto
     * Acepta IDs u Objetos completos
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        // 1. Verificar si es Edición (viene ID) o Alta (Nuevo)
        if (array_key_exists('idcompraestado', $param) && $param['idcompraestado'] != null) {
            $obj = new CompraEstado();
            $obj->setID($param['idcompraestado']);
            if (!$obj->cargar()) {
                $obj = null;
            }
        } else {
            $obj = new CompraEstado();
        }

        if ($obj != null) {
            // --- CARGAR COMPRA ---
            $objCompra = null;
            if (array_key_exists('objcompra', $param) && is_object($param['objcompra'])) {
                $objCompra = $param['objcompra'];
            } elseif (array_key_exists('idcompra', $param) && $param['idcompra'] != null) {
                $objCompra = new Compra();
                $objCompra->setID($param['idcompra']);
                $objCompra->cargar();
            }
            if ($objCompra != null) {
                $obj->setObjCompra($objCompra);
            }

            // --- CARGAR TIPO DE ESTADO ---
            $objTipo = null;
            if (array_key_exists('objcompraestadotipo', $param) && is_object($param['objcompraestadotipo'])) {
                $objTipo = $param['objcompraestadotipo'];
            } elseif (array_key_exists('idcompraestadotipo', $param) && $param['idcompraestadotipo'] != null) {
                $objTipo = new CompraEstadoTipo();
                $objTipo->setID($param['idcompraestadotipo']);
                $objTipo->cargar();
            }
            if ($objTipo != null) {
                $obj->setObjCompraEstadoTipo($objTipo);
            }

            // --- FECHAS ---
            // Fecha Inicio: Si no viene, ponemos la actual
            if (array_key_exists('cefechaini', $param)) {
                $obj->setCeFechaIni($param['cefechaini']);
            } else {
                // Si es alta nueva y no trae fecha, ponemos NOW()
                if (!array_key_exists('idcompraestado', $param)) {
                    $obj->setCeFechaIni(date('Y-m-d H:i:s'));
                }
            }

           // Fecha Fin
            if (array_key_exists('cefechafin', $param)) {
                // Si viene el dato lo usamos.
                $obj->setCeFechaFin($param['cefechafin']);
            } else {
                // Si NO viene el parámetro ponemos null por defecto.
                // Si es MODIFICACIÓN (tiene ID), NO HACEMOS NADA (mantenemos el valor original de la BD).
                if ($obj->getID() == null) {
                    $obj->setCeFechaFin(null);
                }
            }
        }
        return $obj;
    }

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->setID($param['idcompraestado']);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraestado'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    // Mantenemos compatibilidad
    public function altaSinID($param) {
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
            if (isset($param['idcompraestado'])) {
                $where .= " and idcompraestado ='" . $param['idcompraestado'] . "'";
            }
            if (isset($param['idcompra'])) {
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            }
            if (isset($param['idcompraestadotipo'])) {
                $where .= " and idcompraestadotipo ='" . $param['idcompraestadotipo'] . "'";
            }
            if (isset($param['cefechaini'])) {
                $where .= " and cefechaini ='" . $param['cefechaini'] . "'";
            }
            if (isset($param['cefechafin'])) {
                $where .= " and cefechafin ='" . $param['cefechafin'] . "'";
            }
        }
        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }
}
?>