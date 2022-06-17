<?php

namespace controllers\api;

use app\Controller;
use app\Request;
use models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        echo "Hai Detik ! cek readme ya!";
    }

    public function check()
    {
        $results = $this->init();
        $request = $_POST;

        //kita validasi dulu requestnya.
        //standar setiap controller kaya gini
        $validate = Request::validate($request, [
            'event_id' => 'required',
            'ticket_code' => 'required',
        ]);
        if ($validate->status) {
            //kalau valid baru isi mau ngapain.
            $param = $validate->data; //param yang udah di refactor jadi std object

            $model = new Ticket();
            $data = $model->show([
                'event_id' => $param->event_id,
                'ticket_code' => $param->ticket_code,
            ]);
            if (!empty($data)) {
                $results = $this->success($data);
            } else {
                $results = $this->failed("Data tidak ditemukan");
            }
        } else {
            $results = $this->validation_error($validate->data);
        }

        return $this->finish($results);
    }

    public function update()
    {
        $results = $this->init();
        $request = $_POST;

        //kita validasi dulu requestnya.
        //standar setiap controller kaya gini
        $validate = Request::validate($request, [
            'ticket_code' => 'required',
            'status' => 'required',
        ]);
        if ($validate->status) {
            //kalau valid baru isi mau ngapain.
            $param = $validate->data; //param yang udah di refactor jadi std object

            $model = new Ticket();
            $do = $model->change_status([
                'ticket_code' => $param->ticket_code,
                'status' => $param->status,
            ]);
            if ($do->status) {
                $results = $this->success($do->data, "Berhasil update status tiket");
            } else {
                $results = $this->failed("Data tidak ditemukan");
            }
        } else {
            $results = $this->validation_error($validate->data);
        }

        return $this->finish($results);
    }
}
