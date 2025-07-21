<?php 
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . "/data/log_error.txt");
ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'core/routers.php';
require 'core/core.php';

$controller = new controller();

$controller->setDomain();

$controller->run();

$command = '';
if($controller->callback_query){
    $command = 'command:' . $controller->update['callback_query']['data'];
    $controller->update = $controller->update['callback_query'];
} else {
    $command = $controller->update['message']['text'];
}

if(!isset($routers[$command])){
    $controller->bot->sendMessage([
        'chat_id' => $controller->update['message']['chat']['id'],
        'text' => 'This command is not exists :)'
    ]);
} else {
    list($class, $func) = explode("|", $routers[$command]);

    include_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/" . $class . "Controller.php";

    $Cont = new $class;

    $controller->loadControllers();

    $Cont->run();

    if($Cont->callback_query){
        $Cont->update = $Cont->update['callback_query'];
    }

    if(!method_exists($class, $func)){
        $controller->bot->sendMessage([
            'chat_id' => $contrller->update['message']['chat']['id'],
            'text' => 'Error write to admin!'
        ]);
    } else {
        $Cont->$func();
    }
}