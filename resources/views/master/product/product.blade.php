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
            <div class="form-group d-none">
              <select class="form-control perpage" style="height: 37px;width:80px" name="perpage" id="perpage">
                <option {{ $query["perpage"]==20?'selected':'' }} value="20">20</option>
                <option {{ $query["perpage"]==50?'selected':'' }} value="50">50</option>
                <option {{ $query["perpage"]==100?'selected':'' }} value="100">100</option>
              </select>
              <div class="form-group d-none">
                <select class="form-control tabbar" style="height: 37px;width:80px" name="tab" id="tab">
                  <option {{ $query["tab"]=='all'?'selected':'' }} value="all">all</option>
                  <option {{ $query["tab"]=='active'?'selected':'' }} value="active">active</option>
                  <option {{ $query["tab"]=='disactive'?'selected':'' }} value="disactive">disactive</option>
                  <option {{ $query["tab"]=='empty-stock'?'selected':'' }} value="empty-stock">empty stock</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="col-4 text-right">
          <div class="btn-group" role="group" aria-label="Basic example">
            <a class="btn btn-primary" href="/stock/create">
              <i class="fas fa-plus-circle"></i> Tambah
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row pb-2">
    <div class="col-12">
      <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
        <li class="nav-item">
          <a data-tab="all" class="nav-link {{ ($query['tab']=='all'||Request::get('tab')==null)?'active':'' }}" data-toggle="pill" href="" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="true">
            Semua
            <small><span class="badge badge-primary">{{ number_format($tab['all']) }}</span></small>
          </a>
        </li>
        <li class="nav-item">
          <a data-tab="active" class="nav-link {{ $query['tab']=='active'?'active':'' }}" data-toggle="pill" href="" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">
            Aktif <small><span class="badge badge-primary">{{ number_format($tab['active']) }}</span></small>
          </a>
        </li>
        <li class="nav-item">
          <a data-tab="disactive" class="nav-link {{ $query['tab']=='disactive'?'active':'' }}" data-toggle="pill" href="" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">
            Tidak Aktif
            <small><span class="badge badge-primary">{{ number_format($tab['disActive']) }}</span></small>
          </a>
        </li>
        <li class="nav-item">
          <a data-tab="empty-stock" class="nav-link {{ $query['tab']=='empty-stock'?'active':'' }}" data-toggle="pill" href="" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">
            Stok Habis
            <small><span class="badge badge-primary">{{ number_format($tab['empty-stock']) }}</span></small>
          </a>
        </li>
      </ul>
      
    </div>
  </div>
  <div class="card p-2">
    <div class="row m-2">
      <div class="col-6 text-left">
        <span >
          Halaman : {{ $page['current_page'] }}, {{ $page['from']??0 }} - {{ $page['to']??0 }} dari {{ number_format($page['total'], 0, ',', ',') }}
        </span>
      </div>
      <div class="col-6 text-right">
        <div class="row justify-content-end">
            Urut Berdasarkan : 
            <select id="order-by" name="order-by">
              <option {{ ($query['order']==='name' &&   $query['sort']==='asc')?'selected':'' }} value="name:asc">Nama [A-Z]</option>
              <option {{ ($query['order']==='name' &&   $query['sort']==='desc')?'selected':'' }} value="name:desc">Nama [Z-A]</option>
              <option {{ ($query['order']==='price' &&   $query['sort']==='asc')?'selected':'' }} value="price:asc">Harga Termurah</option>
              <option {{ ($query['order']==='price' &&   $query['sort']==='desc')?'selected':'' }} value="price:desc">Harga Termalah</option>
              <option {{ ($query['order']==='value' && $query['sort']==='asc')?'selected':'' }} value="value:asc">Stok Terkecil</option>
              <option {{ ($query['order']==='value' && $query['sort']=='desc')?'selected':'' }} value="value:desc">Stok Terbesar</option>
            </select>
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
                  <p class="m-0 p-0">Group Stock : <label class="m-0 p-0" for="">{{ $pr->stock?->name??"" }}</label></p>
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
                      <label>{{ number_format(floor($pr->stock?->value / $pr->convertion), 0, ',', ',')}}
                        <i onclick="editStock({{ $pr->stock->id }})" class="fa fa-edit text-primary"></i>
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
                      <input type="checkbox" {{ $pr->is_active?'checked':'' }} name="my-switch" class="custom-control-input" data-id="{{ $pr->id }}" id="switch-{{ $pr->id }}">
                      <label class="custom-control-label" for="switch-{{ $pr->id }}"></label>
                  </div>
                  </p>
              </div>
              <div class="col">
                <a href="/stock/{{$pr->stock->id}}/edit" title="Edit" class="btn btn-sm bg-gradient-success edit-product"><i class="fas fa-eye"></i> Lihat</a>
              </div>
          </div>
      </h6>
    </div>
  @endforeach

  <div class="row pl-2 pr-2 d-flex justify-content-end">
    <span class="pt-1">Perhalaman : </span> 
    <select id="dummy" name="dummy" class="form-control perpage" style="height: 37px;width:80px">
      <option {{ $query["perpage"]==20?'selected':'' }} value="20">20</option>
      <option {{ $query["perpage"]==50?'selected':'' }} value="50">50</option>
      <option {{ $query["perpage"]==100?'selected':'' }} value="100">100</option>
    </select>
    <span class="pl-1">{{ $products->links() }}</span>
  </div>
</div>
@endsection

@section('content-script')
<script>

  $(document).ready(function(){
    $('.custom-switch').on('click','.custom-control-input',function() {
      let bool = $(this).prop('checked');
      let data = {
        id:$(this).attr('data-id'),
        is_active:bool?1:0
      }
      ajax(data, `{{URL::to('/product/status')}}`, "PUT",
          function(json) {
            console.log(json)
      })
    })

    $('#custom-tabs-five-tab li a').on('click',function(){
      let query = getQueryString();
      query.tab = $(this).attr('data-tab');
      $('#tab').val(query.tab).trigger('change')
      navigate(query);
    })
    $('.perpage').on('change',function(){
      $('#perpage').val($(this).val())
      let query = getQueryString();
      query.perpage = $(this).val();
      navigate(query);
    })
    $('#order-by').on('change',function(){
      let query = getQueryString();
      query.order = $(this).val().split(':')[0];
      query.sort = $(this).val().split(':')[1];
      navigate(query);
    })
  })
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