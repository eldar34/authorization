<?php

namespace App;

class Connection {
    private $host='';
    private $db='';
    private $myname='eldar';
    private $psc='';
    private $dsn = "";

    private $opt = array(
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    );

    public function dbConnect(){
        $this->dsn = "mysql:host=$this->host;dbname=$this->db";
        $pdo = new \PDO($this->dsn, $this->myname, $this->psc, $this->opt);
        return $pdo;
    }
}




?>