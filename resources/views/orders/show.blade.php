@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Order
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('orders.show_fields')
                    <button onclick="goBack()" class="btn btn-default">Go Back</button>

                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function goBack() {
        window.history.back();
    }
</script>
