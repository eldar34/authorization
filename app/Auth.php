<?php

namespace App;

use App\Connection;

class Auth
{
    public function enter($login, $pass)
    {
        $connection = new Connection();
        $pdo = $connection->dbConnect();

        // $result = $pdo->query("SELECT password FROM users WHERE email='$login'");
        // $myrow = $result->fetch();

        $error = array(); //массив для ошибок   
        if ($login != "" && $pass != "") //если поля заполнены    
        {
            $login = $login;
            $password = $pass;

            $rez = $pdo->query("SELECT * FROM users WHERE email='$login'"); //запрашивается строка из базы данных с логином, введённым пользователем      
            if ($rez->rowCount() == 1) //если нашлась одна строка, значит такой юзер существует в базе данных       
            {
                $myrow = $rez->fetch();
                $newPassword = md5($password . $myrow['salt']);
                if ($newPassword == $myrow['password']) //сравнивается хэшированный пароль из базы данных с хэшированными паролем, введённым пользователем                        
                {
                    //пишутся логин и хэшированный пароль в cookie, также создаётся переменная сессии
                    $userName = str_replace(['@', '.'], [2, 1], $myrow['email']);
                    
                    setcookie("login", $userName, time() + 3600, '/');
                    setcookie("password", $myrow['password'], time() + 3600, '/');
                    $_SESSION['id'] = $myrow['id'];   //записываем в сессию id пользователя               

                    $id = $_SESSION['id'];

                    $this->lastAct($id);

                    return $error;
                } else //если пароли не совпали           

                {
                    $error[0] = "Wrong password";
                    $error[1] = "Неверный пароль";                    
                    return $error;
                }
            } else //если такого пользователя не найдено в базе данных        

            {
                $error[0] = "Wrong login or password";
                $error[1] = "Неверный логин и пароль";                
                return $error;
            }
        } else {
            $error[0] = "Fields must not be empty!";
            $error[1] = "Поля не должны быть пустыми!";            
            return $error;
        }
    }

    public function lastAct($id)
    {
        $connection = new Connection();
        $pdo = $connection->dbConnect();

        $tm = date('Y-m-d H:i:s');

        $pdo->query("UPDATE users SET online='$tm', last_act='$tm' WHERE id='$id'");
    }

    public function login()
    {
        $connection = new Connection();
        $pdo = $connection->dbConnect();

        ini_set("session.use_trans_sid", true);
        session_start();

        if (isset($_SESSION['id'])) //если сесcия есть   
        {
            if (isset($_COOKIE['login']) && isset($_COOKIE['password']))
            //если cookie есть, обновляется время их жизни и возвращается true      
            {
                SetCookie("login", "", time() - 1, '/');
                SetCookie("password", "", time() - 1, '/');

                setcookie("login", $_COOKIE['login'], time() + 3600, '/');
                setcookie("password", $_COOKIE['password'], time() + 3600, '/');

                $id = $_SESSION['id'];
                $this->lastAct($id);

                return true;
            } else
            //иначе добавляются cookie с логином и паролем, чтобы после перезапуска браузера сессия не слетала         
            {
                $rez = $pdo->query("SELECT * FROM users WHERE id='{$_SESSION['id']}'");
                //запрашивается строка с искомым id 
                $rez->fetch();

                if ($rez->rowCount() == 1) //если получена одна строка         
                {
                    $myrow = $rez->fetch(); //она записывается в ассоциативный массив               

                    setcookie("login", $myrow['email'], time() + 3600, '/');
                    setcookie("password", $myrow['password'], time() + 3600, '/');

                    $id = $_SESSION['id'];
                    $this->lastAct($id);

                    return true;
                } else return false;
            }
        } else
        //если сессии нет, проверяется существование cookie. 
        //Если они существуют, проверяется их валидность по базе данных     
        {
            if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) //если куки существуют  
            {
                $userName = str_replace(['2', '1'], ['@', '.'], $_COOKIE['login']);

                $rez = $pdo->query("SELECT * FROM users WHERE email='$userName'");
                //запрашивается строка с искомым логином и паролем             
                $myrow = $rez->fetch();

                if ($rez->rowCount() == 1 && $myrow['password'] == $_COOKIE['password'])
                //если логин и пароль нашлись в базе данных           
                {
                    $_SESSION['id'] = $myrow['id']; //записываем в сесиию id              
                    $id = $_SESSION['id'];

                    $this->lastAct($id);

                    return true;
                } else //если данные из cookie не подошли, эти куки удаляются             
                {
                    SetCookie("login", "", time() - 360000, '/');
                    SetCookie("password", "", time() - 360000, '/');

                    return false;
                }
            } else //если куки не существуют      
            {
                return false;
            }
        }
    }
}
