@extends('layouts.main-layout')

@section('content-child')
<div class="col-md-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-2"><h2 class="card-title mt-2">Group Stok</h2></div>
        <div class="col-6">
          <form action="" method="">
            <div class="input-group">
              <div class="input-group-prepend">
                <select class="form-control" name="search-type" id="search-type">
                  <option {{ app('request')->input('search-type') == "name"?"selected":"" }} value="name">Produk</option>
                  <option {{ app('request')->input('search-type') == "barcode"?"selected":"" }} value="barcode">Barcode</option>
                </select>
              </div>
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

  @if (count($stocks) == 0)
      <div class="card">
        <div class="row">
          <div class="col-12 text-center">
            Tidak Ada Product
          </div>
        </div>
      </div>
  @endif

  @foreach ($stocks as $s)
      <div class="card p-2">
        <div class="row pl-2 pr-2">
          <div class="col">
            <a href="">
              <label class="m-0 p-0" for="">{{ Str::upper($s->name) }}</label>
            </a>
          </div>
          <div class="col-4">
            <label class="m-0 p-0" for="">Stock : {{ $s->value }}</label>
            </div>
        </div>
        @if (count($s->products)!=0)
            <hr style="margin:10px">
            @foreach ($s->products as $pr)
              <h6>
                <div class="row text-center pl-5 pr-5">
                  <div class="col">
                    @if ((!isset($pr->image))|| ($pr->image==""))
                    <img width="60" src="{{ asset('image/logo/logo.png') }}" class="rounded float-left img-thumbnail" alt="{{ $pr->name }}">
                    @else
                    <img width="60" src="{{ asset('storage/'.$pr->image) }}" class="rounded float-left img-thumbnail" alt="{{ $pr->name }}">
                    @endif
                  </div>
                  <div class="col-3 text-left">
                    <label class="m-0 p-0" for="">{{ Str::upper($pr->name) }}</label>
                    <p class="m-0 p-0">SKU : <label class="m-0 p-0" for="">{{ $pr->barcode }}</label></p>
                    {{-- <p class="m-0 p-0">Satuan : <label class="m-0 p-0" for="">{{$pr->convertion."/".$pr->uom?->name??"" }}</label></p> --}}
                    <p class="m-0 p-0">Kategori : <label class="m-0 p-0" for="">{{ $pr->category?->name??"" }}</label></p>
                  </div>
                  <div class="col-3">
                    <p class="m-0 p-0">Harga Jual</p>
                    <p  class="m-0 p-0 p-price-{{ $pr->id }}"><label ondblclick="priceClick({{ $pr->id }})" for="">Rp. {{ number_format($pr->price, 0, ',', ',') }}</label></p>
                    <form method="post" action="/product/price" class="form-price-{{ $pr->id }} d-none">
                      <input type="text" name="id" class="d-none" value="{{ $pr->id }}">
                      @method('put')
                      @csrf
                        <div class="input-group mb-3">
                          <input required  type="number" value="{{ old('price',$pr->price??'') }}" class="form-control @error('price') is-invalid @enderror" name="price">
                          <div class="input-group-append">
                              <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i></button>
                              <button class="btn btn-danger" type="button"><i class="fa fa-times"></i></button>
                          </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-3">
                    <p class="m-0 p-0">Tersedia</p>
                    <p class="m-0 p-0"> <label>{{ number_format($s->value / $pr->convertion??0, 0, ',', ',')}}</label></p>
                    <form method="post" action="/product/stock" class="form-stock-{{ $pr->stock?->id??'' }} d-none">
                      <input type="text" name="id" class="d-none" value="{{ $pr->stock?->value??'0' }}">
                      @method('put')
                      @csrf
                        <div class="input-group mb-3">
                          <input required  type="number" value="{{ old('stock',$pr->stock->value??'0') }}" class="form-control @error('price') is-invalid @enderror" name="value">
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
                        <input type="checkbox" {{ $pr->is_active?'checked':'' }} name="my-switch" class="custom-control-input" id="switch-{{ $pr->id }}">
                        <label class="custom-control-label" for="switch-{{ $pr->id }}"></label>
                      </div>
                    </p>
                  </div>
                  <div class="col-">
                    <p class="m-0 p-0">
                      <a href="/product/{{$pr->id}}/edit" title="Edit" class="btn btn-sm bg-gradient-success edit-product"><i class="fas fa-eye"></i> Lihat</a>
                    </p>
                  </div>
                </div>
              </h6>
            @endforeach
        @endif
      </div>
  @endforeach

  <div class="d-flex justify-content-center">
    {{ $stocks->links() }}
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