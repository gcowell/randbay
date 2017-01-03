if(window.location.pathname.indexOf('/mailinglist/')>-1)
{

    (function ()
    {
        $(document).ready(function()
        {

            var url_string = window.location.pathname;

            var divided = url_string.split("/");
            var id = divided[2];

            $('#id_input').val(id);


            $("#confirm").click(function()
            {
                $("#unsubscribe_form").submit();
            });

        });



    })();
}