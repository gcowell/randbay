if(window.location.pathname == '/saleitems')
{
    (function ()
    {

        $(document).ready(function()
        {
            var currencies = {USD : '$', GBP: '£', EUR : '€'};
            $('.currency-symbol').each(
                (function()
                {
                    var symbol = currencies[$( this ).text()];
                    $( this ).html(symbol);
                }));

            $("#deleted-item").delay(2000).hide('slow');

        });

    })();
}