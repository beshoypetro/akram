<table class="table table-responsive" id="orders-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Price</th>
        <th>Discription</th>
        <th>Delevary Time</th>
        <th>Shipped</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{!! $order->name !!}</td>
            <td>{!! $order->price !!}</td>
            <td>{!! $order->discription !!}</td>
            <td>{!! $order->delevary_time !!}</td>
            <td>{!! $order->shipped !!}</td>
            <td>
                {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('orders.show', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                    <a href="{!! route('orders.edit', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
               @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    {{$order->render}}
    </tbody>
</table>