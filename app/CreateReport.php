<?php

namespace App;

use App\Connection;

class CreateReport
{
    public function addFile($fileTmpPath, $fileName, $fileSize, $fileType)
    {
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = array('jpg', 'gif', 'png');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // directory in which the uploaded file will be moved
            $uploadFileDir = './uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $result = './uploaded_files/' . $newFileName;
                return $result;
            } else {
                $result = './uploaded_files/none.jpg';
                return $result;
            }
        }
    }

    public function addRecord($name, $surname, $email, $pass, $filePath)
    {
        $response = [];
        $errors = [];
        try {
                $salt = time();
                $newPassword = md5($pass.$salt);
                $connection = new Connection();
                $pdo = $connection->dbConnect();
                $pdo->beginTransaction();
                $pdo->exec("INSERT INTO users (name, surname, email, password, file, salt) 
                VALUES ('$name', '$surname', '$email', '$newPassword', '$filePath', '$salt')");
                $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();

            if ($e->getCode() == '23000') {
                array_push($errors, ' already registered');
                array_push($errors, ' уже зарегестрирован');
                $response['status'] = 'error';
                $response['field'] = 'staticEmail';
                $response['errors'] = $errors;
                return $response;
                exit;
            }
            //array_push($errors, "Ошибка: " . $e->getMessage());
            //array_push($errors, "Error");
            array_push($errors, ' error writing to database');
            array_push($errors, ' ошибка записи в базу данных');
            $response['status'] = 'error';
            $response['field'] = 'staticDB';
            $response['errors'] = $errors;
            return $response;
            exit;
        }
        $response['status'] = 'success';
        $response['field'] = 'staticDB';
        return $response;
        exit;
    }
}
