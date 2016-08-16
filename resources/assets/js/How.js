if(window.location.pathname == '/how')
{
    (function ()
    {

        $(document).ready(function()
        {
            $('#buy-btn').click(function()
            {
                $('#sell-details').hide();
                $('#buy-details').show('slow');

            });

            $('#sell-btn').click(function()
            {
                $('#buy-details').hide();
                $('#sell-details').show('slow');

            });

        });


    })();
}