<?php

class PrintsetAction extends Action {
      public  function  crop(){
          import("@.ORG.imageHelper");
//$_GET数据：原始图片url($src)、选区左上坐标($x/$y)、选区宽高($cropwidth/$cropheight)、原图缩小比例($sxbl)
          $src=$_POST["src"];
          $x=$_POST["x1"];
          $y=$_POST["y1"];
          $cropwidth=$_POST["cropwidth"];
          $cropheight=$_POST["cropheight"];
          $sxbl= $_POST["sxbl"];
          $src = trim($src);
          if(!$src) die();


//根据缩小比例计算所选区域在原图上的真实坐标及真实宽高
          $x = intval($x*$sxbl);
          $y = intval($y*$sxbl);
          $width = intval($cropwidth*$sxbl);
          $height = intval($cropheight*$sxbl);

          $imgArray = [
              "src" => $src,
              "x" => $x,
              "y"=>$y,
              "cropwidth"=> $width,
              "cropheight"=> $height,
              "sxbl"=>$sxbl

          ];

          /** $data = file_get_contents($src); // 读文件内容
          $filepath = $_SERVER['DOCUMENT_ROOT']."uploads/";//图片保存的路径目录
          if(!is_dir($filepath)){
          mkdir($filepath,777, true);
          }
          $filename = date("YmdHis",$filetime).rand(100,999).'.jpg'; //生成文件名，
          $fp = fopen($filepath.$filename,"w"); //以写方式打开文件
          fwrite($fp,$data); //
          fclose($fp);//完工，哈        */

          $filepath = $_SERVER['DOCUMENT_ROOT']."/uploads/";
          // $imagename=imageHelper::getImage($src, '',$filepath , array('jpg', 'gif'));

          $finalimage= imageHelper::imagecropper($filepath,$src,$imgArray,800,600);

          $info= M('printlist')->where(array("uid"=>$_GET["uid"]))->find();
          if($info){
              $info["picurl"]="http://p.webs.dlwebs.com/uploads/".$finalimage;
              $info["issend"]=0;
              M('printlist')->save($info);
          }
          else{
              M('printlist')->add(array("uid"=>$_GET["uid"],"picurl"=>"http://p.webs.dlwebs.com/uploads/".$finalimage,"isend"=>0));
          }


          echo $finalimage;


      }
    public function zoom(){
        import("@.ORG.imageHelper");
         $uid=$this->_get("uid");
        $picurl=$_GET["picurl"];
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
        $this->assign('uid', $uid);
        $this->display();

    }
    public  function getpics(){

        $deviceid=$this->_get("deviceid");

        $map['code'] = array('like',$deviceid.'%');
        $map['issend'] = array('neq',1);
        $info= M('printlist')->where($map)->select();
        echo json_encode($info);
    }
    public  function  printend(){
        $uid=$this->_get("uid");
        $info= M('printlist')->where(array("uid"=>$uid))->find();

        $info['issend'] = 1;
        M('printlist')->save($info);
        echo "完成打印";
    }
    public  function  checkcode(){
        $code=$this->_get("code");
        $info= M('printlist')->where(array("code"=>$code))->find();
        if($info){
            echo "1";
        }
        else{
            echo "0";
        }
    }

}