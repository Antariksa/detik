<?php

namespace app;

//saya buat ini biar standar setiap api sama, kalau ada perubahan tinggal ubah disini. 
// terkadang mobile developer ada request tertentu dan kadang beda tim beda request :D jadi buat standarnya aja dlu
class Controller
{
    // Helper : 
    protected function response($results = null, $code = 200)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($code);
        echo json_encode($results);
    }

    protected function results($status, $message = null, $data = null)
    {
        $message = $this->results_message($message);

        //mobile developer kadang ada yang minta form validasi bentuknya text
        //ada juga yang object, jadi saya buat 2 standar responnya
        //body buat text 
        //detail buat object
        $results = [
            'status' => $status,
            'message' => [
                'title' => $message['title'],
                'body' => $message['body'], 
                'detail' => $message['detail'],
            ],
            'data' => $data,
        ];
        return $results;
    }

    protected function results_message($message)
    {
        $results = [];
        $results['title'] = null;
        $results['body'] = null;
        $results['detail'] = [];

        if (is_array($message)) {
            $results['title'] = !empty($message['title']) ? $message['title'] : null;
            $results['body'] = !empty($message['body']) ? $message['body'] : null;
            $results['detail'] = !empty($message['detail']) ? $message['detail'] : [];
        } else if (is_string($message)) {
            $results['title'] = $message;
        }

        return $results;
    }

    // BaseController : 
    public function init($message = null, $data = null)
    {
        return $this->results(1, $message, $data);
    }

    public function success($data = null, $message = null)
    {
        return $this->results(1, $message, $data);
    }

    public function failed($message = null, $data = null)
    {
        return $this->results(0, $message, $data);
    }

    public function validation_error($message_detail = null, $message_title = "Silahkan cek kembali form input anda!")
    {
        $message = [
            'title' => $message_title,
            'body' => $this->message_detail_format($message_detail),
            'detail' => $message_detail,
        ];
        return $this->results(0, $message);
    }

    public function finish($results)
    {
        $code = empty($results['code']) ? 200 : $results['code'];
        return $this->response($results, $code);
    }

    protected function message_detail_format($message_detail)
    {
        $body = "";
        if (is_object($message_detail)) {
            $i = 0;
            foreach ($message_detail as $row) {
                $i++;
                $body .= $i . ". " . $row . " <br>";
            }
        } else if (is_array($message_detail)) {
            $i = 0;
            foreach ($message_detail as $row) {
                $i++;
                $txt = "";

                if (is_array($row)) {
                    foreach ($row as $r) {
                        $txt .= $r . " ";
                    }
                } else {
                    $txt = $row;
                }

                $body .= $i . ". " . $txt . " <br>";
            }
        } else if (is_string($message_detail)) {
            $body = $message_detail;
        }

        return $body;
    }

}
