if(window.location.pathname == '/johnpupperman/saleitems')
{

    (function ()
    {

        $(document).ready(function()
        {
            $('#select-all').change(function()
            {
                $('.checkbox').each(function()
                {
                    var box = $(this);
                    if (box.is(":checked"))
                    {
                      box.prop('checked', false);
                    }
                    else
                    {
                      box.prop('checked', true);
                    }
                });
            });

        });
    })();
}