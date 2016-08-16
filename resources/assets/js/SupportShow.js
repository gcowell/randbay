if(window.location.href.indexOf('/support/')>-1)
{

        $(document).ready(function()
        {

            $("[id^=evidence-image]").change(function(e)
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
                    $("#message").wait(1000).html('<div class="alert alert-danger">Please Select A valid Image File</div>');
                    return false;
                }
                else
                {

                    var input_element = $(this);
                    var reader = new FileReader();
                    reader.readAsDataURL(this.files[0]);

                    reader.onload = (function ()
                    {
                        return function (e)
                        {

                            var img_item = input_element.parents('.evidence-img');
                            img_item.hover(
                                function(){ $(this).children('.delete-button').css('display', 'block') },
                                function(){ $(this).children('.delete-button').css('display', 'none') }
                            )

                            img_item.css('background-image', 'url(' + e.target.result + ')');

                            input_element.siblings('.label-container').children().text('Change');
                            input_element.siblings('.delete-button').hover(
                                function(){ $(this).css('background-color', 'rgba(0,0,0,1)') },
                                function(){ $(this).css('background-color', 'rgba(0,0,0,0.5)') }

                            )

                        }

                    })(input_element);

                }
            });

            $('.delete-button').click(
                function(e)
                {
                    var img_item = $(e.target).parents('.evidence-img');

                    img_item.css('background-image', 'url(http://randbay/img/noimage.png)');

                    $(e.target).siblings('.label-container').children().text('Add');
                    $(e.target).hide();

                    var input = $(e.target).siblings('input[type=file]');

                    input.wrap('<form>').closest('form').get(0).reset();
                    input.unwrap();

                }
            );

            $('#form-submit').click(
                function()
                {
                    $('#alertModal').modal('show');
                }
            );

            $('#form-submit-final').click(
                function()
                {
                    $("#evidence-form").submit();
                }
            );




        });


}

