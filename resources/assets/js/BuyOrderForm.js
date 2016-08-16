if(window.location.href.indexOf('buyorders/create')>-1)
{

    (function () {

        $(document).ready(function()
        {

/***************************************************************************************************************************************
* INITIALISATION
****************************************************************************************************************************************/

            //SETUP CURRENCIES
            var currencies = {USD : '$', GBP: '£', EUR : '€'};
            var selected_currency = $("#requested_currency :selected").text();
            var currency_symbol = currencies[selected_currency];
            $('.input-symbol span').html(currency_symbol);




//    ********************************************************************************************************************************
//    STEP ONE - PRICE
//    ********************************************************************************************************************************

            //UPDATE THE MARKED CURRENCY ON CHANGE O SELECTION
            $("#requested_currency").change(function()
            {
                selected_currency = $("#requested_currency :selected").text();
                currency_symbol = currencies[selected_currency];
                $('.input-symbol span').html(currency_symbol);
                $('#price').tooltip('destroy');
            });


            $("#next-btn1").click(function()
            {


                var buy_price_check = $("#price").val();
                var currency = $("#requested_currency").val();

                if(!isNaN(buy_price_check)&& buy_price_check)
                {
                    $('#price-group').removeClass().addClass('form-group');
                    $('#price').tooltip('destroy');

                    $("#first").hide("slow").delay(200);
                    $("#second").show("slow").delay(200);

                    var currencies = {USD : '$', GBP: '£', EUR : '€'};
                    var formatted_price = (Math.round(buy_price_check*100)/100).toFixed(2);

                    //SET NEXT PAGE STATEMENT TO ROUNDED PRICE
                    document.getElementById("price-statement").innerHTML = currencies[currency] + " " + formatted_price;

                }
                else
                {
                    $('#price-group').removeClass().addClass('form-group has-error');
                    $('#price').tooltip(
                        {
                            'show': true,
                            'placement': 'left',
                            'title': "A price is needed..."
                        });

                    $('#price').tooltip('show');
                }

            });


//    ********************************************************************************************************************************
//    STEP TWO - AGREEMENT
//    ********************************************************************************************************************************

            $("#prev-btn2").click(function()
            {

                $("#second").hide("slow").delay(200);
                $("#first").show("slow").delay(200);

            });


            $("#form-submit").click(function()
            {

               var agreed_check = document.getElementById('agreement').checked;

               if(agreed_check)
               {
                   $('#agreement-group').tooltip('destroy');
                   $("#buyorder-form").submit();
               }
               else
               {
                   $('#agreement-group').tooltip(
                       {
                           'show': true,
                           'placement': 'left',
                           'title': "You must agree to the terms"
                       });

                   $('#agreement-group').tooltip('show');
               }

            });

        });

    })();

}