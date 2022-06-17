<?php
namespace console;

use app\Model;

class Init 
{
    public function migrate($param)
    {
        $model = new Model();
        $host = $model->host;
        $database_name = $model->database_name;
        $username = $model->username;
        $password = $model->password;
        $sql =  __DIR__ . '/../migrate/init.sql';
        
        $command = "mysql --user={$username} --password='{$password}' "
        . "-h {$host} -D {$database_name} < {$sql}";

        return shell_exec($command);
    }
}
