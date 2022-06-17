<?php

namespace app;

use stdClass;

class Route
{

    private static $routes = [];

    public static function go()
    {
        $flag = false;
        $url = '/';
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $function = [];

        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        if (isset($parsed_url['path'])) {
            $url = $parsed_url['path'];
        }


        foreach (self::$routes as $route) {
            if ($url == $route->url && $method == $route->method) {
                $function = $route->function;
                $flag = true;
                break;
            }
        }

        if ($flag) {
            $results = Self::render(call_user_func($function));
        } else {
            $results = Self::render_not_found();
        }

        return $results;
    }

    protected static function render($data)
    {
        return $data;
    }
    protected static function render_not_found()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("HTTP/1.0 404 Not Found");

        $data = [
            "status" => 0,
            "message" => [
                "title" => 'Halaman tidak ditemukan',
                "body" => 'Cek lagi deh kayanya urlnya salah bro!',
            ],
            "data" => null
        ];
        echo json_encode($data);
    }

    public static function get($url, $function)
    {
        $data = new stdClass();
        $data->url = $url;
        $data->function = $function;
        $data->method = 'get';

        array_push(self::$routes, $data);
    }

    public static function post($url, $function)
    {
        $data = new stdClass();
        $data->url = $url;
        $data->function = $function;
        $data->method = 'post';

        array_push(self::$routes, $data);
    }
}
