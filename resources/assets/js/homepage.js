if(window.location.pathname == '/')
{
    $(window).on('beforeunload', function() {
        $(window).scrollTop(0);
    });


    var jumboHeight = $('.jumbotron').outerHeight();
        function parallax()
        {
            var scrolled = $(window).scrollTop();
            $('.bg').css('height', (jumboHeight-scrolled) + 'px');
        }

        $(window).scroll(function(e)
        {
            parallax();
        });







    $( document ).ready(function() {
        $.ajax({
            type: 'GET',
            url: "/saleitems/rand",
            data:
            {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: displayItems
        });

        function displayItems (data)
        {
            var html = data.html;

            $('#random-img-container').html(html);

        }

        //CHECK IF THE ALERT MODAL IS REQUIRED (NEW PURCHASE OR SALE)
        if ($('#alertModal'))
        {
            $('#alertModal').modal('show');
        }

        //ENABLE FANCY IMAGE EXPANSION ON PICTURE
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


    /*Interactivity to determine when an animated element in in view. In view elements trigger our animation*/

        //window and animation items
        var animation_elements = $.find('.animation-element');
        var web_window = $(window);

        //check to see if any animation containers are currently in view
        function check_if_in_view() {
            //get current window information
            var window_height = web_window.height();
            var window_top_position = web_window.scrollTop();
            var window_bottom_position = (window_top_position + window_height);

            //iterate through elements to see if its in view
            $.each(animation_elements, function() {

                //get the element sinformation
                var element = $(this);
                var element_height = $(element).outerHeight();
                var element_top_position = $(element).offset().top;
                var element_bottom_position = (element_top_position + element_height);

                //check to see if this current container is visible (its viewable if it exists between the viewable space of the viewport)
                if ((element_bottom_position >= window_top_position) && (element_top_position <= window_bottom_position)) {
                    element.addClass('in-view');
                } else {
                    element.removeClass('in-view');
                }
            });

        }

        //on or scroll, detect elements in view
        $(window).on('scroll resize', function() {
            check_if_in_view()
        })
        //trigger our scroll event on initial load
        $(window).trigger('scroll');




    });





}