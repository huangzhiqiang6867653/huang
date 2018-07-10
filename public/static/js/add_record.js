layui.define(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'form'], function (exports) {
    var laydate = layui.laydate //日期
        , laypage = layui.laypage //分页
        , layer = layui.layer //弹层
        , table = layui.table //表格
        , carousel = layui.carousel //轮播
        , upload = layui.upload //上传
        , element = layui.element  //元素操作
        , form = layui.form;  //表单
    var $ = layui.$;
    laydate.render({
        elem: '#date',
        min: $('#date').attr('minDate')
    });
    form.on('submit(formSubmit)', function (data) {
        debugger;
        return false;
    });
});