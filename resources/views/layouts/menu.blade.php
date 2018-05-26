{{--<li class="{{ Request::is('orders*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>Orders</span></a>--}}
{{--</li>--}}
{{--<li class="{{ Request::is('products*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>Products</span></a>--}}
{{--</li>--}}

@if(\Illuminate\Support\Facades\Auth::user()->hasRole('user'))
    <li class="{{ Request::is('stores*') ? 'active' : '' }}">
        <a href="{!! route('stores.index') !!}"><i class="fa fa-edit"></i><span>Stores</span></a>
    </li>
    <li class="{{ Request::is('orders*') ? 'active' : '' }}">
        <a href="/user/orders"><i class="fa fa-edit"></i><span>Orders</span></a>
    </li>
 @endif
@if(\Illuminate\Support\Facades\Auth::user()->hasRole('store_owner'))
    <li class="{{ Request::is('stores*') ? 'active' : '' }}">
        <a href="{!! route('stores.index') !!}"><i class="fa fa-edit"></i><span>Stores</span></a>
    </li>
    <li class="{{ Request::is('products*') ? 'active' : '' }}">
        <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>Products</span></a>
    </li>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->hasRole('delivary_man'))
    <li class="{{ Request::is('orders*') ? 'active' : '' }}">
        <a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>Orders</span></a>
    </li>w
@endif
@if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
    <li class="{{ Request::is('users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>users</span></a>
    </li>
    <li class="{{ Request::is('stores*') ? 'active' : '' }}">
        <a href="{!! route('stores.index') !!}"><i class="fa fa-edit"></i><span>Stores</span></a>
    </li>
    <li class="{{ Request::is('orders*') ? 'active' : '' }}">
        <a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>Orders</span></a>
    </li>
    <li class="{{ Request::is('products*') ? 'active' : '' }}">
        <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>Products</span></a>
    </li>
@endif



