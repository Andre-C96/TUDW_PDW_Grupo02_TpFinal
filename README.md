👥 Autores (Grupo 2)

Andrea Crespillo	
Lautaro Mellado	
Ramiro Navarrete	
Linda Cristal Parra Sanhueza	

Trabajo realizado para la cátedra de Programación Web Dinámica - FAI-UNCO.


🎄 ChristmasMarket - E-Commerce PHP MVC
Este proyecto es el Trabajo Final Integrador para la materia Programación Web Dinámica. Consiste en el desarrollo de una tienda en línea completa (Carrito de Compras) implementando una arquitectura MVC (Modelo-Vista-Controlador) robusta, gestión de usuarios, roles dinámicos y flujo de compras.

📋 Descripción del Proyecto
ChristmasMarket es una aplicación web que permite la gestión integral de un comercio electrónico con dos vistas principales:

Vista Pública (Tienda):

Catálogo de productos visible para cualquier visitante.

Información de contacto.

Acceso al Login.

Vista Privada (Usuarios Registrados):

Cliente: Puede gestionar su perfil, agregar productos al carrito, gestionar cantidades, vaciar carrito y finalizar compras. Recibe notificaciones por correo electrónico.

Administrador: Panel de control completo para gestionar Usuarios, Roles, Productos (ABM, Stock, Imágenes), y Menús Dinámicos. Puede supervisar y cambiar el estado de las ventas.

Tecnologías Utilizadas:
El proyecto fue construido utilizando tecnologías estándar y librerías modernas para extender la funcionalidad de PHP.

Lenguaje: PHP 8+ (Arquitectura MVC Estricta)

Base de Datos: MySQL 

Frontend: HTML5, CSS3, Bootstrap 5 

Servidor Web: Apache (XAMPP/WAMP)

Librerías Externas (Composer)
Symfony Mailer: Para el envío de notificaciones de compra y actualizaciones de estado.

Carbon: Para la gestión avanzada y formateo de fechas y zonas horarias.

FPDF: Para la generación dinámica de comprobantes de compra en PDF.

⚙️ Arquitectura y Diseño
Se implementó una arquitectura MVC pura con separación estricta de responsabilidades:

Modelo: Clases que representan las tablas de la BD (Compra, Producto, Usuario) y manejan la lógica de datos y consultas SQL específicas.

Control: Capa lógica que orquesta las operaciones (CompraControl, UsuarioControl). Se implementaron patrones de diseño para evitar lógica de negocio en las vistas.

Vista: Interfaz de usuario limpia y responsiva.

Acción: Scripts delgados ("Thin Action") que solo reciben peticiones, invocan al controlador y redirigen, sin contener lógica de negocio.

✨ Funcionalidades Destacadas
🛒 Módulo de Compras
Carrito Persistente: El carrito se guarda en base de datos, permitiendo al usuario retomar su compra luego.

Control de Stock: Validación en tiempo real antes de finalizar la compra. Descuento automático de stock.

Estados de Compra: Flujo completo: Iniciada (Carrito) -> Aceptada -> Enviada -> Cancelada.

Notificaciones: Envío automático de emails al confirmar compra o cambiar de estado.

🛠️ Módulo de Administración
Gestión de Menú Dinámico: El administrador puede crear ítems de menú y asignarles permisos (Roles) desde el panel, sin tocar código.

ABM de Productos: Carga de productos con subida de imágenes, edición de stock y deshabilitado lógico (soft delete).

Gestión de Ventas: Visualización de todas las ventas y cambio de estado con un clic.

🔒 Seguridad y Sesiones
Manejo de Sesiones: Clase Session personalizada para login, logout y control de inactividad.

Roles y Permisos: Sistema escalable de permisos (menurol) que decide qué opciones ve cada usuario.

Protección: Hashing de contraseñas y validación de acceso en cada controlador.

📦 Instalación y Despliegue
Sigue estos pasos para levantar el proyecto en tu entorno local:

Clonar el repositorio:

Bash

git clone https://github.com/Andre-C96/TUDW_PDW_Grupo02_TpFinal.git
Base de Datos:

Crea una base de datos llamada bdcarritocompras en phpMyAdmin.

Importa el archivo SQL ubicado en sql/bdcarritocompras.sql.

Dependencias:

Asegurarse de tener Composer instalado.

Ejecutar el siguiente comando en la raíz del proyecto para instalar las librerías:

Bash

composer install
Configuración:

Revisa el archivo config.php (si existe) o Control/Conector/BaseDatos.php para ajustar las credenciales de tu base de datos.

Configura las credenciales SMTP en Util/EmailService.php o config.php para que funcionen los correos.

Ejecutar:

Abrir el navegador y ve a http://localhost/TUDW_PDW_Grupo02_TpFinal/Vista/index.php
