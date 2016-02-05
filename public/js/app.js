(function () {
    $.ajaxSetup({
    });

    $('form.hasFormatField').submit(function () {
        return util.isValidFormats($(this));
    });

    uploadResForm = $('#uploadResForm');
    uploadResForm.ajaxForm(function (data) {
        var format = uploadResForm.data('format');
        $('.imgList.' + format + ' .clearfix').before('<div class="imgWrapper">' +
            '<img src="' + data.url + '" style="height:80px;" />' +
            '<input type="hidden" name="' + format + '[]" value="' + data.relativePath + '" /><br>' +
            '<a href="javascript:;" onclick="deleteImg(this)">删除</a>' +
            '</div>');
        uploadResForm.data('format', '');
        uploadResForm.resetForm();
        $('.imgList').dragsort('destroy');
        $('.imgList').dragsort({
            dragSelector: '.imgWrapper'
        });
    });

    submitUploadResForm = function () {
        uploadResForm.submit();
    };

    uploadRes = function (format) {
        uploadResForm.data('format', format);
        uploadResForm.find('input[type=file]').click();
    };

    deleteImg = function (delBtn) {
        $(delBtn).parents('.imgWrapper').remove();
    };
})();
