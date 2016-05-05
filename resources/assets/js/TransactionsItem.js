if(window.location.href.indexOf('/transactions/')>-1)
{

    (function ()
    {

        $(document).ready(function()
        {
            var rating = $("#transaction-rating").html();
            var checked_id = '#rated-star' + rating;
            var checked_radio = $(checked_id);

            checked_radio.prop("disabled", false);
            checked_radio.prop("checked", true);

            var element = $(".shipping-address");
            var JSON_address = element.html();

            if(JSON_address)
            {
                var address = $.parseJSON(JSON_address);
                var human_address = address.recipient_name + '<br>' + address.line1 + '<br>' +  address.city + '<br>' + address.state + '<br>' + address.postal_code + '<br>' + address.country_code;

                element.html(human_address);
            }

        });
    })();
}