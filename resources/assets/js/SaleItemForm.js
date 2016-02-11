









//**************************
//    DEALS WITH RADIO BUTTON FOR INTERNATIONAL POST
//
$(document).ready(function()
{
    $("#world-post").hide();
    $("#domestic-post").hide();
    $("#second").hide();
    $("#third").hide();




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

//    *********************************
//    STEP TWO

    });

    $("#prev-btn2").click(function()
    {

        $("#second").hide("slow").delay(200);
        $("#first").show("slow").delay(200);

        //Just in case
        $("#third").hide();

    });

    $("#next-btn2").click(function()
    {

        var price_check = $("#price").val();

        if(!isNaN(price_check)&& price_check)
        {

            $('#price-group').removeClass().addClass('form-group');
            $('#price').tooltip('destroy');

            $("#second").hide("slow").delay(200);
            $("#third").show("slow").delay(200);

            //Just in case
            $("#first").hide();

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

//    *********************************
//    STEP THREE

    $("#prev-btn3").click(function()
    {
        $("#third").hide("slow").delay(200);
        $("#second").show("slow").delay(200);

        //Just in case
        $("#first").hide();

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