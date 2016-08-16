$(document).ready(function()
{

    $.ajax({
        type: 'GET',
        url: "/notifications/check",
        data:
        {
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: notifyUser
    });

    function notifyUser (data)
    {
        var img_src = data.img;

        $('#notification-icon').attr("src", img_src);
    }

});