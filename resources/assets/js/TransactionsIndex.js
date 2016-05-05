if(window.location.pathname == '/transactions')
{



    (function ()
    {

        $(document).ready(function()
        {

            if ($('#alertModal'))
            {
                $('#alertModal').modal('show');
            }

            if(location.hash)
            {
                $(".tab-pane").removeClass('tab-pane active').addClass('tab-pane');
                $('a[href=' + location.hash + ']').tab('show');
                var id_string = location.hash.substring(1);
                $(location.hash).removeClass('tab-pane').addClass('tab-pane active');

            }
            else
            {
                var preSelectedTab = localStorage.getItem('selectedTab');

                if (preSelectedTab)
                {
                    $(".tab-pane").removeClass('tab-pane active').addClass('tab-pane');
                    $('a[href=' + preSelectedTab + ']').tab('show');
                    $(preSelectedTab).removeClass('tab-pane').addClass('tab-pane active');
                    location.hash = preSelectedTab;

                }
                else
                {
                    $(".tab-pane").removeClass('tab-pane active').addClass('tab-pane');
                    var default_tab_href = '#items-bought';
                    location.hash = default_tab_href;
                    $('a[href=' + location.hash + ']').tab('show');
                    $('#items-bought').removeClass('tab-pane').addClass('tab-pane active');
                }
            }

            localStorage.setItem('selectedTab', location.hash);

            /////////////////////////////////////////////////////////////

            $(document.body).on("click", "a[data-toggle]", function(event) {
                $(".tab-pane").removeClass('tab-pane active').addClass('tab-pane');
                location.hash = this.getAttribute("href");
            });

            $(window).on('popstate', function() {
                var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
                $(".tab-pane").removeClass('tab-pane active').addClass('tab-pane');
                $('a[href=' + anchor + ']').tab('show');
            });


            //for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e)
            {
                //save the latest tab; use cookies if you like 'em better:
                localStorage.setItem('selectedTab', $(e.target).attr('href'));
            });

















            $(".shipping-address").each(function(i, element)
            {
                //TODO pass in jquery context so that we can use html() - more stable

                var JSON_address = element.innerHTML;
                if(JSON_address)
                {
                    var address = $.parseJSON(JSON_address);
                    var human_address = address.recipient_name + '<br>' + address.line1 + '<br>' +  address.city + '<br>' + address.state + '<br>' + address.postal_code + '<br>' + address.country_code;

                    element.innerHTML = human_address;

                }

            });

            $("#payment-success").delay(4000).hide("slow");


        });
    })();
}