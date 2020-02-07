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
   

}