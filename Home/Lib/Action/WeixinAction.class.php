<?php

class WeixinAction extends Action {
    private $token;
    private $fun;
    private $data = array();
    public $fans;
    private $my = '微信打印机';
    public $wxuser;
    public $apiServer;
    public function index(){
        if (!class_exists('SimpleXMLElement')){
            exit('SimpleXMLElement class not exist');
        }
        if (!function_exists('dom_import_simplexml')){
            exit('dom_import_simplexml function not exist');
        }
        $this -> token = $this -> _get('token', "htmlspecialchars");
        if(!preg_match("/^[0-9a-zA-Z]{3,42}$/", $this -> token)){
            exit('error token');
        }
        import("@.ORG.Wechat");

         $weixin = new Wechat($this -> token);
         $data = $weixin -> request();
         $this -> data = $weixin -> request();
         $RX_TYPE = trim( $this -> data['MsgType']);
        switch($RX_TYPE){
            case "text":
              /*  $result = $this->receiveText($this -> data);
                break;*/
            case "image":
                $result = $this->receiveImage( $this -> data);
                break;
        }
        echo $result;

    }
    //接收图片消息
    private function receiveImage($object)
    {

        // $content = array();

       /* $wcHelper=new wechatHelper();
        $wcHelper->inserPic($fromuser,$picurl);*/
        $content = array();
        $content[] = array("Title"=>"图片上传成功",  "Description"=>"图片上传成功，接下来可以打印此图片", "PicUrl"=>  $object['PicUrl'], "Url" =>"http://p.webs.dlwebs.com/index.php/zoom/".urlencode($object['PicUrl'])."?id=".$object['FromUserName']);

        $result = $this->transmitNews($object, $content);
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($xmlTpl, $object['FromUserName'], $object['ToUserName'], time(), count($newsArray));
        return $result;
    }

}