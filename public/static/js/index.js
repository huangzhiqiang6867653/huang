layui.define(['layer'], function(exports){
    //退出功能
    $('#logout_id').unbind('click').die('click').bind('click', function (e) {
        layer.confirm('确认退出系统？？', {
            btn: ['确认', '取消']
        }, function(index){
            layer.close(index);
            window.location.href = "../login/do_logout";
        });
    });
});