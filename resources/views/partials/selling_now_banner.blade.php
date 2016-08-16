<div style="width:1000px; text-align:center; position: relative; z-index: 1000; margin: 0 auto; text-align: center; overflow:hidden;">

        @for ($i = 0; $i < 4; $i++)
            <div style="width:200px; height:200px; display: inline-block;">
                <div id="wrapper" style="border-radius:50%; overflow:hidden; background: #d9e1ec; width:200px; height:200px; position: relative;">
                    <img id="round-img" src="/images/{{ isset($random_saleitems[$i]) ? $random_saleitems[$i]->id . '.' . $random_saleitems[$i]->image_type : 'question.png' }}" style="margin: auto;right: 0;left: 0;bottom: 0;top: 0;position: absolute;display: block;max-height: 100%;max-width: 100%;width: auto;height: auto;  overflow:hidden;">
                </div>
            </div>
        @endfor
</div>

    <div style="width:1000px; text-align:center; position: relative; z-index: 1000; margin: 0 auto; text-align: center; overflow:hidden;">

        @for ($i = 4; $i < 8; $i++)
        <div style="width:200px; height:200px; display: inline-block;">
            <div id="wrapper" style="border-radius:50%; overflow:hidden; background: #d9e1ec; width:200px; height:200px; position: relative;">
                <img id="round-img" src="/images/{{ isset($random_saleitems[$i]) ? $random_saleitems[$i]->id . '.' . $random_saleitems[$i]->image_type : 'question.png' }}" style="margin: auto;right: 0;left: 0;bottom: 0;top: 0;position: absolute;display: block;max-height: 100%;max-width: 100%;width: auto;height: auto;  overflow:hidden;">
            </div>
        </div>
        @endfor


</div>
