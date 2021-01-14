<?php /*a:1:{s:62:"F:\phpstudy\WWW\rhaphp/addons/liuYanBan/view//admin/index.html";i:1610018232;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($config['title'])): ?><?php echo htmlentities($config['title']); else: ?>留言板<?php endif; ?></title>
    <script type="text/javascript" src="/public/static//jquery/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/public/static//layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/static//layui/css/layui.css" />
</head>

<body style="padding: 10px; min-height: 720px;">
    <!-- 查询条件start -->
    <div class="layui-form">

        <div class="layui-form-item">
            <div class="layui-inline">
                <input type="text" name="name"  id="name" placeholder="姓名" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline">
                <input type="text" name="phone" id="phone"  placeholder="手机号码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline">
                <input type="text" name="dateline" id="dateline"  placeholder="留言时间" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline">
                <select name="status" lay-filter="status" id="status" >
                    <option value="">全部</option>
                    <option value="0">未回复</option>
                    <option value="1">已回复</option>
                </select>
            </div>
            <div class="layui-inline">
                <button class="layui-btn" id="search">搜索</button>
            </div>
        </div>
    </div>
    <!-- 查询条件end -->

    <table id="msg-table" lay-filter="msg"></table>

</body>
<script>
    var layer;
    layui.use(['layer', 'table', 'laydate'],function () {
        layer = layui.layer;
        var laydate = layui.laydate,
        table = layui.table;

        //日期时间选择器
        laydate.render({
            elem: '#dateline'
            ,type: 'date'
            ,range: '~'
        });

        table.render({
            elem: '#msg-table'
            ,id: 'testReload'
            ,title: "<?php if(isset($config['title'])): ?><?php echo htmlentities($config['title']); else: ?>留言列表<?php endif; ?>"
            ,url: "<?php echo addonUrl('getList'); ?>" //数据接口
            ,page: true //开启分页
            ,limit: 10
            ,cols: [[ //表头
                {field: 'user', title: '用户', width: 120, align: 'center', templet:function(res){
                    return '<img src="'+res.avatar+'" width="28" height="28" alt="头像" /><span style="margin-left: 6px">'+res.nickname+'</span>'
                }}
                ,{field: 'name', title: '姓名', width:90, align: 'center'}
                ,{field: 'phone', title: '手机号', width:120, align: 'center'}
                ,{field: 'title', title: '标题', minWidth:90}
                ,{field: 'status', title: '状态', width: 80, align: 'center', sort: true, templet:function(res){
                    var status = '<span style="color:#555555;">未知</span>';
                    if(res.status){
                        status='<span style="color:#4caf50;">已回复</span>';
                    }else{
                        status='<span style="color:#FF9800;">未回复</span>';
                    }
                    return status
                }}
                ,{field: 'dateline', title: '留言时间', width: 142, align: 'center', sort: true, templet: function(res){
                    return dateFormat(res.dateline);
                }}
                ,{fixed:'right', title:'操作', width: 110, align: 'center', fixed: 'right', templet: function(res){
                    var html = '';
                    html += '<a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>'
                        +'<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    return html
                }}
            ]]
        });

        //搜索-//-----------------------------------
        $('#search').click(function(){
            var name=$("#name").val();
            var phone=$('#phone').val();
            var status=$('#status').val();
            var dateline=$('#dateline').val();
 
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    name:name,
                    phone:phone,
                    status:status,
                    dateline:dateline
                }
            });
        });


        //监听行工具事件
        table.on("tool(msg)", function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定要删除该留言吗?', {
                    title:'系统提示'
                    ,icon: 3
                    ,shade: 0.3
                    ,closeBtn: 0
                }, function(index){
                    msgDel(data.mb_id);
                    //obj.del();
                    layer.close(index);
                });
            } else if(obj.event === 'detail'){
                var url = "<?php echo addonUrl('detail'); ?>?id="+data.mb_id;
                layer.open({
                    title: '留言详情',
                    type: 2,
                    area: ['100%', '100%'],
                    content: url,
                    zIndex: layer.zIndex, //重点1
                    success: function(layero){
                        layer.setTop(layero); //重点2
                    }
                    ,end: function(index, layero){
                        table.reload('testReload');
                    }
                });
            }
        });
    })

    /* 时间戳转化开始 */
    Date.prototype.format = function (fmt) {
       var o = {
        "M+": this.getMonth() + 1,//月份
        "d+": this.getDate(),//日
        "h+": this.getHours(),//小时
        "m+": this.getMinutes(),//分
        "s+": this.getSeconds(),//秒
        "q+": Math.floor((this.getMonth() + 3) / 3),//q是季度
        "S": this.getMilliseconds() //毫秒
       };
       if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1,(this.getFullYear() + "").substr(4 - RegExp.$1.length));
       for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1,(RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
       return fmt;
      } 
     
      String.prototype.format = function (args) {
       var result = this;
       if (arguments.length > 0) {
        if (arguments.length == 1 && typeof (args) == "loginTime") {
         for (var key in args) {
          if (args[key] != undefined) {
           var reg = new RegExp("({" + key + "})","g");
           result = result.replace(reg,args[key]);
          }
         }
        }
        else {
         for (var i = 0; i < arguments.length; i++) {
          if (arguments[i] != undefined) {
           //var reg = new RegExp("({[" + i + "]})","g");//这个在索引大于9时会有问题
           var reg = new RegExp("({)" + i + "(})",arguments[i]);
          }
         }
        }
       }
       return result;
    }
    function dateFormat(value) {
       return value ? new Date(value*1000).format("yyyy-MM-dd hh:mm") : "";
    } 

    function msgDel(id) {
        $.post("<?php echo addonUrl('msgDel'); ?>", {'id':id}, function (res) {
            if(res.status==1){
                layer.open({
                    title: '系统提示'
                    ,icon: 1
                    ,closeBtn: 0
                    ,content: res.msg?res.msg:'操作成功'
                    ,yes: function(index, layero){
                        layer.close(index);
                        $('#search').click();
                    }
                });
            }else{
                layer.open({
                    title: '系统提示'
                    ,icon: 2
                    ,closeBtn: 0
                    ,content: res.msg?res.msg:'操作失败'
                });
            }
        }).error(function (res) {
            layer.open({
                title: '系统提示'
                ,icon: 2
                ,closeBtn: 0
                ,content: '服务出错'
            });
        })
    }
</script>
</html>