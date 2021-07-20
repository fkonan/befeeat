<?php

define('DEBUG', true);

// define('DB_NAME', 'fohm2019_carnets'); // base de datos
// define('DB_USER', 'fohm2019_lacteos');    // usuario
// define('DB_PASSWORD', '*lacteos2019*');    // password
// define('DB_HOST', 'mysql1006.mochahost.com'); // hosting

define('DB_NAME', 'beefeat'); // base de datos
define('DB_USER', 'root');    // usuario
define('DB_PASSWORD', '');    // password
define('DB_HOST', 'localhost'); // hosting


define('DEFAULT_CONTROLLER', 'Home');
define('DEFAULT_LAYOUT', 'index_admin');

define('PROOT', '/beefeat/');
define('VERSION', '0.1');
define('LOGO', 'http://localhost/beefeat/');


define('SITE_TITLE', 'Beefeat');
define('MENU_BRAND', 'Beefeat');

define('CURRENT_USER_SESSION_NAME', 'beefeatkwXeusqldkiIKjehsLQZJFKJ');
define('REMEMBER_ME_COOKIE_NAME', 'beefeatJAJEI6382LSJVlkdjfh3801jvD');
define('REMEMBER_ME_COOKIE_EXPIRY', 2592000);

define('ACCESS_RESTRICTED', 'Restricted');

define(
   'UNIDAD_MEDIDA',
   [
      'UNIDAD' => 'UNIDAD',
      'GRAMOS' => 'GRAMOS',
      'LIBRA' => 'LIBRA',
      'KILOGRAMO' => 'KILOGRAMO',
      'LITRO' => 'LITRO'
   ]
);
define(
   'TIPOS_DOCUMENTO',
   [
      'Registro Civil' => 'Registro Civil',
      'Tarjeta de Identidad' => 'Tarjeta de Identidad',
      'Cédula de Ciudadanía' => 'Cédula de Ciudadanía',
      'Nit' => 'Nit',
      'Cédula Extranjera' => 'Cédula Extranjera',
      'Pasaporte' => 'Pasaporte'
   ]
);
define(
   'ROLES',
   [
      'administrador' => 'Administrador',
      'jefe_produccion' => 'Jefe Producción',
      'por_definir' => 'Por definir',
      'vendedor' => 'Vendedor'
   ]
   );
define(
   'TIPO_PERSONA',
   [
      'NATURAL' => 'NATURAL',
      'JURÍDICA' => 'JURÍDICA'
   ]
);

define("SMTP_HOST", "mail.beefeat.org");
define('SMTP_PORT', 26);
define('SMTP_SECURE', 'tls');
define("SMTP_USERNAME", "soporte@beefeat.org");
define("SMTP_PASSWORD", "beefeat");
define("SMTP_FROM", "soporte@beefeat.org");
define("SMTP_FROM_NAME", "Beefeat");
