$.ajaxSetup({
    error: function (response) {
        var error=JSON.parse(response.responseText);
        alert(error.message);
    }
});