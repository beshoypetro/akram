@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Store
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('stores.show_fields')
                    <a href="{!! route('stores.index') !!}" class="btn btn-default">Back</a>
                    <a href="{{ url('store/'.$store->id.'/products') }}" class="btn btn-default">products</a>
                </div>
            </div>
        </div>
    </div>
@endsection
