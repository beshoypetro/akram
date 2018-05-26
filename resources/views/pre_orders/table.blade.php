<table class="table table-responsive" id="preOrders-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Discription</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{!! $product->name !!}</td>
            <td>{!! $product->price !!}</td>
            <td>{!! $product->discription !!}</td>
            <td>
{{--                {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}--}}
                <div class='btn-group'>
                    <a href="{!! route('products.show', [$product->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {{--<a href="{!! route('preOrders.edit', [$preOrder->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>--}}
                    {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                </div>
{{--                {!! Form::close() !!}--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-responsive" id="preOrders-table">
    <thead>
    <tr>
        <th>Total Price</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>
    <tdbody>
        <tr>
            <td>{!! $total_price !!}</td>
            <td>
                <form method="POST" action="{{ route('saveOrder') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                    {{--<input type="hidden" class="form-control" id="name" name="name" value="{{$products}}">--}}
                <button type="submit" class="btn btn-primary">Confirm</button>
                    <a href="/" type="Cancel" class="btn  btn-sm btn-default">Cancel</a>
                    @foreach($products as $product)
                    <input type="hidden"  name="products[]"  value="{{$product->id}}" />
                    <input type="hidden"  name="price"       value="{{$total_price }}" />
                    <input type="hidden"  name="store_id"    value="{{$product->store_id}}" />
                    <input type="hidden"  name="user_id"     value="{{\Illuminate\Support\Facades\Auth::user()->id}}" />
                    @endforeach
                </form>
            </td>
        </tr>

    </tdbody>
</table>