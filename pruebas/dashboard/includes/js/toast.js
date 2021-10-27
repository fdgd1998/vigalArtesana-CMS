function showToastMessage(type, content) {
    var messageClass = "";
    switch (type) {
        case 'success':
            messageClass = "alert alert-success";
            break;
        case 'error':
            messageClass = "alert alert-danger";
            break;
        case 'warning':
            messageClass = "alert alert-warning";
            break;
        case 'info':
            messageClass = "alert alert-secondary";
            break;
    }
    var span = $("span").text("<strong>"+content+"</strong>");
    $('#toast').append(span);
    $('#toast').addClass(messageClass);
    $('#toast').removeAttr('hidden');
    setTimeout(function() {
        $('#toast').attr('hidden', '');
        $('#toast').removeClass(messageClass);
        $('#toast').empty();
    }, 5000);
    
}


