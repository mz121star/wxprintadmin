<?php

class PrintsetAction extends Action {

    public function zoom(){
        import("@.ORG.imageHelper");
         $uid=$this->_get("picurl");
        $picurl=$_GET("picurl");
      /*  $wcHelper=new wechatHelper();
        $fromuser= $_GET["id"];
        //  echo "执行getPicByUID:".date("Y-m-d H:i:s",time());
        $picurl=$wcHelper->getPicByUID($fromuser);
        //$picurl='http://deepliquid.com/Jcrop/demos/demo_files/pool.jpg';
        // echo "执行完getPicByUID:".date("Y-m-d H:i:s",time());*/

//获取图片原始宽高，计算缩小比例
        $filename = date("YmdHis",time).rand(100,999).'.jpg';
        $filepath = $_SERVER['DOCUMENT_ROOT']."/uploads/";
//echo "执行getImage:".date("Y-m-d H:i:s",time()) ;
        $imagename=imageHelper::getImage($picurl,'',$filepath , array('jpg', 'gif'));
//$imagename=imageHelper::grabImage($picurl,'',$filepath) ;

//echo "执行完getImage:".date("Y-m-d H:i:s",time()) ;
//echo "执行getimagesize:".date("Y-m-d H:i:s",time()) ;
        list($img_width, $img_height, $type, $attr) = getimagesize($filepath.$imagename);
//echo "执行完getimagesize:".date("Y-m-d H:i:s",time());
        $sxbl = 1;
        if($img_width>300){
            $sxbl = floatval($img_width/300);
            $width = 300;
        }
        $picinfo=array("img_width"=>$img_width,"sxbl"=>$sxbl,"width"=>$width,"imagename"=>$imagename,"picurl"=>$picurl);
        $this->assign('picinfo', $picinfo);
    }


}