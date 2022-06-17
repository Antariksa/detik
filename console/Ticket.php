<?php

namespace console;

use models\Event;
use models\Ticket as model;

class Ticket
{
    public function generate($param)
    {
        $event_id = !empty($param[0]) ? intval($param[0]) : null;
        $total = !empty($param[1]) ? intval($param[1]) : null;

        if (!empty($event_id) && !empty($total)) {
            if ($total <= 999999) {
                $event = new Event();
                $event = $event->available(['event_id' => $event_id]);
                if ($event) {
                    $model = new model();
                    if ($model->generate($event_id, $total)) {
                        echo "Ciee berhasil generate " . $total;
                    } else {
                        echo "Terjadi kesalahan saat execute query";
                    }
                } else {
                    echo "Hayoo event idnya gak valid, cek lagi sana !";
                }
            } else {
                echo "Maaf dilimit 999999";
            }
        } else {
            echo "#\n";
            echo "#\n";
            echo "# Error: Parameter ada yang kurang pastikan event_id dan total tersedia";
            echo "# \n";
            echo "# \n";
        }
    }
}
