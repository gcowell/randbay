@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="row">
        <div class="col-md-3" style="width: 200px;">
            <h3>Picture</h3>
        </div>
        <div class="col-md-3">
            <h3>Description</h3>
        </div>
        <div class="col-md-2">
            <h3>Checked</h3>
            <p>{!! Form::checkbox(null, null, false, ['id' => 'select-all']) !!}</p>
        </div>
        <div class="col-md-2">
            <h3>Delete</h3>
        </div>
    </div>
    {!! Form::open(['url' => 'johnpupperman/saleitems', 'id' => 'sale-item-check'])!!}

    @foreach ($unchecked_saleitems as $saleitem)

    <div class="row">
        <div class="col-md-3" id="image-list">
            <a id="fancy-img" href="{{ 'images/' . $saleitem->id . '.' . $saleitem->image_type }}">
                {!! Html::image('images/' . $saleitem->id . '.' . $saleitem->image_type, null, [ 'id' => 'previewing' ]) !!}
            </a>
        </div>
        <div class="col-md-3">
            {{ $saleitem->description }}
        </div>
        <div class="col-md-2">
            {!! Form::checkbox($saleitem->description, $saleitem->id, false, ['class' => 'checkbox']) !!}
        </div>
        <div class="col-md-2">
            <a href="{{ url('johnpupperman/saleitems/delete/'. $saleitem->id) }}">Delete</a>
        </div>

    </div>

    @endforeach

    <diw class="row">
        <div class="col-md-12">
            {!! Form::submit('Set as Checked', ['class' => 'btn btn-primary']) !!}
        </div>
    </diw>

    {!! Form::close()  !!}

</div>

@stop