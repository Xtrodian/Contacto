<?php

// credenciales de la base de datos
define('DB_USUARIO', 'root');
define('DB_PASSWORD', 'pwdpwd');
define('DB_HOST', 'localhost');
define('DB_NOMBRE', 'crudcontacto');

$conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE );

// echo $conn->ping();