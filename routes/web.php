<?php

$router->get('/', 'HomeController', 'index');
$router->get('productos', 'ProductoController', 'index');
$router->post('productos/guardar', 'ProductoController', 'guardar');
$router->post('productos/actualizar', 'ProductoController', 'actualizar');
$router->post('productos/eliminar', 'ProductoController', 'eliminar');
$router->get('ventas', 'VentaController', 'index');
$router->get('clientes', 'ClienteController', 'index');
$router->get('proveedores', 'ProveedorController', 'index');
$router->post('proveedores/guardar', 'ProveedorController', 'guardar');
$router->post('proveedores/actualizar', 'ProveedorController', 'actualizar');
$router->post('proveedores/eliminar', 'ProveedorController', 'eliminar');
$router->get('reportes', 'ReporteController', 'index');
$router->get('usuarios', 'UsuarioController', 'index');
$router->post('usuarios/guardar', 'UsuarioController', 'guardar');
$router->post('usuarios/actualizar', 'UsuarioController', 'actualizar');
$router->post('usuarios/eliminar', 'UsuarioController', 'eliminar');