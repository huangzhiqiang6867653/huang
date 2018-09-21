layui.define(['layer', 'element'], function (exports) {
    //退出功能
    $('#logout_id').unbind('click').die('click').bind('click', function (e) {
        layer.confirm('确认退出系统？？', {
            btn: ['确认', '取消']
        }, function (index) {
            layer.close(index);
            window.location.href = "../login/do_logout";
        });
    });

    //子菜单点击事件
    $('.second_menu_id').bind('click', function (e) {
        //获取相应的参数
        var _url = $(this).attr('_href') ? $(this).attr('_href') : $(this).parent().attr('_href'),
            _title = $(this).text(),
            _id = $(this).attr('_id');
        //样式调整
        $(this).removeClass('layui-this').parent().removeClass('layui-show');
        var element = layui.element;
        //r如果tab已存在，切换到这个tab下
        if ($(".layui-tab-title li[lay-id='" + _id + "']").length > 0) {
            element.tabChange('index_tab_filter', _id);
            return;
        }
        //如果tab不存在，新增tab
        element.tabAdd('index_tab_filter', {
            title: _title,
            content: '<iframe style="height: 100%; width: 100%; border: 0;" src="' + _url + '" />',
            id: _id
        });
        //新增的选中
        element.tabChange('index_tab_filter', _id);
    });

    function getCustomerList(callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../customer/get_all_customer_list/',
            success: function (data) {
                if (data.code == 200) {
                    callback && callback(data.result);
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
    }

    getCustomerList(function (list) {
        var arrHtml = [];
        $.each(list, function (index, entry) {
            arrHtml.push('<div>');
            arrHtml.push()
            arrHtml.push('</div>');
        })
        //$('#index_area_id').html(arrHtml.join(''));
    })
});