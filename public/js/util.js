var util = {
    /**
     *检查设备的提交信息是否正确
     */
    isValidFormats: function (form) {
        //检查是否勾选设备
        var formats = form.find('input[name="formats[]"]:checked');
        if (!formats || formats.length == 0) {
            alert('请选择设备！');
            return false;
        }
        //如果有勾选设备，判断是否上传照片
        var imgNum = -1;//标志各个设备上传的照片个数是否一致
        var hasError = false;
        formats.each(function (i, e) {
            var value = $(e).val();
            var imgs = form.find('input[name="' + value + '[]"]');
            if (imgs.length == 0) {
                alert('请您为选择的设备上传照片！');
                hasError = true;
                return false;
            }
            if (imgNum == -1) {
                imgNum = imgs.length;
            } else {
                if (imgNum != imgs.length) {
                    alert('各个设备照片数量不一致！');
                    hasError = true;
                    return false;
                }
            }
        });
        return !hasError;
    }
};