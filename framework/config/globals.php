<?php

define('LIB', 'lib/');
define('MODEL', 'application/'.$_GET['mod'].'/model/');
define('VIEW', 'application/'.$_GET['mod'].'/view/');
define('CONTROLLER', 'application/'.$_GET['mod'].'/controller/');
define('FRAMEWORK', 'framework/');

define('LOCALHOST', ($_SERVER['HTTP_HOST'] == 'localhost'));
