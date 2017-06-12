# dingtalk_robot
##### 钉钉机器人php库

###### 如何使用

1.引入命名空间
use Atishoo;

2.实例化类
$a = new DingtalkRobot($webhook);

3.调用方法进行发送机器人消息
$a->setText(text)->send();
