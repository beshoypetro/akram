<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('email', 'email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('role_id', 'role_id:') !!}
    {!! Form::text('role_id', null, ['class' => 'form-control']) !!}
</div>
@if($user->hasRole('delivary_man'))
<div class="form-group col-sm-6">
    {!! Form::label('vehicle_id', 'vehicle_id:') !!}
    {!! Form::text('vehicle_id', null, ['class' => 'form-control']) !!}
</div>
@endif
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('address', 'address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('address_specific', 'address_specific:') !!}
    {!! Form::text('address_specific', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
