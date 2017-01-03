if(window.location.pathname == '/buyorders')
{

    (function ()
    {

        $(document).ready(function()
        {

            $("#match-loading").show();

            var currency = $('input[name=currency]').val();
            var currencies = {USD : '$', GBP: '£', EUR : '€'};
            var currency_symbol = currencies[currency];

            $('#currency-symbol').text(currency_symbol);

            $("#match-loading").delay(1000).hide("slow");
            $("#match-statement").delay(1500).show("slow");

            $("#go-back").click(function()
            {

                window.location = '/buyorders/create';

            })


            $("#proceed").click(function()
            {

                $("#transaction-form").submit();

            })

            $("#redo").click(function()
            {
                var buyorder_id = $('input[name=buyorder_id]').val();


                $("#match-statement").hide();
                $("#match-loading").show();
                $.ajax(
                    {
                        dataType: "json",
                        url: '/buyorders/redo/'+buyorder_id,
                        success: getSaleitemData
                    });

                function getSaleitemData(data)
                {
                    {
                        var cost = data.total_cost;

                        $('input[name=saleitem_id]').val(data.id);
                        $('input[name=seller_id]').val(data.user_id);
                        $('input[name=price]').val(data.total_cost);

                        $('#total-cost-confirm').text((Math.round(cost*100)/100).toFixed(2));

                        $("#match-loading").delay(200).hide("slow");
                        $("#match-statement").delay(250).show("slow");

                    }
                }

            })



        });
    })();
}