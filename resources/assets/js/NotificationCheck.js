$(document).ready(function()
{

    //PERFORM CHECK ON NAV BAR LINKS TO CHECK IF USER IS LOGGED IN
    var login = $('#login-link').length;
    var register = $('#register-link').length;

    if(login == 0 && register == 0)
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
    }

});