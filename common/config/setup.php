<?php
use Dotenv\Dotenv;

//echo 2333;
//echo '<script>alert("'. __DIR__ . '")</script>';
//echo '<script>alert("'.getenv('DB_NAME'). '")</script>';

// __DIR__表示加载的.env文件所在的目录
$dotenv = new Dotenv(__DIR__);
$dotenv->load();
define("DEBUG_MODE", getenv("DEBUG_MODE"));
//pd(getenv('DB_NAME'));
//var_dump(23,getenv('DB_NAME'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME' ,getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));

define('AF_DB_HOST', getenv('AF_DB_HOST'));
define('AF_DB_NAME', getenv('AF_DB_NAME'));
//pd(getenv('DB_USER'));

function pd(){
    echo '<pre>'.PHP_EOL;
    for($i=0;$i<func_num_args();$i++){
        echo '---------------'.($i+1).'---------------'.PHP_EOL;
        print_r(func_get_arg($i));
        echo PHP_EOL;
    }
    echo '</pre>';
    die;
}

function pd_var(){
    echo '<pre>'.PHP_EOL;
    for($i=0;$i<func_num_args();$i++){
        echo '---------------'.($i+1).'---------------'.PHP_EOL;
        var_dump(func_get_arg($i));
        echo PHP_EOL;
    }
    echo '</pre>';
    die;
}
