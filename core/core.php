<?php 

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class Controller {
    public $bot = false;
    public $keyboard = false;
    private $bot_api_key  = '7799299655:AAEGzGcRS9Cnj0-nFf9sGdVJGJudi0NwDdY'; // Token for bot
    public $controllers = [];
    public $update = [];
    public $callback_query = false;
    public function __construct(){
        $this->bot = new Api($this->bot_api_key);
        $this->keyboard = new Keyboard();
    }

    public function loadControllers(){
        $path = $_SERVER['DOCUMENT_ROOT'] . "/controllers";
        $files = scandir($path);
        foreach ($files as $file) {
            $this->controllers[] = str_replace(".php", "", $file);
        }
    }

    public function run(){
        global $routers;

        $this->update = $this->bot->getWebhookUpdate();

        if(isset($this->update['callback_query'])){
            $this->callback_query = true;
        }

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/test.ini", json_encode($this->update, JSON_UNESCAPED_UNICODE));
    }

    public function setDomain(){
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/domain.ini")){
            $this->bot->setWebhook(['url' => 'https://' . $_SERVER['SERVER_NAME'] . '/index.php']);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/domain.ini", $_SERVER['SERVER_NAME']);
        }
    }

    public function trashDomain(){
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/domain.ini") and !empty($_GET['trash_domain'])){
            $this->bot->removeWebhook();
            unlink($_SERVER['DOCUMENT_ROOT'] . "/data/domain.ini");
        }
    }

    public function inlineKeyBoard(){
        $keyboard = $this->keyboard->make()->inline();

        return $keyboard;
    }

    public function replyKeyBoard(){
        $keyboard = $this->keyboard->make()
        ->setResizeKeyboard(true)
		->setOneTimeKeyboard(true);

        return $keyboard;
    }
}