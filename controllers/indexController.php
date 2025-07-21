<?php 

class index extends Controller {
    public function start(){
        $this->bot->sendMessage([
            'chat_id' => $this->update['message']['chat']['id'],
            'text' => 'I\'m working!',
            'reply_markup' => $this->inlineKeyBoard()->row(
                $this->keyboard->inlineButton(['text' => 'Test', 'callback_data' => 'start'])
            )
        ]);
    }
    public function start2(){
        $this->bot->sendMessage([
            'chat_id' => $this->update['message']['chat']['id'],
            'text' => 'I\'m working!',
            'reply_markup' => $this->replyKeyBoard()->row(
                $this->keyboard->button('Test1'),
                $this->keyboard->button('Test2'),
            )
        ]);
    }

    public function test1(){
        $this->bot->sendMessage([
            'chat_id' => $this->update['message']['chat']['id'],
            'text' => 'Hello, this command is working!'
        ]);
    }
}