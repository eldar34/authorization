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
}
