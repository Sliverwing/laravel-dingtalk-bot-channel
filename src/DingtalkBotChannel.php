<?php

namespace Sliverwing\DingtalkBotChannel;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Sliverwing\DingtalkBotChannel\Exceptions\CouldNotSendMessageException;

class DingtalkBotChannel
{

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     */
    public function send($notifiable, Notification $notification)
    {

        if (empty(Config::get('dingtalk.bot.token')))
        {
            throw CouldNotSendMessageException::tokenIsRequired();
        }

        $url = 'https://oapi.dingtalk.com/robot/send?access_token=' . Config::get('dingtalk.bot.token');

        $body = $this->buildRequestPayload(
            $notification->toDingtalkBot($notifiable)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($resp);
        if ($data->errcode != 0)
        {
            throw CouldNotSendMessageException::responseError($data->errcode, $data->errmsg);
        }

    }

    public function buildRequestPayload(Message $message)
    {
        $data = [];
        switch ($message->getMsgType())
        {
            case 'text':
                $data['msgtype'] = 'text';
                $data['text']['content'] = $message->content;
                $data['at']['atMobiles'] = $message->getAtMobiles();
                $data['at']['isAtAll'] = $message->getIsAtAll();
                break;
            case 'link':
                $data['msgtype'] = 'link';
                $data['link'] = $message->content;
                break;
            case 'markdown':
                $data['msgtype'] = 'markdown';
                $data['markdown'] = $message->content;
                $data['at']['atMobiles'] = $message->getAtMobiles();
                $data['at']['isAtAll'] = $message->getIsAtAll();
        }
        return json_encode($data);
    }

}