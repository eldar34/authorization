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
if (isset($_POST['password'])) {
    $pass = $_POST['password'];
}
if (isset($_POST['confpass'])) {
    $confpass = $_POST['confpass'];
}


$result = [];

$validate = new Validate();
$validName = $validate->forName('staticName', $name);
array_push($result, $validName);
$validSurname = $validate->forName('staticSurname', $surname);
array_push($result, $validSurname);
$validEmail = $validate->forEmail('staticEmail', $email);
array_push($result, $validEmail);
$validPass = $validate->forPass('Pass', $pass, $confpass);
array_push($result, $validPass);

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

