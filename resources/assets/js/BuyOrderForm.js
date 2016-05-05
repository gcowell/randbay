if(window.location.href.indexOf('buyorders/create')>-1)
{

    (function () {
    //**************************
    //    DEALS WITH RADIO BUTTON FOR INTERNATIONAL POST
    //
        $(document).ready(function()
        {

        //    *********************************
        //    HANDLER STEP THROUGH FORM

        //    *********************************
        //    STEP ONE

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


                    document.getElementById("price-statement").innerHTML = currencies[currency] + " " + buy_price_check;


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

        //    *********************************
        //    STEP TWO

            });

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