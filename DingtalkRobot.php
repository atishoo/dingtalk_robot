<?php

defined('BASEPATH') OR exit('No direct script access allowed');

namespace Atishoo;


/**
 * 钉钉机器人类库
 *
 * 构造方法传入webhook即可
 *
 * 使用方法setText()->send()为发送文本消息
 * 使用方法setLink()->send()为发送超文本消息
 * 使用方法setMarkdown()->send()为发送makrdown消息
 * 使用方法setFeedcard()->send()为发送多媒体消息
 * 
 */
class DingtalkRobot {

    private $_web_hook='';

    private $_MESSAGE = array('msgtype'=>'text');

    public function __construct($webhook)
    {
        $this->_web_hook = $webhook;
    }

    /**
     * 设置消息类型
     * @param integer $type [description]
     */
    private function setMsgType($type = 1)
    {
        switch (intval($type)) {
            case 1:
            default:
                $this->_MESSAGE['msgtype'] = 'text';
                break;

            case 2:
                $this->_MESSAGE['msgtype'] = 'link';
                break;

            case 3:
                $this->_MESSAGE['msgtype'] = 'markdown';
                break;

            case 4:
                $this->_MESSAGE['msgtype'] = 'actionCard';
                break;

            case 5:
                $this->_MESSAGE['msgtype'] = 'feedCard';
                break;
        }
    }

    public function setText($text='', $atMobiles = array(), $isAtAll = false)
    {
        $this->setMsgType(1);
        $this->_MESSAGE['text'] = array('content'=>$text);
        // $this->_MESSAGE['at'] = array('atMobiles'=>array(),'isAtAll'=>false);
        if (!empty($atMobiles)) {
            $this->_MESSAGE['at']['atMobiles'] = $atMobiles;
        }

        if ($isAtAll) {
            $this->_MESSAGE['at']['isAtAll'] = true;
        }

        return $this;
    }

    public function setLink($text='', $title = '', $messageUrl = '', $picUrl = '')
    {
        $this->setMsgType(2);

        if (empty($text)) {
            return '内容不能为空';
        }else{
            $this->_MESSAGE['link']['text'] = $text;
        }

        if (empty($title)) {
            return '标题不能为空';
        }else{
            $this->_MESSAGE['link']['title'] = $title;
        }

        if (empty($messageUrl)) {
            return '跳转链接不能为空';
        }else{
            $this->_MESSAGE['link']['messageUrl'] = $messageUrl;
        }

        if (!empty($picUrl)) {
            $this->_MESSAGE['link']['picUrl'] = $text;
        }

        return $this;
    }

    public function setMarkdown($text='', $title = '')
    {
        $this->setMsgType(3);

        if (empty($text)) {
            return '内容不能为空';
        }else{
            $this->_MESSAGE['markdown']['text'] = $text;
        }

        if (empty($title)) {
            return '标题不能为空';
        }else{
            $this->_MESSAGE['markdown']['title'] = $title;
        }

        return $this;
    }

    /**
     * 设置多媒体消息
     * @param array $data 必须包含title，messageURL，picURL的数组
     */
    public function setFeedcard($data)
    {
        $this->setMsgType(5);
        $this->_MESSAGE['feedCard']['links'] = $data;

        return $this;
    }

    /**
     * 发送短信
     *
     * @param string $needstatus    是否需要状态报告
     */
    public function send($needstatus = 1) {
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $this->_web_hook);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 跳过服务器检查
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->_MESSAGE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if (array_key_exists('errcode', $result) && $result['errcode'] == 0) {
            return true;
        }else{
            return false;
        }
    }
}?>