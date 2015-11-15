<?php

namespace Core;

class Database extends Service{
    private $db;
    private $dbname;
    private $user;
    private $password;
    private $host;
    private $error;

    function __construct($dbname, $user, $password, $host) {
       $this->dbname = $dbname;
       $this->user = $user;
       $this->password = $password;
       $this->host = $host;

       $this->open();
    }

    public function open() {
        $this->db = new \PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->password);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

        if($this->db){
            return true;
        }

        return false;
    }

    public function close() {
      $this->db = null;
      return true;
    }


    public function query($query, $params = array(), $fetch = true) {
        $this->error = null;
        try {
            $stmt = $this->db->prepare($query);
            if($stmt->execute($params)) {

                if ($fetch && $stmt->rowCount() > 0) {
                    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    return $rows;
                }

                return true;
            } else {
                $this->error = $this->db->errorInfo();
            }
        } catch(\PDOException $ex) {
            $this->error = $ex->getMessage();
        }

        return false;
    }

    function getError() {
        return $this->error;
    }

    function lastId() {
        return $this->db->lastInsertId();
    }

    function begin() {
        $this->db->beginTransaction();
    }

    function end() {
        $this->db->commit();
    }
}
