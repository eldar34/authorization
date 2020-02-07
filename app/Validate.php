<?php


namespace App;


class Validate
{
    public function forName($fieldName, $props){
        $response = [];
        $errors = [];
        $len = strlen($props);

        if($len<=250){
            if(preg_match('/^[a-zA-Zа-яА-Я]+$/ui', $props)){
                $response['status'] = 'success';
                $response['field'] = $fieldName;
                return $response;
            }else{
                array_push($errors,' must be string');
                array_push($errors,' должно быть строкой');
                $response['status'] = 'error';
                $response['field'] = $fieldName;
                $response['errors'] = $errors;
                return $response;
            }
        }else{
            array_push($errors,' must be string <= 250 chars');
            array_push($errors,' строка должна содержать меньше 250 символов');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }
    }

    public function forEmail($fieldName, $props){
        $response = [];
        $errors = [];

        if (filter_var($props, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'success';
            $response['field'] = $fieldName;
            return $response;
        }else {
            array_push($errors,' not valid');
            array_push($errors,' не валидно');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }
    }

    public function forPass($fieldName, $props, $conf){
        $response = [];
        $errors = [];

        if($props == $conf){
            if(preg_match('/^(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{4,12}$/', $props)){
                //^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,12}$
                $response['status'] = 'success';
                $response['field'] = $fieldName;
                return $response;
            }else{
                array_push($errors,' length must be more then 4, with chars(a-Z) and numbers(0-9)');
                array_push($errors,' должен быть длинее 4 символов и содержать буквы(a-Z) и цифры(0-9)');
                $response['status'] = 'error';
                $response['field'] = $fieldName;
                $response['errors'] = $errors;
                return $response;
            }
        }else{
                array_push($errors,' doesnt much');
                array_push($errors,' не совпадают');
                $response['status'] = 'error';
                $response['field'] = $fieldName;
                $response['errors'] = $errors;
                return $response;
        }      
    }
    
    public function forImage($fieldName, $fileTmpPath, $fileName, $fileSize, $fileType='image/png'){

        $response = [];
        $errors = [];        

        if($fileSize > 4194304){
            array_push($errors,' file must be smaller than 4мб');
            array_push($errors,' файл должен быть меньше 4мб');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }

        $allowedfileTypes = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
        if (!in_array($fileType, $allowedfileTypes)){
            array_push($errors,' file must be format(jpg, gif, png)');
            array_push($errors,' файл должен быть фомата(jpg, gif, png)');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }

        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = array('jpg', 'gif', 'png');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            array_push($errors,' file must be format(jpg, gif, png)');
            array_push($errors,' файл должен быть фомата(jpg, gif, png)');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }

        $response['status'] = 'success';
        $response['field'] = $fieldName;
        return $response;       
    }

}