<?php

namespace app;

use PDO;
use stdClass;

class Model
{
    //saya buat public harusnya bikin file .env dan .env staging tapi gak sempet :D jadi disini aja lah
    public $host = "127.0.0.1";
    public $database_name = "tes";
    public $username = "root";
    public $password = "semuthitam";

    public $db = null;

    public function __construct()
    {
        $this->db = null;
        try {
            $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->db->prepare('SELECT * FROM ticket');
        } catch (\PDOException $exception) {
            echo "Tidak bisa konek db: " . $exception->getMessage();
        }

        return $this->db;
    }
    public function do($query, $param = [])
    {
        $do = $this->db->prepare($query);
        return $do->execute();
    }
    public function queryOne($query, $param = [])
    {
        $prepare = $this->where($query, $param);

        $do = $this->db->prepare($prepare->query);
        $do->execute($prepare->param);

        return $do->fetch(PDO::FETCH_OBJ);
    }

    public function query($query, $param = [])
    {
        $prepare = $this->where($query, $param);

        $do = $this->db->prepare($prepare->query);
        $do->execute($prepare->param);

        return $do->fetchAll(PDO::FETCH_OBJ);
    }

    public function where($query, $param)
    {
        $where = "";
        $where_param = [];

        $results = new stdClass();
        if (!empty($param)) {
            $where = " WHERE ";
            $i = 0;
            foreach ($param as $key => $value) {
                if ($i != 0) {
                    $where .= " AND ";
                }

                $where .= "(" . $key . " = ?)";
                array_push($where_param, $value);
                $i++;
            }
            $query .= $where;
        }


        $results->query = $query;
        $results->param = $where_param;
        return $results;
    }

    public function save($query, $param, $query_aftersave = null, $param_aftersave = null)
    {
        $results = new stdClass();
        $do = $this->db->prepare($query);

        $results->status = $do->execute($param);
        $results->data = Self::save_data($query_aftersave, $param_aftersave);

        return $results;
    }
    public function save_data($query, $param)
    {
        $results = null;

        if ($query != null) {
            $results = $this->queryOne($query, $param);
        }

        return $results;
    }
}
