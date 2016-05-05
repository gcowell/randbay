if(window.location.href.indexOf('/users/dashboard') > -1)
{
    (function ()
    {

        $(document).ready(function()
        {


//            var tits = $("");
//            console.log(tits);
//                .click(function()
//            {
//                var parent = $(this).parents();
//                console.log(parent);
//                //set colour to normal
//            });


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
//                if(data.html == "")
//                {
//                    data.html = "<span>You have no notifications!</span>";
//                }


                $('#notifications-body').hide();
                $('#notifications-body').html(data.html);
                $('#notifications-body').show("fast");

            }

            var rating = $("#transaction-rating").html();
            var checked_id = '#rated-star' + rating;
            var checked_radio = $(checked_id);

            checked_radio.prop("disabled", false);
            checked_radio.prop("checked", true);

            $('#notifications-container').on('click', '#mark-as-read', function(){

                var notification = $(this).parents(".notification-item");
                notification.css("background-color", "#cccccc" );

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
                        success: updateNotification
                    });

                function updateNotification()
                {

                }


            });


        });
    })();
}