<?php

namespace models;

use app\Model;

class Ticket extends Model
{
    public $db = null;
    protected $table = "event_ticket";

    public function __construct(){
        $model = new Model();
        $this->db = $model;
    }
    public function generate($event_id, $total)
    {
        // saya pakai function karena dirasa generate kaya gini lebih effective di db langsung
        // saya coba 999999 data gak sampe 1 menit dilaptop saya (macos quadcore i5; ram8gb; ssd )
        $query = "call fn_ticket_generate({$event_id}, {$total})";
        $query = $this->db->do($query, []);
        return $query;
    }

    public function show($param)
    {
        $query = "
                    SELECT 
                        ticket_code, 
                        case when status >= 1 then 'available' else 'claimed' end as status
                    FROM {$this->table}
                ";
        $query = $this->db->query($query, $param);
        return !empty($query[0]) ? $query[0] : null;
    }

    public function change_status($param)
    {
        $query = "
                    UPDATE {$this->table} 
                    SET
                        status = :status
                    WHERE 
                        ticket_code = :ticket_code
                ";

        $query_aftersave = "
                    SELECT 
                        ticket_code, 
                        case when status >= 1 then 'available' else 'claimed' end as status,
                        updated_at
                    FROM {$this->table}
                ";
        $param_aftersave = ['ticket_code' => $param['ticket_code']];
            
        $query = $this->db->save($query, $param, $query_aftersave, $param_aftersave);

        return $query;
    }
}
