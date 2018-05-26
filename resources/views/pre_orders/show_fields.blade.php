<!-- Product Id Field -->
<div class="form-group">
    {!! Form::label('name', 'name:') !!}
    <p>{!! $order->name !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('price', 'price') !!}
    <p>{!! $order->price!!}</p>
</div>

<!-- Order Id Field -->
<div class="form-group">
    {!! Form::label('discription', 'Description ') !!}
    <p>{!! $order->discription !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('delevary_time', 'delevary_time:') !!}
    <p>{!! $order->delevary_time !!}</p>
</div>


