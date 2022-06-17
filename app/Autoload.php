<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = $class . ".php";
    if (is_readable($file)) {
        require $file;
    } else {
        echo "Class Function tidak ada eui, cek lagi namespacenya bro! ";
        die();
    }
});
