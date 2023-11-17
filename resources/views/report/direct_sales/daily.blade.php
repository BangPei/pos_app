@extends('layouts.main-layout')
@section('content-class')
 <style>
  li :: marker {
    vertical-align: text-top;
  }
 </style>
@endsection


@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ $title }}</h2>
        </div>
        <div class="card-body">
          <form action="" method="">
            <div class="row">
              <div class="col-3">
                  <div class="form-group">
                    <input value="{{ $code }}" type="text" placeholder="Kode Transaksi" class="form-control" id="code" name="code">
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                      <div class="input-group" style="flex-wrap: nowrap !important;">
                        <input value="{{ $dateFrom }}" type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="from" name="from">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                      <div class="input-group" style="flex-wrap: nowrap !important;">
                        <input {{ isset($dateTo)?'':'disabled' }}  value="{{ $dateTo }}" type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="to" name="to">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <select name="payment" id="payment" class="form-control select2 @error('payment') is-invalid @enderror">
                      <option selected value="" >--Pilih Pembayaran--</option>
                      @foreach ($payments as $ct)
                          @if (old('payment',$payment??'')==$ct->id)
                              <option selected value="{{$ct->id}}">{{$ct->name}}</option>
                          @else
                              <option value="{{$ct->id}}">{{$ct->name}}</option>
                          @endif
                      @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Submit</button>
              </div>
            </div>
          </form>
        </div>
    </div>
    @if (count($directSales) == 0)
        <div class="card">
          <div class="row">
            <div class="col-12 text-center">
              Tidak Ada Transaksi
            </div>
          </div>
        </div>
    @endif
    @foreach ($directSales as $ds)
    <div class="card p-2">
      <div class="row pl-2 pr-2">
        <div class="col">
          {{-- <a href="/stock/{{ $s->id }}/edit"> --}}
            <label class="m-0 p-0 text-info" for="">{{ $ds->code}}</label>
            <label class="m-0 p-0 text-muted" for=""> - Total Item : {{ $ds->total_item}}</label>
          {{-- </a> --}}
        </div>
        <div class="col-4 text-right text-muted">
          <label class="m-0 p-0">Tanggal : {{ date('d M Y H:i:s', strtotime($ds->date)); }}</label>
        </div>
      </div>
      

      @if (count($ds->details)!=0)
      <hr style="margin:10px">
      <div class="row">
        <div class="col-md-6">
          <ul>
            @foreach ($ds->details as $detail)
              <li>
                <div class="row text-center pr-4">
                  <div class="col-6 text-left text-sm">
                    <label class="m-0 p-0" for="">{{ Str::upper($detail->product_name) }}</label>
                    <p class="m-0 p-0">SKU : <span class="m-0 p-0" for="">{{ $detail->product_barcode }}</span></p>
                    <p class="m-0 p-0">Satuan : <span class="m-0 p-0" for="">{{$detail->uom??"--" }}</span></p>
                  </div>
                  <div class="col-3">
                    <p class="m-0 p-0">Harga</p>
                    <p  class="m-0 p-0">
                      <span for="">Rp. {{ number_format($detail->price, 0, ',', ',') }} x {{ number_format($detail->qty, 0, ',', ',') }}</span>
                    </p>
                  </div>
                  <div class="col-3">
                    <p class="m-0 p-0">Diskon</p>
                    <p  class="m-0 p-0">
                      <span for="">Rp. {{ number_format($detail->discount, 0, ',', ',') }}</span>
                    </p>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="col-md-6">
          
        </div>
      </div>
      @endif
      
    </div>
    @endforeach
    <div class="d-flex">
      {{ $directSales->appends(["sort"=>"date"])->links() }}
    </div>
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>

<script>
  $(document).ready(function(){
    $('#from').datepicker({
        uiLibrary: 'bootstrap',
        format:"dd mmmm yyyy",
        maxDate: function () {
            return $('#to').val();
        },
        change: function (e) {
          if ($('#from').val()==""||$('#from').val()==null) {
            $('#to').val("")
            $('#to').attr('disabled',true)
          }else{
            $('#to').removeAttr('disabled')
          }
         }
        // value:moment().format("DD MMMM YYYY")
    })
    $('#to').datepicker({
        uiLibrary: 'bootstrap',
        format:"dd mmmm yyyy",
        minDate: function () {
            return $('#from').val();
        }
        // value:moment().format("DD MMMM YYYY")
    })
  })
</script>
@endsection