if(window.location.pathname == '/how')
{
    (function ()
    {

        $(document).ready(function()
        {
            $('#buy-btn').click(function()
            {
                $('#sell-details').scroll();


            });

            $('#sell-btn').click(function()
            {
                $('#buy-details').scroll();

            });

        });


    })();
}