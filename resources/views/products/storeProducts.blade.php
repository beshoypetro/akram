@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Products
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <form method="GET" action="/preOrders/confirmation">
                        {{ csrf_field() }}
                    @foreach($products as $product)

                        @if($product->number > 0)
                        <div class="column column-block block-list-larg single-item">
                            <div class="col col-info item-content">
                                <a class="itemLink sk-clr2 sPrimaryLink" href="https://egypt.souq.com/eg-en/oneclick-k360-dual-sim-32mb-32mb-ram-2g-light-blue-29477669/i/" title="{{$product->name}}">
                                    <h1 class="itemTitle">
                                        {{$product->name}}		</h1>
                                </a></div>
                                <ul class="selling-points">
                                    <li>
                                        <strong>price</strong> 		<span>{{$product->price}}</span>
                                    </li>
                                    <li>
                                        <strong>discription</strong> 		<span>{{$product->discription}}</span>
                                    </li>
                                    <li>
                                        <strong>number</strong> 		<span>{{$product->number}}</span>
                                    </li>
                                    <div class="form-group">
                                        <div class="checkbox ">
                                            <label><input type="checkbox" name="productId[]" value="{{$product->id}}">select product</label>
                                        </div>
                                    </div>
                                </ul>

                            </div>
                            @endif
                    @endforeach
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                            <a href="/" type="Cancel" class="btn btn-default">Cancel</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
