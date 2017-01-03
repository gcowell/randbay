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

            $("#error-list").delay(4000).hide("slow");




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

                if(!isNaN(buy_price_check)&& buy_price_check && buy_price_check >= 0.01)
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
                            'title': "Please enter a valid price..."
                        });

                    $('#price').tooltip('show');
                }

            });



//    ********************************************************************************************************************************
//    STEP TWO - ABOUT YOU
//    ********************************************************************************************************************************

            $("#prev-btn2").click(function()
            {

                //Just in case
                $("#third").hide();

                $("#second").hide("slow").delay(200);
                $("#first").show("slow").delay(200);

            });


            $("#next-btn2").click(function()
            {

                var email = $("#buyer_email").val();
                var email_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if(email_regex.test(email))
                {
                    $('#email-group').tooltip('destroy');

                    //Just in case
                    $("#first").hide();

                    $("#second").hide("slow").delay(200);
                    $("#third").show("slow").delay(200);
                }
                else
                {
                    $('#email-group').tooltip(
                        {
                            'show': true,
                            'placement': 'left',
                            'title': "Please provide a valid email address"
                        });

                    $('#email-group').tooltip('show');
                }

            });



//    ********************************************************************************************************************************
//    STEP THREE - AGREEMENT
//    ********************************************************************************************************************************

            $("#prev-btn3").click(function()
            {
                //JUST IN CASE
                $("#first").hide();

                $("#third").hide("slow").delay(200);
                $("#second").show("slow").delay(200);

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