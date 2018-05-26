<table class="table table-responsive" id="stores-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Location</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($stores as $store)
        <tr>

            <td><a href="{!! route('stores.show', [$store->id]) !!}">{!! $store->name !!}</a></td>
            <td>{!! $store->location !!}</td>
            <td>
                {!! Form::open(['route' => ['stores.destroy', $store->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('stores.show', [$store->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('store_owner') || \Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                    <a href="{!! route('stores.edit', [$store->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
