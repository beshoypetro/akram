<!-- Id Field -->
<div class="form-group">
    {!! Form::label('name', 'name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<div class="form-group">
    {!! Form::label('email', 'email:') !!}
    <p>{!! $user->email !!}</p>
</div>
<div class="form-group">
    {!! Form::label('role_id', 'role_id:') !!}
    <p>{!! \App\Models\Role::find($user->role_id)->name !!}</p>
</div>
<div class="form-group">
    {!! Form::label('vehicle_id', 'vehicle_id:') !!}
    <p>{!! $user->vehicle_id !!}</p>
</div>
<div class="form-group">
    {!! Form::label('phone', 'phone:') !!}
    <p>{!! $user->phone !!}</p>
</div>
<div class="form-group">
    {!! Form::label('address', 'address:') !!}
    <p>{!! $user->address !!}</p>
</div>
<div class="form-group">
    {!! Form::label('address_specific', 'address_specific:') !!}
    <p>{!! $user->address_specific !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $user->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $user->updated_at !!}</p>
</div>

