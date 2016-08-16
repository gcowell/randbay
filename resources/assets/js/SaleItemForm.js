if(window.location.href.indexOf('saleitems/create')>-1)
{

    (function () {

        $(document).ready(function()
        {

//    ******************************************************************************************************************************
//    INITIALISATION
//    ******************************************************************************************************************************


            //INSTANTIATE LOOP FOR ROTATING TIPS
            var divs_one = $('div[id^="tip-one-"]').hide(),
                i = 0;

            (function cycleOne() {

                divs_one.eq(i).fadeIn(400)
                    .delay(5000)
                    .fadeOut(400, cycleOne);

                i = ++i % divs_one.length;

            })();

            //INITIALISE CURRENCIES FOR PRICE INPUT SECTION
            var currencies = {USD : '$', GBP: '£', EUR : '€'};
            var selected_currency = $("#currency-selector :selected").text();
            var currency_symbol = currencies[selected_currency];
            $('.input-symbol span').html(currency_symbol);

            //SET GLYPHICON ON PICTURE UPLOAD BUTTON (WORKAROUND)
            $("label[for='image']").html('<span class="glyphicon glyphicon-cloud-upload"></span> Upload a Picture');

            //SOME JUST IN CASE STATEMENTS TO HIDE CERTAIN FORM ELEMENTS
            $("#world-post").hide();
            $("#domestic-post").hide();
            $("#second").hide();
            $("#third").hide();
            $("#fourth").hide();
            $("#fifth").hide();



//    ******************************************************************************************************************************
//    STEP ONE - DESCRIPTION
//    ******************************************************************************************************************************

            $("#next-btn1").click(function()
            {

               var desc_check = $("#description").val();

               if(desc_check)
               {
                   $('#description-group').removeClass().addClass('form-group');
                   $('#description').tooltip('destroy');

                   $("#first").hide("slow").delay(200);
                   $("#second").show("slow").delay(200);

                   //Just in case
                   $("#third").hide();
                   $("#fourth").hide();
                   $("#tip-two-1").show();
                   $("#fifth").hide();

               }
               else
               {
                   $('#description-group').removeClass().addClass('form-group has-error');
                   $('#description').tooltip(
                       {
                           'show': true,
                           'placement': 'left',
                           'title': "A description is needed..."
                       });

                   $('#description').tooltip('show');
               }

            });


//    ******************************************************************************************************************************
//    STEP TWO - IMAGE
//    ******************************************************************************************************************************

            $(function()
            {
                $("#image").change(function()
                {

                    $("#message").empty(); // To remove the previous error message
                    var file = this.files[0];
                    var imagefile = file.type;
                    var imagesize = file.size;

                    var match=
                        [
                            "image/jpeg",
                            "image/png",
                            "image/jpg",
                            "image/bmp"
                        ];

                    var sizelimit = 2e+6; //In Bytes
//
                    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3])))
                    {
                        $('#previewing').attr('src','/img/loader_small.gif').wait(1000).attr('src','/img/noimage.png');
                        $("#message").wait(1000).html('<div class="alert alert-danger">Please Select A valid Image File</div>');
                        return false;
                    }
                    else
                    {

                        if(imagesize > sizelimit)
                        {
                            $("#message").wait(1000).html('<div class="alert alert-danger">Please select an image smaller than 2MB.</div>');
                            return false;
                        }
                        else
                        {

                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                        }
                    }
                });
            });

            function imageIsLoaded(e)
            {
                $("#image").css("color","green");
                $('#image_preview').css("display", "block");
                $('#previewing').attr('src','/img/loader_small.gif').wait(1000).attr('src', e.target.result).css("maxWidth", "100%");

                $("label[for='image']").wait(1000).html('<span class="glyphicon glyphicon-cloud-upload"></span> Change Picture');

            };



            $("#prev-btn2").click(function()
            {

                $("#second").hide("slow").delay(200);
                $("#first").show("slow").delay(200);

                //Just in case
                $("#fourth").hide();
                $("#third").hide();
                $("#fifth").hide();

            });


            $("#next-btn2").click(function()
            {

                var img_check = $("#image").val();

                if(img_check)
                {
                    $('#image-group').removeClass().addClass('form-group');
                    $('#image').tooltip('destroy');

                    $("#second").hide("slow").delay(200);
                    $("#third").show("slow").delay(200);

                    //Just in case
                    $("#first").hide();
                    $("#fourth").hide();
                    $("#tip-three-1").show();
                    $("#fifth").hide();

                }
                else
                {
                    $('#image-group').removeClass().addClass('form-group has-error');
                    $("label[for='image']").tooltip(
                        {
                            'show': true,
                            'placement': 'left',
                            'title': "Please upload an image..."
                        });

                    $("label[for='image']").tooltip('show');
                }

            });


//    ******************************************************************************************************************************
//    STEP THREE - PRICE
//    ******************************************************************************************************************************

            //LINK CURRENCY SELECTOR TO DISPLAYED CURRENCY SYMBOL
            $("#currency-selector").change(function()
            {
                selected_currency = $("#currency-selector :selected").text();
                currency_symbol = currencies[selected_currency];
                $('.input-symbol span').html(currency_symbol);
                $('#price').tooltip('destroy');

            });

            $("#prev-btn3").click(function()
            {

                $("#third").hide("slow").delay(200);
                $("#second").show("slow").delay(200);

                //Just in case
                $("#fourth").hide();
                $("#first").hide();
                $("#fifth").hide();

            });

            $("#next-btn3").click(function()
            {

                var price_check = $("#price").val();

                if(!isNaN(price_check)&& price_check && price_check >= 1)
                {

                    $('#price-group').removeClass().addClass('form-group');
                    $('#price').tooltip('destroy');

                    $("#third").hide("slow").delay(200);
                    $("#fourth").show("slow").delay(200);

                    //Just in case
                    $("#first").hide();
                    $("#second").hide();
                    $("#fifth").hide();


                }
                else
                {

                    $('#price-group').removeClass().addClass('form-group has-error');

                    $('#price').tooltip(
                        {
                            'show': true,
                            'placement': 'left',
                            'title': "Please enter a valid price, greater than " + currencies[selected_currency] + "1.00"
                        });

                    $('#price').tooltip('show');
                }
            });


//    ******************************************************************************************************************************
//    STEP FOUR - POSTAGE
//    ******************************************************************************************************************************


            //RADIO BUTTON FOR SELECTION OF POSTAL METHOD
            $("#postoption1").click(function()
            {
                $("#domestic-post").show("fast").delay(200);
                $("#world-post").show("fast").delay(200);
            });

            $("#postoption2").click(function()
            {
                $('#world-post').removeClass().addClass('form-group');
                $("#domestic-post").show("fast").delay(200);
                $("#world-post").hide("fast").delay(200);
                $("#world_postage_cost").val('');
                $('#world-post').tooltip('destroy');

            });


            //BACK TO PROGRESSION
            $("#prev-btn4").click(function()
            {
                $("#fourth").hide("slow").delay(200);
                $("#third").show("slow").delay(200);

                //Just in case
                $("#first").hide();
                $("#second").hide();
                $("#fifth").hide();


            });


            $("#next-btn4").click(function()
            {

                //RESET ERRORS
                $('#price_warning').hide();
                $('#world-post').removeClass().addClass('form-group');
                $('#domestic-post').removeClass().addClass('form-group');
                $('#domestic_postage_cost').tooltip('destroy');
                $('#world_postage_cost').tooltip('destroy');


                //CHECK ON THE MAXIMUM SIZE OF THE TRANSACTION
                var maximum_transaction = 10000;
                var price1 = parseInt($("#price").val()) + parseInt($('#domestic_postage_cost').val());
                var price2 = parseInt($("#price").val()) + parseInt($('#world_postage_cost').val());
                price1 = (!isNaN(price1) ? price1 : 0);
                price2 = (!isNaN(price2) ? price2 : 0);

                if( price1 > maximum_transaction || price2 > maximum_transaction)
                {
                    $('#price_warning').show();
                    return;
                }
                else
                {
                    var international_yes_check = $("#postoption1").hasClass("btn btn-default active");
                    var international_no_check = $("#postoption2").hasClass("btn btn-default active");

                    var domestic_postage_check = $("#domestic_postage_cost").val();
                    var world_postage_check = $("#world_postage_cost").val();

                    if(international_yes_check == false && international_no_check == false)
                    {

                        $('#postage-toggle').tooltip(
                            {
                                'show': true,
                                'placement': 'left',
                                'title': "Please select a postage option"
                            });

                        $('#postage-toggle').tooltip('show');
                    }
                    else
                    {
                        $('#postage-toggle').tooltip('destroy');

                        if(international_yes_check == true)
                        {

                            if(!isNaN(domestic_postage_check) && domestic_postage_check)
                            {
                                $('#domestic_postage_cost').tooltip('destroy');

                                if(!isNaN(world_postage_check) && world_postage_check)
                                {
                                    //ALLOW TO GO TO NEXT PAGE
                                    $('#world-post').removeClass().addClass('form-group');
                                    $('#domestic-post').removeClass().addClass('form-group');
                                    $('#world_postage_cost').tooltip('destroy');
                                    $('#domestic_postage_cost').tooltip('show');

                                    $("#fourth").hide("slow").delay(200);
                                    $("#fifth").show("slow").delay(200);

                                    //Just in case
                                    $("#first").hide();
                                    $("#second").hide();
                                    $("#third").hide();
                                }
                                else
                                {
                                    $('#world-post').removeClass().addClass('form-group has-error');

                                    $('#world_postage_cost').tooltip(
                                        {
                                            'show': true,
                                            'placement': 'left',
                                            'title': "Please enter a world postage cost"
                                        });

                                    $('#world_postage_cost').tooltip('show');
                                }
                            }
                            else
                            {
                                $('#domestic-post').removeClass().addClass('form-group has-error');

                                $('#domestic_postage_cost').tooltip(
                                    {
                                        'show': true,
                                        'placement': 'left',
                                        'title': "Please enter a standard postage cost"
                                    });

                                $('#domestic_postage_cost').tooltip('show');

                                if(!isNaN(world_postage_check) && world_postage_check)
                                {
                                    $('#world_postage_cost').tooltip('destroy');
                                }
                                else
                                {
                                    $('#world-post').removeClass().addClass('form-group has-error');

                                    $('#world_postage_cost').tooltip(
                                        {
                                            'show': true,
                                            'placement': 'left',
                                            'title': "Please enter a world postage cost"
                                        });

                                    $('#world_postage_cost').tooltip('show');
                                }
                            }

                        }
                        else
                        {

                            $("#world_postage_cost").val('');

                            if(!isNaN(domestic_postage_check) && domestic_postage_check)
                            {
                                //ALLOW TO GO TO NEXT PAGE
                                $('#world-post').removeClass().addClass('form-group');
                                $('#domestic-post').removeClass().addClass('form-group');
                                $('#world_postage_cost').tooltip('destroy');
                                $('#domestic_postage_cost').tooltip('show');

                                $("#fourth").hide("slow").delay(200);
                                $("#fifth").show("slow").delay(200);

                                //Just in case
                                $("#first").hide();
                                $("#second").hide();
                                $("#third").hide();
                            }
                            else
                            {
                                $('#domestic-post').removeClass().addClass('form-group has-error');

                                $('#domestic_postage_cost').tooltip(
                                    {
                                        'show': true,
                                        'placement': 'left',
                                        'title': "Please enter a standard postage cost"
                                    });

                                $('#domestic_postage_cost').tooltip('show');
                            }
                        }
                    }
                }
            });

//    ******************************************************************************************************************************
//    STEP FIVE - CONFIRMATION
//    ******************************************************************************************************************************


            $("#form-submit").click(function()
            {

                var agreed_check = document.getElementById('agreement').checked;

                if(agreed_check)
                {
                    $('#agreement-group').tooltip('destroy');
                    $("#sale-item-form").submit();
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

            $("#prev-btn5").click(function()
            {
                $("#fifth").hide("slow").delay(200);
                $("#fourth").show("slow").delay(200);

                //Just in case
                $("#first").hide();
                $("#second").hide();
                $("#third").hide();

            });


        });

    })();

}