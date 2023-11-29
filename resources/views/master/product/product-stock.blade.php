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
              <input autofocus="true" type="text" value="{{ $query['search'] }}" name="search" id="search" class="form-control" placeholder="Masukan Barcode atau Nama Barang" >
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-4 text-right">
          <div class="btn-group" role="group" aria-label="Basic example">
            {{-- <button type="button" class="btn btn-danger"><i class="fa fa-upload"></i> Import</button>
            <button type="button" class="btn btn-success"><i class="fa fa-download"></i> Download</button> --}}
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
          <a data-tab="empty-stock" class="nav-link {{ $query['tab']=='empty-stock'?'active':'' }}" data-toggle="pill" href="" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Stok 0</a>
        </li>
      </ul>
      
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
          <div class="col-7">
            <a href="/stock/{{ $s->id }}/edit">
              <label class="m-0 p-0" for="">{{ Str::upper($s->name) }}</label>
              <a class="pl-1" href="/stock/{{ $s->id }}/edit"> <i class="fa fa-eye"></i></a>
            </a>
          </div> 
          <div class="col-3 text-right">
            <label class="m-0 p-0 p-stock-{{ $s->id??"" }}">
              Stock : {{ number_format($s->value) }} 
              <i onclick="editStock({{ $s->id }})" class="fa fa-edit text-primary"></i>
            </label>
            <form method="post" action="/stock/value" class="form-stock-{{ $s->id }} d-none">
              @method('put')
              @csrf
              <input type="text" name="id" class="d-none" value="{{ $s->id }}">
                  <div class="input-group mb-3">
                      <input required  type="number" value="{{ old('stock',floor($s->value)) }}" class="form-control @error('price') is-invalid @enderror" name="value">
                      <div class="input-group-append">
                          <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i></button>
                          <button onclick="cancelStock({{ $s->id }})" class="btn btn-sm btn-danger cancel-{{ $s->id }}" type="button"><i class="fa fa-times"></i></button>
                      </div>
                  </div>
            </form>
          </div>
          <div class="col text-right pr-4">
            <div class="custom-control custom-switch switch-stock">
              <label class="pr-5">status : </label>
              <input data-id="{{ $s->id }}" type="checkbox" {{ $s->is_active?'checked':'' }} name="my-switch" class="custom-control-input" id="switch-{{ $s->id }}">
              <label class="custom-control-label" for="switch-{{ $s->id }}"></label>
            </div>
          </div>
          @if (count($s->products)==0)
            <div class="col text-right">
              <form method="POST" action="/stock/remove">
                @csrf
                @method("delete")
                <input type="text" class="d-none" name="stock-id" value="{{ $s->id }}">
                <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i> Hapus</button>
              </form>
            </div>
          @endif
        </div>

        @if (count($s->products)!=0)
            <hr style="margin:10px">
            @foreach ($s->products as $pr)
              <h6>
                <div class="row text-center pl-4 pr-4">
                  <div class="col-1">
                    @if ((!isset($pr->image))|| ($pr->image==""))
                    <img width="60" src="{{ asset('image/logo/logo.png') }}" class="rounded float-left img-thumbnail" alt="{{ $pr->name }}">
                    @else
                    <img width="60" src="{{ asset('storage/'.$pr->image) }}" class="rounded float-left img-thumbnail" alt="{{ $pr->name }}">
                    @endif
                  </div>
                  <div class="col-3 text-left">
                    <label class="m-0 p-0" for="">{{ Str::upper($pr->name) }}</label>
                    <p class="m-0 p-0">SKU : <label class="m-0 p-0" for="">{{ $pr->barcode }}</label></p>
                    <p class="m-0 p-0">Satuan : <label class="m-0 p-0" for="">{{$pr->convertion."/".$pr->uom?->name??"" }}</label></p>
                    
                  </div>
                  <div class="col-3">
                    <p class="m-0 p-0">Harga Jual</p>
                    <p  class="m-0 p-0 p-price-{{ $pr->id }}">
                      <label for="">Rp. {{ number_format($pr->price, 0, ',', ',') }}</label>
                      <i onclick="priceClick({{ $pr->id }})" class="fa fa-edit text-primary"></i>
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
                  <div class="col-3 text-right">
                    <p class="m-0 p-0"> <label>{{ number_format(floor($s->value / $pr->convertion??0), 0, ',', ',')}}</label></p>
                  </div>
                  <div class="col text-right">
                    <p class="m-0 p-0">
                      <div class="custom-control switch-product custom-switch">
                        <input data-id="{{ $pr->id }}" type="checkbox" {{ $pr->is_active?'checked':'' }} name="my-switch" class="custom-control-input" id="switch-{{ $pr->id }}">
                        <label class="custom-control-label" for="switch-{{ $pr->id }}"></label>
                      </div>
                    </p>
                  </div>
                  {{-- <div class="col-">
                    <p class="m-0 p-0">
                      <a href="/product/{{$pr->barcode}}/edit" title="Edit" class="btn btn-sm bg-gradient-success edit-product"><i class="fas fa-eye"></i> Lihat</a>
                    </p>
                  </div> --}}
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

  $(document).ready(function(){
    $('.switch-stock').on('click','.custom-control-input',function() {
      let bool = $(this).prop('checked');
      let data = {
        id:$(this).attr('data-id'),
        is_active:bool?1:0
      }
      ajax(data, `{{URL::to('/stock/status')}}`, "PUT",
          function(json) {
            location.reload();
      })
    })
    $('.switch-product').on('click','.custom-control-input',function() {
      let bool = $(this).prop('checked');
      let data = {
        id:$(this).attr('data-id'),
        is_active:bool?1:0
      }
      ajax(data, `{{URL::to('/product/status')}}`, "PUT",
          function(json) {
            location.reload();
      })
    })

    $('#custom-tabs-five-tab li a').on('click',function(){
      let query = getQueryString();
      query.tab = $(this).attr('data-tab');
      let params = "?";
      for (const key in query) {
        params += `${key}=${query[key]}&`
      }
      let loc = window.location;
      window.location=`${loc.origin}${loc.pathname}${params}`
    })
    initialTab();
  })
  function initialTab(){
    let query = getQueryString();
    query.tab = query.tab==undefined?"all":query.tab
    console.log(query);
  }
  function closePrice(id){
    $(`.cancel-${id}`).on('click',function(){
      $(`.form-price-${id}`).addClass('d-none')
      $(`.p-price-${id}`).removeClass('d-none')
    })
  }
  function priceClick(id){
    $(`.p-price-${id}`).on('click',function(){
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