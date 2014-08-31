<?php

 class imageHelper{

/**
 * 抓取远程图片
 *
 * @param string $url 远程图片路径
 * @param string $filename 本地存储文件名
 */
public  function grabImage($url, $filename = '',$dirName) {
    if($url == '') {
        return false; //如果 $url 为空则返回 false;
    }
    $ext_name = '.jpg';

    if($filename == '') {
        $filename = time().$ext_name; //以时间戳另起名
    }
    //开始捕获
    ob_start();
    readfile($url);
    $img_data = ob_get_contents();
    ob_end_clean();
    $size = strlen($img_data);
    $local_file = fopen($dirName.$filename , 'a');
    fwrite($local_file, $img_data);
    fclose($local_file);
    return $filename;
}

  public static  function imagecropper($source_path,$source_name,$imgArray, $target_width, $target_height)
   {
    $source_path=  $source_path.$source_name;
   	$source_info   = getimagesize($source_path);
   	$source_width  = $source_info[0];
   	$source_height = $source_info[1];
   	$source_mime   = $source_info['mime'];
   	$source_ratio  = $source_height / $source_width;
   	$target_ratio  = $target_height / $target_width;

   	// 源图过高
   	if ($source_ratio > $target_ratio)
{
$cropped_width  = $source_width;
$cropped_height = $source_width * $target_ratio;
$source_x = 0;
$source_y = ($source_height - $cropped_height) / 2;
}
// 源图过宽
elseif ($source_ratio < $target_ratio)
{
$cropped_width  = $source_height / $target_ratio;
$cropped_height = $source_height;
$source_x = ($source_width - $cropped_width) / 2;
$source_y = 0;
}
// 源图适中
else
{
$cropped_width  = $source_width;
$cropped_height = $source_height;
$source_x = 0;
$source_y = 0;
}

switch ($source_mime)
{
case 'image/gif':
$source_image = imagecreatefromgif($source_path);
break;

case 'image/jpeg':
$source_image = imagecreatefromjpeg($source_path);
break;

case 'image/png':
$source_image = imagecreatefrompng($source_path);
break;

default:
return false;
break;
}

$target_image  = imagecreatetruecolor($target_width, $target_height);
$cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

// 裁剪
/**	bool imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。  */
//echo $imgArray["x"].$imgArray["y"].$imgArray["cropwidth"].$imgArray["cropheight"];
imagecopy($cropped_image, $source_image, 0, 0, $imgArray["x"], $imgArray["y"], $imgArray["cropwidth"], $imgArray["cropheight"]);
// 缩放
/**
bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
imagecopyresampled() 将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑地插入像素值，因此，尤其是，减小了图像的大小而仍然保持了极大的清晰度。
*/
imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $imgArray["cropwidth"], $imgArray["cropheight"]);

//header('Content-Type: image/jpeg');
$final_pic_url=$_SERVER['DOCUMENT_ROOT']."/uploads/".$source_name;
imagejpeg($target_image,$final_pic_url );
return  $source_name;
imagedestroy($source_image);
imagedestroy($target_image);
imagedestroy($cropped_image);
}


/**
*php实现下载远程图片到本地
*@param $url       string      远程文件地址
*@param $filename  string      保存后的文件名（为空时则为随机生成的文件名，否则为原文件名）
*@param $fileType  array       允许的文件类型
*@param $dirName   string      文件保存的路径（路径其余部分根据时间系统自动生成）
*@param $type      int         远程获取文件的方式
*@return           json        返回文件名、文件的保存路径
*
* 例子：{'fileName':13668030896.jpg, 'saveDir':/www/test/img/2013/04/24/}
*/

public static function getImage($url, $filename='', $dirName, $fileType, $type=0)
{

if($url == ''){return false;}
//获取文件原文件名
$defaultFileName = basename($url);
//获取文件类型
//$suffix = substr(strrchr($url,'.'), 1);
//if(!in_array($suffix, $fileType)){
//$suffix="jpg";
//}
$suffix="jpg";
//设置保存后的文件名
$filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;

//获取远程文件资源
if($type){
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file = curl_exec($ch);
curl_close($ch);
}else{
ob_start();
readfile($url);
$file = ob_get_contents();
ob_end_clean();
}
//设置文件保存路径
$dirName = $dirName;
if(!file_exists($dirName)){
mkdir($dirName, 0777, true);
}
//保存文件
$res = fopen($dirName.$filename,'a');

fwrite($res,$file);
fclose($res);
return  $filename ;
}

}

?>