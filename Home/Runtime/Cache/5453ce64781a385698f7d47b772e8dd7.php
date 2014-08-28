<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微信打印机</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>
  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="__GROUP__/Index">微信打印机后台设备管理</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="__GROUP__/Index/logout">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">

           <ul class="nav nav-sidebar">
            <li <?php if($current_c == 'Printer' and $current_a == 'lists'): ?>class="active"<?php endif; ?>><a href="__GROUP__/Printer/lists">设备列表</a></li>
            <li <?php if($current_c == 'Printer' and $current_a == 'showadd'): ?>class="active"<?php endif; ?>><a href="__GROUP__/Printer/showadd">添加设备</a></li>
          </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">设备列表</h2>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>设备名称</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if(is_array($printlist)): foreach($printlist as $key=>$printer): ?><tr>
            <td class="col-sm-2"><?php echo ($printer["print_name"]); ?></td>
            <td class="col-sm-2">
                <a href="__GROUP__/viewprinter/<?php echo ($printer["id"]); ?>" target="_blank">预览</a> 
                <a href="__GROUP__/downprinter/<?php echo ($printer["id"]); ?>">下载</a> 
                <a href="__GROUP__/modprinter/<?php echo ($printer["id"]); ?>">编辑</a> 
                <a href="__GROUP__/delprinter/<?php echo ($printer["id"]); ?>">删除</a>
            </td>
          </tr><?php endforeach; endif; ?>
        </tbody>
      </table>
      <?php echo ($page); ?>
    </div>
        </div>
      </div>
    </div>
  </body>
</html>