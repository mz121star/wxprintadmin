<?php

class PrinterAction extends PublicAction {

    public function lists(){
        $print = M("print");
        import('ORG.Util.Page');
        $count = $print->count();
        $page = new Page($count, 10);
        $printlist = $print->order(array('id'=>'desc'))->limit($page->firstRow.','.$page->listRows)->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('printlist', $printlist);
        $this->display();
    }

    public function viewprinter() {
        $pid = $this->_get('pid');
        $print = M("print");
        $printinfo = $print->where('id='.$pid)->find();
        if (!$printinfo) {
            $this->redirect('printer/lists');
        }
        preg_match_all('/src="([^"]*?)"/', $printinfo['print_content'], $matches);
        $printlist = array();
        if (count($matches[1])) {
            $printlist = $matches[1];
        }
        $this->assign('printinfo', $printinfo);
        $this->assign('printlist', $printlist);
        $this->display();
    }

    public function downprinter() {
        $pid = $this->_get('pid');
        $print = M("print");
        $printinfo = $print->where('id='.$pid)->find();
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php/viewprinter/'.$pid;
        $config_content = $url.'?deviceid='.$this->_get('deviceid').'&hs='.$this->_get('hs').','.$printinfo['print_name'];
        $zip = new ZipArchive ;
        $zipfile = $_SERVER['DOCUMENT_ROOT'].'/upload/print.zip';
        $formfile = $_SERVER['DOCUMENT_ROOT'].'/upload/form.exe';
        $configfile = $_SERVER['DOCUMENT_ROOT'].'/upload/config.txt';
        $jsonfile = $_SERVER['DOCUMENT_ROOT'].'/upload/Newtonsoft.Json.dll';
        file_put_contents($configfile, $config_content);
        if ($zip->open($zipfile, ZipArchive::CREATE) ===  TRUE ) {
            $zip->addFile($formfile, 'form.exe');
            $zip->addFile($configfile, 'config.txt');
            $zip->addFile($jsonfile, 'Newtonsoft.Json.dll');
            $zip->close ();
            import('ORG.Net.Http');
            Http::download($zipfile, 'print.zip');
        } else {
            $this->error('下载失败', 'lists') ;
        }
    }
   public    function randomkeys($length)
{
    $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++)
    {
        $key .= $pattern{mt_rand(0,35)};    //生成php随机数
    }
    return $key;
}

    public function showadd(){
        $this->assign('tokencode',$this->randomkeys(10));
        $this->display();
    }
    
    public function modprinter() {
        $pid = $this->_get('pid');
        $print = M("print");
        $printinfo = $print->where('id='.$pid)->find();
        if (!$printinfo) {
            $this->redirect('printer/lists');
        }
        $this->assign('printinfo', $printinfo);
        $this->display();
    }
    
    public function delprinter(){
        $pid = $this->_get('pid');
        $print = M("print");
        $printinfo = $print->where('id='.$pid)->find();
        if ($printinfo) {
            $printnumber = $print->where('id='.$pid)->delete();
            if ($printnumber) {
                unlink('./upload/'.$printinfo['print_imgcode']);
                $this->redirect('printer/lists');
            } else {
                $this->error("删除设备失败", 'lists');
            }
        } else {
            $this->error("删除设备失败", 'lists');
        }
    }

    public function save(){
        $isdelimage = $this->_post('delprint_imgcode');
        if ($isdelimage) {
            $_POST['print_imgcode'] = '';
            unlink('./upload/'.$isdelimage);
        }
        if ($_FILES['print_imgcode']['name']) {
            import('ORG.Net.UploadFile');
            $upload = new UploadFile();
            $upload->maxSize = 3145728;//3M
            $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->savePath = './upload/';
            if(!$upload->upload()) {
                $this->error($upload->getErrorMsg());
            }else{
                $info = $upload->getUploadFileInfo();
            }
            $_POST['print_imgcode'] = $info[0]['savename'];
        }
        $printer = M("print");
        if (isset($_POST['id']) && $_POST['id']) {
            $printernumber = $printer->where('id='.$_POST['id'])->save($_POST);
        } else {
            $printerid = $printer->add($_POST);
        }
        $this->redirect('printer/lists');
    }
}