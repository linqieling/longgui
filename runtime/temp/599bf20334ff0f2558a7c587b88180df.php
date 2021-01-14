<?php /*a:2:{s:59:"F:\phpstudy\WWW\rhaphp\themes/pc/admin/system\menulist.html";i:1609838073;s:55:"F:\phpstudy\WWW\rhaphp\themes/pc/admin/common\base.html";i:1609832566;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>微信平台管理系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/public/static//admin/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/public/static//admin/css/admin_base.css" />
    <script type="text/javascript" src="/public/static//jquery/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/public/static//layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/static//layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/public/static//icon/icon.css" />
    
    <style>
        <?php if($setScreen ==1): ?>
        .container_body, .wrap{width: 100%;}
        .sidebar{float:left;width: 12%;}
        .content{float: left;width: 87%;}
        .main-logo{margin-left: 5px;}
        .menu dl dt .type-ico{margin-left: 5%}
        .menu dl dd a{padding-left: 22%;}
        #addon_menu .item-icon{margin-left: 5%;}
        .addon_menu-left-nav-a .item-icon{left: 0;}
        .addon_menu-left-nav-a {padding-left: 23%;}
        <?php endif; ?>
    </style>
</head>
<body class="trade-order">
<div class="topbar" id="gotop">
    <div class="wrap">
        <ul>
            <li>你好，<a class="name" href="" id="username"><?php echo htmlentities($admin['admin_name']); ?></a>
                <?php if(!(empty($mpInfo) || (($mpInfo instanceof \think\Collection || $mpInfo instanceof \think\Paginator ) && $mpInfo->isEmpty()))): ?>
                <span class="quit">当前公众号：<a href="<?php echo url('mp/index/index',['mid'=>$mpInfo['id']]); ?>"><?php echo htmlentities($mpInfo['name']); ?></a><i style="font-size: 9px; margin-left: 8px;"><?php echo getMpType($mpInfo['type']); ?></i>
                    <?php if($mpInfo['valid_status'] == '1'): ?>
                    <i style="font-size: 9px; margin-left: 8px;">已接入</i>
                    <?php else: ?>
                    <i style="font-size: 9px; margin-left: 8px; color: red">未接入</i>
                    <?php endif; ?>
                </span>
                <a class="quit" href="<?php echo url('mp/index/mplist'); ?>">切换公众号</a>
                <a class="quit" href="<?php echo url('mp/Message/messagelist'); ?>"><i class="layui-icon">&#xe645;</i>用户消息<span class="num-feed rhaphp-msg-user show" style="display: none;">0</span></a>
                <?php endif; ?>

                <a class="quit" href="javascript:;" onclick="cacheClear()"><i class="layui-icon">&#xe640;</i>清空缓存</a>
                <a class="quit" href="javascript:;" onclick="setScreen()"><i style="font-size: 14px;" class="rha-icon">&#xe879;</i><span id="screen">宽屏</span></a>
                <a class="quit" class="quit" href="<?php echo url('admin/Login/out'); ?>"><i class="rha-icon">&#xe696;</i>退出</a>
            </li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="wrap">
        <div class="logo">
            <h1 class="main-logo"><a href="<?php echo url('mp/mp/index'); ?>">微信平台管理系统</a></h1>
            <div class="sub-logo"></div>
        </div>
        <div class="nav">
            <ul>
                <?php if(is_array($t_menu) || $t_menu instanceof \think\Collection || $t_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $t_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
                <li class="<?php if($topNode == $t['url']): ?>selected<?php endif; ?>"><a href="<?php echo url($t['url']); ?>"><?php echo htmlentities($t['name']); ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>
<div class="container_body wrap">
    <div class="sidebar">
        <div class="menu">
            <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
            <dl>
                <dt><i class="type-ico ico-trade rha-icon <?php if($t['shows'] == '1'): ?><?php endif; ?>"><?php echo $t['icon']; ?></i><?php echo htmlentities($t['name']); ?></dt>
                <?php if(is_array($t['child']) || $t['child'] instanceof \think\Collection || $t['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $t['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
                <dd class="<?php if($c['shows'] == '1'): ?>selected<?php endif; ?>"><a href="<?php echo url($c['url']); ?>"><?php echo htmlentities($c['name']); ?></a></dd>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </dl>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            
            <dl>
                <?php  if(!isset($menu_app))$menu_app=null; if($menu_app != ''): ?><dt><i class="type-ico ico-trade rha-icon">&#xe6f0;</i><?php echo htmlentities($menu_app_title); ?></dt><?php endif; if(is_array($menu_app) || $menu_app instanceof \think\Collection || $menu_app instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_app;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <dd class=""><a href="<?php echo url('mp/App/index',['name'=>$v['addon'],'type'=>'news','mid'=>$mid]); ?>"><?php echo htmlentities($v['name']); ?></a></dd>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </dl>
        </div>
    </div>
    <div class="content" id="tradeSearchBd">
        <?php if(isset($menu_tile) OR $menu_title != ''): ?>
        <div class="content-hd">
            <h2><?php echo htmlentities($menu_title); ?>
<a href="<?php echo url('addMenu'); ?>"  class="layui-btn layui-btn-normal layui-btn-sm rha-nav-title">增加菜单</a>
</h2>
        </div>
        <?php endif; ?>
        
<form class="layui-form" action="" style="padding: 0px 10px 0px 10px;">
<button class="layui-btn  layui-btn-sm" lay-submit lay-filter="updateSort">更新排序</button>
<table class="layui-table">
    <colgroup>
        <col width="100">
        <col width="500">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>排序</th>
        <th>菜单名称</th>
        <th>地址</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($menuList) || $menuList instanceof \think\Collection || $menuList instanceof \think\Paginator): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr>
            <td><input style="width: 35px; text-align:center" name="<?php echo htmlentities($v['id']); ?>_<?php echo htmlentities($v['sort']); ?>" value="<?php echo htmlentities($v['sort']); ?>"></td>
            <td><?php echo htmlentities($v['name']); ?></td>
            <td><?php echo htmlentities($v['url']); ?></td>
            <td><a class="rha-bt-a" href="<?php echo url('updateMenu',['id'=>$v['id']]); ?>">修改</a> <a href="javascript:;" onclick="delMenu('<?php echo htmlentities($v['id']); ?>')" class="rha-bt-a" >删除</a></td>
        </tr>
        <?php if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr>
            <td><input style="width: 35px; text-align:center" name="<?php echo htmlentities($v['id']); ?>_<?php echo htmlentities($v['sort']); ?>" value="<?php echo htmlentities($v['sort']); ?>"></td>
            <td>&nbsp;&nbsp;&nbsp; ├<?php echo htmlentities($v['name']); ?></td>
            <td><?php echo htmlentities($v['url']); ?></td>
            <td><a class="rha-bt-a" href="<?php echo url('updateMenu',['id'=>$v['id']]); ?>">修改</a> <a href="javascript:;" onclick="delMenu('<?php echo htmlentities($v['id']); ?>')" class="rha-bt-a" >删除</a></td>
        </tr>
            <?php if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input style="width: 35px; text-align:center" name="<?php echo htmlentities($v['id']); ?>_<?php echo htmlentities($v['sort']); ?>" value="<?php echo htmlentities($v['sort']); ?>"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ├<?php echo htmlentities($v['name']); ?></td>
                <td><?php echo htmlentities($v['url']); ?></td>
                <td><a class="rha-bt-a" href="<?php echo url('updateMenu',['id'=>$v['id']]); ?>">修改</a> <a href="javascript:;" onclick="delMenu('<?php echo htmlentities($v['id']); ?>')" class="rha-bt-a" >删除</a></td>
            </tr>

                <?php if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><input style="width: 35px; text-align:center" name="<?php echo htmlentities($v['id']); ?>_<?php echo htmlentities($v['sort']); ?>" value="<?php echo htmlentities($v['sort']); ?>"></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ├<?php echo htmlentities($v['name']); ?></td>
                    <td><?php echo htmlentities($v['url']); ?></td>
                    <td><a class="rha-bt-a" href="<?php echo url('updateMenu',['id'=>$v['id']]); ?>">修改</a> <a href="javascript:;" onclick="delMenu('<?php echo htmlentities($v['id']); ?>')" class="rha-bt-a" >删除</a></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
</form>
<script>
    function delMenu(id) {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('删除操作可能引起系统不能正常使用，你确定需要删除吗？', {
                btn: ['是','不'] //按钮
            }, function(){
                $.post("<?php echo url('System/delMenu'); ?>",{'id':id},function (res) {
                    if(res.status==1){
                        layer.alert(res.msg,function (index) {
                            window.location.reload();
                            layer.close(index);
                        })
                    }else{
                        layer.alert(res.msg)
                    }
                })
            }, function(){
            });
        });
    }
layui.use('form', function(){
    var form = layui.form;
    form.on('submit(updateSort)', function(data){
        $.post("<?php echo url('System/updateSort'); ?>",data.field,function (res) {
            if(res.status=='0'){
                layer.msg(res.msg);
            }
            if(res.status=='1'){
                layer.msg(res.msg,{time:1000},function () {

                });
            }
        })
        return false;
    });
});
</script>

    </div>
</div>
<div class="footer" style="display: none;">
    <div class="wrap">
        <!--请遵守安装使用协议，未经允许不得删除或者屏蔽有关RhaPHP字样与版权-->
        <a href="https://www.rhaphp.com" target="_blank">官方社区</a>
        <i class="vs">|</i>
        Powered By RhaPHP<?php echo htmlentities($copy['version']); ?> 二哈系统 Copyright © <?php echo date('Y'); ?> All Rights Reserved.
    </div>
</div>
</body>
<script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>

    if($.cookie('think_setScreen')){
        $('#screen').text('常规');
    }else{
        $('#screen').text('宽屏');
    }

    layui.use('element', function(){
        var element = layui.element;
    });
    function getMaterial(paramName,type){
        layer.open({
            type: 2,
            title: '选择素材',
            shadeClose: true,
            shade: 0.8,
            area: ['750px', '480px'],
            content: '<?php echo url("mp/Material/getMeterial","",""); ?>/type/'+type+'/param/'+paramName //iframe的url
        });
    }
    function controllerByVal(value,paramName,type) {
        
        $('.form_'+paramName).attr('src',value);
        $("input[name="+paramName+"]").val(value);
    }
    $(function () {
       //  setInterval(getMsgTotal,20000);
        function getMsgTotal() {
            $.get("<?php echo url('mp/Message/getMsgStatusTotal'); ?>",{},function (res) {
                if(res.msgTotal==0){
                    //TODO
                }else{
                    $('.rhaphp-msg-user').show();
                    $('.rhaphp-msg-user').text(res.msgTotal);
                }

            })
        }
    })
    var layer
    layui.use('layer', function(){
        layer = layui.layer;
    });
    function cacheClear() {
        var index =layer.load(1)
        $.post("<?php echo url('admin/system/cacheClear'); ?>",function (res) {
            layer.close(index);
            layer.alert(res.msg);
        })
    }
    function setScreen() {
        var index =layer.load(1)
        $.post("<?php echo url('admin/system/setScreen'); ?>",function (res) {
            layer.close(index);
            window.location.reload();
        })
    }
</script>
</html>