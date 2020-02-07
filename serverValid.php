<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Validate;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
if (isset($_POST['surname'])) {
    $surname = $_POST['surname'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}


$result = [];

$validate = new Validate();
$validName = $validate->forName('staticName', $name);
array_push($result, $validName);
$validSurname = $validate->forName('staticSurname', $surname);
array_push($result, $validSurname);
$validEmail = $validate->forEmail('staticEmail', $email);
array_push($result, $validEmail);

$status_arr = array_column($result, 'status');


if (in_array('error', $status_arr)) {
    echo json_encode($result);
    exit;
}else {
    $result['status'] = 'success';
    $result['fieldName'] = 'staticName';
    echo json_encode($result);
    exit;
} 

