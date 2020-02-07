<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Auth;

$auth = new Auth();
$auth->loginAjax(); //функция входа на сайт