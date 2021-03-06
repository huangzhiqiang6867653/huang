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
        url: '../functions/listPage/', //数据接口
        cellMinWidth: 80,
        page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
            layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
            groups: 5, //只显示 1 个连续页码
            first: true, //不显示首页
            last: true, //不显示尾页
            limit: 10 //每页数量
        }, //开启分页
        cols: [[ //表头
            {field: 'function_id', title: '主键', align: 'center'},
            {field: 'function_name', title: '菜单名', align: 'center'},
            {field: 'function_url', title: 'URL', align: 'center'},
            {field: 'sort', title: '排序', align: 'center'},
            {field: 'level_type', title: '级别', align: 'center'},
            {field: 'parent_id', title: '父主键', align: 'center'},
            {fixed: 'right', width: 165, align: 'center', toolbar: '#operationBar'}
        ]]
    });

    //监听工具条
    table.on('tool(table_list)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data //获得当前行数据
            , layEvent = obj.event; //获得 lay-event 对应的值
        if (layEvent === 'detail') {
            operation_handle(data['function_id'], 'view');
        } else if (layEvent === 'del') {
            layer.confirm('确认删除该条数据？', function (index) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../functions/delete/',
                    data: {'id': data['function_id']},
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
            operation_handle(data['function_id'], 'edit');
        }
    });


    //新增编辑用户
    $(document).on('click', '#add_operation_id', function () {
        operation_handle('', 'add')
    });

    function operation_handle(id, type) {
        layer.open({
            title: type == 'add' ? '新增' : (type == 'edit' ? '修改' : '查看'),
            content: '<iframe style="height: 98%; width: 100%; border: 0;" src="../functions/form/?id=' + id + '&type=' + type + '" />',
            area: ['70%', '90%'],
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
});