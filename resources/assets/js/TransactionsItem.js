if(window.location.pathname == '/transactions')
{

    (function ()
    {

        $(document).ready(function()
        {

            $(".shipping-address").each(function(i, element)
            {
                var JSON_address = (element.innerHTML);
                if(JSON_address)
                {
                    var address = $.parseJSON(JSON_address);
                    var human_address = address.recipient_name + '<br>' + address.line1 + '<br>' +  address.city + '<br>' + address.state + '<br>' + address.postal_code + '<br>' + address.country_code;

                    element.innerHTML = human_address;

                }

            });

            $("#payment-success").delay(4000).hide("slow");


        });
    })();
}