@extends('layouts.main-layout')

@section('content-child')
<div class="col-md-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-2"><h2 class="card-title mt-2">Daftar Produk</h2></div>
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
            <a class="btn btn-success" href="/product/mapping">
              <i class="fas fa-plus-circle"></i> Mapping Stock
            </a>
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

    @foreach ($products as $pr)
      <div class="card p-2">
        <h6>
            <div class="row text-center">
                <div class="col">
                    @if ((!isset($pr->image))|| ($pr->image==""))
                    <img width="80" src="{{ asset('image/logo/logo.png') }}" class="rounded float-left img-thumbnail" alt="{{ $pr->name }}">
                    @else
                    <img width="80" src="{{ asset('storage/'.$pr->image) }}" class="rounded float-left img-thumbnail" alt="{{ $pr->name }}">
                    @endif
                </div>
                <div class="col-3 text-left">
                    <label class="m-0 p-0" for="">{{ Str::upper($pr->name) }}</label>
                    <p class="m-0 p-0">SKU : <label class="m-0 p-0" for="">{{ $pr->barcode }}</label></p>
                    <p class="m-0 p-0">Satuan : <label class="m-0 p-0" for="">{{$pr->convertion."/".$pr->uom?->name??"" }}</label></p>
                    <p class="m-0 p-0">Kategori : <label class="m-0 p-0" for="">{{ $pr->category?->name??"" }}</label></p>
                </div>
                <div class="col-3">
                    <p class="m-0 p-0">Harga Jual</p>
                    <p  class="m-0 p-0 p-price-{{ $pr->id }}">
                      <label for="">Rp. {{ number_format($pr->price, 0, ',', ',') }}</label>
                      <i onclick="editPrice({{ $pr->id }})" class="fa fa-edit text-primary"></i>
                    </p>
                    <form method="post" action="/product/price" class="form-price-{{ $pr->id }} d-none">
                        <input type="text" name="id" class="d-none" value="{{ $pr->id }}">
                        @method('put')
                        @csrf
                        <div class="input-group mb-3">
                            <input required  type="number" value="{{ old('price',$pr->price??'') }}" class="form-control @error('price') is-invalid @enderror" name="price">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i></button>
                                <a onclick="closePrice({{ $pr->id }})" class="btn btn-sm btn-danger cancel-{{ $pr->id }}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-3">
                    <p class="m-0 p-0">Stock</p>
                    <p class="m-0 p-0 p-stock-{{ $pr->stock?->id??"" }}">
                      @if (isset($pr->stock))
                        <label>{{ floor($pr->stock?->value / $pr->convertion)}}
                          <i onclick="editStock({{ $pr->id }})" class="fa fa-edit text-primary"></i>
                        </label>
                      @else
                        <label>Belum Setting</label>
                      @endif
                      
                    </p>
                    @if ($pr->convertion =="" || $pr->convertion==0)
                      <i class="text-danger">Konversi Qty Belum Di setting</i>
                    @else
                      <form method="post" action="/stock/value" class="form-stock-{{ $pr->stock?->id??'' }} d-none">
                        <input type="text" name="id" class="d-none" value="{{ $pr->stock?->id }}">
                        @method('put')
                        @csrf
                            <div class="input-group mb-3">
                                <input value="{{ old('stock',$pr->convertion??'') }}" class="d-none" name="convertion">
                                <input required  type="number" value="{{ old('stock',floor($pr->stock?->value / $pr->convertion)) }}" class="form-control @error('price') is-invalid @enderror" name="value">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i></button>
                                    <button onclick="cancelStock({{ $pr->stock?->id }})" class="btn btn-sm btn-danger cancel-{{ $pr->stock?->id }}" type="button"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                      </form>
                    @endif
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
                <div class="col">
                  <a href="/product/{{$pr->id}}/edit" title="Edit" class="btn btn-sm bg-gradient-success edit-product"><i class="fas fa-eye"></i> Lihat</a>
                </div>
            </div>
        </h6>
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
  function editPrice(id){
    $(`.p-price-${id}`).on('click',function(){
      $(`.p-price-${id}`).addClass('d-none')
      $(`.form-price-${id}`).removeClass('d-none')
    })
  }
  function closePrice(id){
    $(`.cancel-${id}`).on('click',function(){
      $(`.form-price-${id}`).addClass('d-none')
      $(`.p-price-${id}`).removeClass('d-none')
    })
  }
  function editStock(id){
    $(`.p-stock-${id}`).on('click',function(){
      $(`.p-stock-${id}`).addClass('d-none')
      $(`.form-stock-${id}`).removeClass('d-none')
    })
  }
  function cancelStock(id){
    $(`.cancel-${id}`).on('click',function(){
      $(`.p-stock-${id}`).removeClass('d-none')
      $(`.form-stock-${id}`).addClass('d-none')
    })
  }
</script>
@endsection