<?php

namespace models;

use app\Model;

class Event extends Model
{
    public $db = null;
    protected $table = "event";

    public function __construct(){
        $model = new Model();
        $this->db = $model;
    }

    public function available($param)
    {
        $query = "
                    SELECT 
                        count(event_id) as total 
                    FROM {$this->table}
                ";
        $query = $this->db->queryOne($query, $param);
        return ($query->total > 0) ? true : false;
    }

}
