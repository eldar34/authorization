<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Auth;
use App\Validate;

$auth = new Auth();

if (isset($_GET['action'])) {
    if ($_GET['action'] == "out") {
        $result = $auth->logout();
        echo json_encode($result);
        exit;
    }
}

if (isset($_POST['staticEmail'])) {
    $login = $_POST['staticEmail'];
}
if (isset($_POST['inputPassword'])) {
    $pass = $_POST['inputPassword'];
}

$result = [];

$validate = new Validate();
$validEmail = $validate->forEmail('staticEmail', $login);
array_push($result, $validEmail);
$validPass = $validate->forPass('Pass', $pass, $pass);
array_push($result, $validPass);

$status_arr = array_column($result, 'status');

if (in_array('error', $status_arr)) {
    echo json_encode($result);
    exit;
}

if ($auth->login()) {
    $UID = $_SESSION['id'];

    $response['auth'] = 'login';
    $response['session_id'] = $UID;
    echo json_encode($response);
    exit;
} else {
    if (isset($_POST['log_in'])) {

        $error = $auth->enter($login, $pass); //функция входа на сайт

        if (count($error) == 0) //если ошибки отсутствуют, авторизируем пользователя
        {
            $UID = $_SESSION['id'];

            $response['auth'] = 'login';
            $response['session_id'] = $UID;
            echo json_encode($response);
            exit;

            // $admin = is_admin($UID);
        } else {
            $response['auth'] = 'logout';
            $response['errors'] = $error;
            echo json_encode($response);
            exit;
        }
    }
}
