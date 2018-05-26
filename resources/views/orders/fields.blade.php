<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Discription Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discription', 'Discription:') !!}
    {!! Form::text('discription', null, ['class' => 'form-control']) !!}
</div>

<!-- Delevary Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('delevary_time', 'Delevary Time:') !!}
    {!! Form::text('delevary_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Shipped Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shipped', 'Shipped:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('shipped', false) !!}
        {!! Form::checkbox('shipped', '1', null) !!} 1
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('orders.index') !!}" class="btn btn-default">Cancel</a>
</div>
