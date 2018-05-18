layui.define(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element'], function(exports){
    var laydate = layui.laydate //日期
        ,laypage = layui.laypage //分页
        ,layer = layui.layer //弹层
        ,table = layui.table //表格
        ,carousel = layui.carousel //轮播
        ,upload = layui.upload //上传
        ,element = layui.element; //元素操作
    var $ = layui.$, active = {
        parseTable: function(){
            table.init('parse-table-demo', { //转化静态表格
                //height: 'full-500'
            });
        }
    };
    //表格渲染
    table.render({
        elem: '#user_list_id',
        url: '../user/user_list/', //数据接口
        cellMinWidth: 80,
        page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
            layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
            groups: 5, //只显示 1 个连续页码
            first: true, //不显示首页
            last: true, //不显示尾页
            limit: 10 //每页数量
        }, //开启分页
        cols: [[ //表头
            {type:'checkbox'},
            {field: 'user_id', title: '主键',sort: true, align: 'center'},
            {field: 'user_name', title: '用户名', align: 'center'},
            {field: 'password', title: '密码', align: 'center'},
            {field: 'create_time', title: '创建时间', align: 'center'},
            {fixed: 'right', width: 165, align:'center', toolbar: '#operationBar'}
        ]]
    });

    //监听工具条
    table.on('tool(user_list)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data //获得当前行数据
            ,layEvent = obj.event; //获得 lay-event 对应的值
        if(layEvent === 'detail'){
            operation_user(data['user_id'], 'view');
        } else if(layEvent === 'del'){
            layer.confirm('真的删除行么', function(index){
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../user/delete_user_info/',
                    data: {'user_id': data['user_id']},
                    success: function (data) {
                        if(data.code == 200) {
                            layer.close(index);
                            //向服务端发送删除指令
                            layer.msg('删除成功～',
                                {
                                    icon: 1,
                                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                                }
                            );
                            //刷新table
                            table.reload('user_list_id');
                        }else{
                            layer.msg(data.msg,
                                {
                                    icon: 2,
                                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                                }
                            );
                        }
                    }
                });

            });
        } else if(layEvent === 'edit'){
            operation_user(data['user_id'], 'edit');
        }
    });


    //新增编辑用户
    $(document).on('click','#user_operation_id',function(){
        operation_user('', 'add')
    });

    function operation_user(user_id, type) {
        var btn_text = type == 'add'?'新增':(type == 'edit'?'修改':(type == 'view'?'关闭':'取消'));
        if(user_id){
            $.ajax(

            );
        }
        layer.open({
            title: user_id?'修改用户':'新增用户',
            content: user_id?('用户id'+ user_id):'新增',
            area: ['80%', '90%'],
            maxmin: true,
            btn: [btn_text],
            yes: function(index){
                layer.close(index);
            }
        });
    }
});