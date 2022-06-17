<?php 

namespace app;

use stdClass;

class Request
{
    protected static function refactor($request) {
        $results = new stdClass();
        foreach($request as $key => $value) {
            $value = htmlspecialchars(stripslashes(trim($value))); //hilangin yang aneh-aneh  
            $results->$key = $value;
        }

        return $results;
    }

    protected static function field_label($value) {
        return str_replace("_", " ", ucwords($value));
    }

    public static function validate($request, $rules) {
        $results = new stdClass();
        $request = Self::refactor($request); //kita refactor dulu requestnya takut ada aneh-aneh

        $flag = true;
        $data = new stdClass();

        // Kita validasi disini, ini saya contoh laravel ada required, 
        // nanti bisa dikembangkan mungkin ada type data harus date, file dsb tapi gak keburu waktunya
        // jadi seadanya aja dlu
        if(!empty($rules)) {
            foreach($rules as $field => $rule) {
                if(strtolower($rule) == 'required') {
                    if(empty($request->$field)) {
                        $flag = false;
                        $data->$field = Self::field_label($field)." tidak boleh kosong !";
                    }
                }
            }    
        }

        $results->status = $flag;
        $results->data = (object) empty($data) ? $request : $data;
        return $results;
    }
}
