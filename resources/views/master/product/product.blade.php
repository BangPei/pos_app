@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-2"><h2 class="card-title mt-2">List Produk</h2></div>
        <div class="col-6">
          <form action="" method="">
            <div class="input-group">
              <input autofocus="true" type="text" value="{{ $search }}" name="search" id="search" class="form-control" placeholder="Cari Barcode atau Nama Barang" >
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-4 text-right">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-danger"><i class="fa fa-upload"></i> Import</button>
            <button type="button" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
            <a class="btn btn-primary" href="/product/create">
              <i class="fas fa-plus-circle"></i> Tambah
          </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (count($products) == 0)
      <div class="card">
        <div class="row">
          <div class="col-12 text-center">
            Tidak Ada Product
          </div>
        </div>
      </div>
  @endif

  @foreach ($products as $p)
      <div class="card p-2">
        <div class="row text-center">
          <div class="col">
            @if ((!isset($p->image))|| ($p->image==""))
            <img width="80" src="{{ asset('image/logo/logo.png') }}" class="rounded float-left img-thumbnail" alt="{{ $p->name }}">
            @else
            <img width="80" src="{{ asset('storage/'.$p->image) }}" class="rounded float-left img-thumbnail" alt="{{ $p->name }}">
            @endif
          </div>
          <div class="col-3 text-left">
            <label class="m-0 p-0" for="">{{ Str::upper($p->name) }}</label>
            <p class="m-0 p-0">SKU : <label class="m-0 p-0" for="">{{ $p->barcode }}</label></p>
            <p class="m-0 p-0">Satuan : <label class="m-0 p-0" for="">{{$p->convertion."/".$p->uom?->name??"" }}</label></p>
            <p class="m-0 p-0">Kategori : <label class="m-0 p-0" for="">{{ $p->category?->name??"" }}</label></p>
          </div>
          <div class="col-3">
            <p class="m-0 p-0">Harga Jual</p>
            <p  class="m-0 p-0 p-price-{{ $p->id }}"><label ondblclick="priceClick({{ $p->id }})" for="">Rp. {{ number_format($p->price, 0, ',', ',') }}</label></p>
            <form method="post" action="/product/price" class="form-price-{{ $p->id }} d-none">
              <input type="text" name="id" class="d-none" value="{{ $p->id }}">
              @method('put')
              @csrf
                <div class="input-group mb-3">
                  <input required  type="number" value="{{ old('price',$p->price??'') }}" class="form-control @error('price') is-invalid @enderror" name="price">
                  <div class="input-group-append">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                      <button class="btn btn-danger" type="button"><i class="fa fa-times"></i></button>
                  </div>
              </div>
            </form>
          </div>
          <div class="col-3">
            <p class="m-0 p-0">Stok</p>
            <p class="m-0 p-0 p-stock-{{ $p->stock_id??'' }}"> <label ondblclick={{ isset($p->stock)?"stockClick($p->stock_id)":"" }}>{{ isset($p->stock)?number_format($p->stock?->value??0 / $p->convertion??0, 0, ',', ','):0 }}</label></p>
            <form method="post" action="/product/stock" class="form-stock-{{ $p->stock?->id??'' }} d-none">
              <input type="text" name="id" class="d-none" value="{{ $p->stock?->value??'0' }}">
              @method('put')
              @csrf
                <div class="input-group mb-3">
                  <input required  type="number" value="{{ old('stock',$p->stock->value??'0') }}" class="form-control @error('price') is-invalid @enderror" name="value">
                  <div class="input-group-append">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                  </div>
                  <div class="input-group-append">
                      <button class="btn btn-danger" type="button"><i class="fa fa-times"></i></button>
                  </div>
              </div>
            </form>
          </div>
          <div class="col">
            <p class="m-0 p-0">
              status
              <div class="custom-control custom-switch">
                <input type="checkbox" {{ $p->is_active?'checked':'' }} name="my-switch" class="custom-control-input" id="switch-{{ $p->id }}">
                <label class="custom-control-label" for="switch-{{ $p->id }}"></label>
              </div>
            </p>
          </div>
          <div class="col">
            <p class="m-0 p-0">
              <a href="/product/{{$p->id}}/edit" title="Edit" class="btn btn-sm bg-gradient-success edit-product"><i class="fas fa-eye"></i> Lihat</a>
            </p>
          </div>
        </div>
      </div>
  @endforeach

  <div class="d-flex justify-content-center">
    {{ $products->links() }}
    <br>
    <p>{{ $count }}</p>
  </div>
</div>
@endsection

@section('content-script')
<script>
  function priceClick(id){
    $(`.p-price-${id}`).dblclick(function(){
      $(`.p-price-${id}`).addClass('d-none')
      $(`.form-price-${id}`).removeClass('d-none')
    })
  }
  function stockClick(id){
    $(`.p-stock-${id}`).dblclick(function(){
      $(`.p-stock-${id}`).addClass('d-none')
      $(`.form-stock-${id}`).removeClass('d-none')
    })
  }
</script>
@endsection