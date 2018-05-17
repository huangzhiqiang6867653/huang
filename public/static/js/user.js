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

    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
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
            {fixed: 'right', width: 165, align:'center', toolbar: '#barDemo'}
        ]]
    });
});