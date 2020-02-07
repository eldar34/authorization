<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Validate;

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}


$result = [];

$validate = new Validate();
$validName = $validate->forName('staticName', $name);
array_push($result, $validName);

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

