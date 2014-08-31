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
       // $weixin = new Wechat($this -> token);
    }

}