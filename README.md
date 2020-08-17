# dingtalk_robot
##### 钉钉机器人php库

#### 环境要求
- PHP 5.5+
- Composer

#### 安装
`composer require atishoo/dingtalk_robot`

#### 如何使用

###### 1.引入命名空间
`use Atishoo\DingtalkRobot;`

###### 2.实例化类
`$dingtalk = new DingtalkRobot($webhook);`
>  如安全验证为加签方式，可再次设置密钥    如安全验证为加签方式，可再次设置密钥
> `$dingtalk->setSecret(text);`
> 此方法同样支持链式调用，只需要在send()前设置即可。

###### 3.调用方法进行发送机器人消息
`$dingtalk->setText(text)->send();`

同理还支持其他格式的消息类型，使用方法类似，如下：
- $dingtalk->setText(text,[$atMobiles,$isAtAll])->send();
- $dingtalk->setLink(text,$title,$messageUrl,$picUrl)->send();
- $dingtalk->setMarkdown(text,$title)->send();
- $dingtalk->setActionCard(text,$title,$btns,$btnOrientation,$hideAvatar)->send();
- $dingtalk->setFeedcard($data)->send(); **必须包含title，messageURL，picURL的数组**
