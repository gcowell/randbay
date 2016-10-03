if(window.location.href.indexOf('/users/dashboard') > -1)
{
    (function ()
    {

        $(document).ready(function()
        {

            $("#fancy-img").fancybox({
                openEffect	: 'elastic',
                closeEffect	: 'elastic',
                helpers: {
                    title : {
                        type : 'float'
                    },
                    overlay: {
                        locked: false
                    }
                }
            });

            $("#notifications-loading").show();

            $.ajax(
                {
                    type: 'GET',
                    url: "/notifications",
                    data:
                    {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: handleData
            });

            function handleData (data)
            {
                $("#notifications-loading").hide();

                if(data.html == "")
                {
                    data.html = "<img src=\x22/img/sad-robot.png\x22>";
                }


                $('#notifications-body').hide();
                $('#notifications-body').html(data.html);
                $('#notifications-body').show('slow');


            }

            var rating = $("#transaction-rating").html();
            var checked_id = '#rated-star' + rating;
            var checked_radio = $(checked_id);

            checked_radio.prop("disabled", false);
            checked_radio.prop("checked", true);

            $('#notifications-container').on('click', '#mark-as-read', function(){

                var notification = $(this).parents(".notification-item");
                notification.css("background-color", "#d9e1ec" );

                var id = notification.attr('data-notification-id');

                $(this).hide();

                $.ajax(
                    {
                        type: 'GET',
                        url: "/notifications/read/"+id ,
                        data:
                        {
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: checkNotifications
                    });

                function checkNotifications()
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


        });
    })();
}