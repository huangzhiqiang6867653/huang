layui.define(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'form'], function (exports) {
    var laydate = layui.laydate //日期
        , laypage = layui.laypage //分页
        , layer = layui.layer //弹层
        , table = layui.table //表格
        , carousel = layui.carousel //轮播
        , upload = layui.upload //上传
        , element = layui.element  //元素操作
        , form = layui.form;  //表单
    var $ = layui.$, active = {
        parseTable: function () {
            table.init('parse-table-demo', { //转化静态表格
                //height: 'full-500'
            });
        }
    };
    //表格渲染
    table.render({
        elem: '#table_list_id',
        url: '../customer/listPage/', //数据接口
        cellMinWidth: 80,
        page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
            layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
            groups: 5, //只显示 1 个连续页码
            first: true, //不显示首页
            last: true, //不显示尾页
            limit: 10 //每页数量
        }, //开启分页
        cols: [[ //表头
            {field: 'name', title: '姓名', align: 'center'},
            {field: 'sex', title: '性别', align: 'center'},
            {field: 'phone', title: '手机号', align: 'center'},
            {field: 'qq', title: 'qq号', align: 'center'},
            {field: 'id_number', title: '身份证', align: 'center', },
            {fixed: 'right', width: 300, title: '操作', align: 'center', toolbar: '#operationBar'}
        ]]
    });

    //监听工具条
    table.on('tool(table_list)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data //获得当前行数据
            , layEvent = obj.event; //获得 lay-event 对应的值
        if (layEvent === 'detail') {
            operation_function(data['customer_id'], 'view');
        } else if (layEvent === 'del') {
            layer.confirm('确认删除该条数据？', function (index) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../customer/delete/',
                    data: {'id': data['customer_id']},
                    success: function (data) {
                        if (data.code == 200) {
                            layer.close(index);
                            //向服务端发送删除指令
                            layer.msg('删除成功～',
                                {
                                    icon: 1,
                                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                                }
                            );
                            //刷新table
                            table.reload('table_list_id');
                        } else {
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
        } else if (layEvent === 'edit') {
            operation_function(data['customer_id'], 'edit');
        }else if(layEvent === 'add_record'){
            add_record(data['customer_id']);
        }else if(layEvent === 'view_record'){
            view_record(data['customer_id']);
        }
    });


    //新增编辑用户
    $(document).on('click', '#add_operation_id', function () {
        operation_function('', 'add')
    });

    function operation_function(id, type) {
        layer.open({
            title: type == 'add' ? '新增' : (type == 'edit' ? '修改' : '查看'),
            content: '<iframe style="height: 98%; width: 100%; border: 0;" src="../customer/form/?id=' + id + '&type=' + type + '" />',
            area: ['80%', '90%'],
            maxmin: true,
            btn: ['关闭'],
            yes: function (index) {
                layer.close(index);
            }
        });
    }

    form.on('submit(formSubmit)', function (data) {
        layer.msg(JSON.stringify(data.field));
    });

    //查询数据
    $(document).on('click', '#search_id', function () {
        table.reload('table_list_id', {
            where: {'search_content': $('input[name="search_content"]').val()}
        });
    });

    //添加拜访记录
    function add_record(id) {
        layer.open({
            title: '添加拜访记录',
            content: '<iframe style="height: 98%; width: 100%; border: 0;" src="../customer/add_record/?id=' + id + '" />',
            area: ['90%', '90%'],
            maxmin: true,
            btn: ['关闭'],
            yes: function (index) {
                layer.close(index);
            }
        });
    }

    //查看拜访记录
    function view_record(id) {
        layer.open({
            title: '查看拜访记录',
            content: '<iframe style="height: 98%; width: 100%; border: 0;" src="../customer/view_record/?id=' + id + '" />',
            area: ['60%', '100%'],
            maxmin: true,
            btn: ['关闭'],
            yes: function (index) {
                layer.close(index);
            }
        });
    }
});