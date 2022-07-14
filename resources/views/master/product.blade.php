@extends('layouts.main-layout')

@section('content-child')

@if ($products->count())
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-cart-arrow-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text font-weight-bold p-0">{{ $product->name }}</span>
                <small>{{ $product->uom->name??"--" }}</small>
                <span class="info-box-number font-weight-normal">Rp. {{number_format($product->price,0) }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        @endforeach
    </div>
@endif
@endsection