if(window.location.href.indexOf('saleitems/create')>-1)
{

    (function () {



        //**************************
        //    DEALS WITH RADIO BUTTON FOR INTERNATIONAL POST
        //
        $(document).ready(function()
        {

            var currencies = {USD : '$', GBP: '£', EUR : '€'};
            var selected_currency = $("#currency-selector :selected").text();
            var currency_symbol = currencies[selected_currency];
            $('.input-symbol span').html(currency_symbol);

            $("#currency-selector").change(function()
            {
                selected_currency = $("#currency-selector :selected").text();
                currency_symbol = currencies[selected_currency];
                $('.input-symbol span').html(currency_symbol);
                $('#price').tooltip('destroy');

            });

            $("label[for='image']").html('<span class="glyphicon glyphicon-cloud-upload"></span> Upload a Picture');


            $("#world-post").hide();
            $("#domestic-post").hide();
            $("#second").hide();
            $("#third").hide();
            $("#fourth").hide();


        //    *********************************
        //    HANDLER TOGGLE WORLD POSTAGE

            $("#postoption1").click(function()
            {
                $("#domestic-post").show("fast").delay(200);
                $("#world-post").show("fast").delay(200);
            });

            $("#postoption2").click(function()
            {
                $("#domestic-post").show("fast").delay(200);
                $("#world-post").hide("fast").delay(200);
                $("#world_postage_cost").val('');
            });

        //    *********************************
        //    HANDLER STEP THROUGH FORM

        //    *********************************
        //    STEP ONE

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


            //    *********************************
            //    STEP TWO

            $(function()
            {
                $("#image").change(function()
                {

                    $("#message").empty(); // To remove the previous error message
                    var file = this.files[0];
                    var imagefile = file.type;

                    var match=
                        [
                            "image/jpeg",
                            "image/png",
                            "image/jpg",
                            "image/bmp"
                        ];
//
                    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3])))
                    {
                        $('#previewing').attr('src','/img/loader_small.gif').wait(1000).attr('src','/img/noimage.png');
                        $("#message").wait(1000).html('<div class="alert alert-danger">Please Select A valid Image File</div>');
                        return false;
                    }
                    else
                    {

                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
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


                }
                else
                {
                    $('#image-group').removeClass().addClass('form-group has-error');
                    $('#image').tooltip(
                        {
                            'show': true,
                            'placement': 'left',
                            'title': "Please upload an image..."
                        });

                    $('#image').tooltip('show');
                }

            });


            //    *********************************
            //    STEP THREE


            $("#prev-btn3").click(function()
            {

                $("#third").hide("slow").delay(200);
                $("#second").show("slow").delay(200);

                //Just in case
                $("#fourth").hide();
                $("#first").hide();


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

        //    *********************************
        //    STEP FOUR

            $("#prev-btn4").click(function()
            {
                $("#fourth").hide("slow").delay(200);
                $("#third").show("slow").delay(200);

                //Just in case
                $("#first").hide();
                $("#second").hide();


            });



            $("#form-submit").click(function()
            {

                $('#world-post').removeClass().addClass('form-group');
                $('#domestic-post').removeClass().addClass('form-group');


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
                            $('#domestic-post').tooltip('destroy');

                            if(!isNaN(world_postage_check) && world_postage_check)
                            {
                                $('#world-post').tooltip('destroy');

                                $("#sale-item-form").submit();
                            }
                            else
                            {
                                $('#world-post').removeClass().addClass('form-group has-error');

                                $('#world-post').tooltip(
                                    {
                                        'show': true,
                                        'placement': 'left',
                                        'title': "Please enter a world postage cost"
                                    });

                                $('#world-post').tooltip('show');
                            }
                        }
                        else
                        {
                            $('#domestic-post').removeClass().addClass('form-group has-error');

                            $('#domestic-post').tooltip(
                                {
                                    'show': true,
                                    'placement': 'left',
                                    'title': "Please enter a standard postage cost"
                                });

                            $('#domestic-post').tooltip('show');

                            if(!isNaN(world_postage_check) && world_postage_check)
                            {
                                $('#world-post').tooltip('destroy');
                            }
                            else
                            {
                                $('#world-post').removeClass().addClass('form-group has-error');

                                $('#world-post').tooltip(
                                    {
                                        'show': true,
                                        'placement': 'left',
                                        'title': "Please enter a world postage cost"
                                    });

                                $('#world-post').tooltip('show');
                            }
                        }

                    }
                    else
                    {

                        $("#world_postage_cost").val('');

                        if(!isNaN(domestic_postage_check) && domestic_postage_check)
                        {
                            $("#sale-item-form").submit();
                        }
                        else
                        {
                            $('#domestic-post').removeClass().addClass('form-group has-error');

                            $('#domestic-post').tooltip(
                                {
                                    'show': true,
                                    'placement': 'left',
                                    'title': "Please enter a standard postage cost"
                                });

                            $('#domestic-post').tooltip('show');
                        }
                    }
                }

            });

        });

    })();

}