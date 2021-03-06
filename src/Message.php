<?php
/**
 * Created by PhpStorm.
 * User: sliverwing
 * Date: 11/1/17
 * Time: 10:50 AM
 */

namespace Sliverwing\DingtalkBotChannel;


class Message
{
    protected $msgType;

    protected $atMobiles = [];

    protected $isAtAll = false;

    public $content;

    protected $text;

    protected $link;

    protected $picUrl;

    protected $messageUrl;

    public function text(string $content)
    {
        $this->msgType = 'text';
        $this->content = $content;
        return $this;
    }

    public function link(string $title, string $text, string $link,  string $messageUrl, string $picUrl='')
    {
        $this->msgType = 'link';
        $data = [];
        $data['title'] = $title;
        $data['text'] = $text;
        $data['link'] = $link;
        $data['picUrl'] = $picUrl;
        $data['messageUrl'] = $messageUrl;
        $this->content = $data;
        return $this;
    }

    public function markdown(string $title, string $text)
    {
        $this->msgType = 'markdown';
        $data = [];
        $data['title'] = $title;
        $data['text'] = $text;
        $this->content = $data;
        return $this;
    }

    public function actionCard(string $title, string $text, string $singleTitle, string $singleURL, string $btnOrientation = '0', string $hideAvatar = '0')
    {
        $this->msgType = 'actionCard';
        $data = [];
        $data['title'] = $title;
        $data['text'] = $text;
        $data['singleTitle'] = $singleTitle;
        $data['singleURL'] = $singleURL;
        $data['btnOrientation'] = $btnOrientation;
        $data['hideAvatar'] = $hideAvatar;
        $this->content = $data;
        return $this;
    }

    public function feedCard(array $cards)
    {
		$this->msgType = 'feedCard';
//    	TODO: add validation
	    $data['links'] = $cards;
	    $this->content = $data;
	    return $this;
    }

    public function at(array $mobiles, bool $isAtAll)
    {
        $this->atMobiles = $mobiles;
        $this->isAtAll = $isAtAll;
        return $this;
    }

    public function getMsgType()
    {
        return $this->msgType;
    }

    public function getAtMobiles()
    {
        return $this->atMobiles;
    }

    public function getIsAtAll()
    {
        return $this->isAtAll;
    }
}