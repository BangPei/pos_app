@extends('layouts.main-layout')

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
                    <input value="{{ $query["product"] }}" type="text" placeholder="Barcode / Nama Produk" class="form-control" id="product" name="product">
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                    <input value="{{ $query["code"] }}" type="text" placeholder="Kode Transaksi" class="form-control" id="code" name="code">
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                      <div class="input-group" style="flex-wrap: nowrap !important;">
                        <input value="{{ $query["dateFrom"] }}" type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="from" name="from">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                      <div class="input-group" style="flex-wrap: nowrap !important;">
                        <input {{ isset($query["dateTo"])?'':'disabled' }}  value="{{ $query["dateTo"] }}" type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="to" name="to">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <select name="payment" id="payment" class="form-control select2 @error('payment') is-invalid @enderror">
                      <option selected value="" >--Semua Pembayaran--</option>
                      @foreach ($payments as $ct)
                          @if (old('payment',$query["payment"]??'')==$ct->id)
                              <option selected value="{{$ct->id}}">{{$ct->name}}</option>
                          @else
                              <option value="{{$ct->id}}">{{$ct->name}}</option>
                          @endif
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-3 d-none">
                <div class="form-group">
                  <select class="form-control perpage" style="height: 37px;width:80px" name="perpage" id="perpage">
                    <option {{ $query["perpage"]==20?'selected':'' }} value="20">20</option>
                    <option {{ $query["perpage"]==50?'selected':'' }} value="50">50</option>
                    <option {{ $query["perpage"]==100?'selected':'' }} value="100">100</option>
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
    <div class="card p-2">
      <div class="row m-2">
        <div class="col-6 text-left">
          <span class="font-weight-bold" >
            Data : {{ number_format($total['data'], 0, ',', ',') }}
          </span>
        </div>
        <div class="col-6 text-right">
          <span class="font-weight-bold" >
            Grand Total : Rp. {{ number_format($total['amount'], 0, ',', ',') }}
          </span>
        </div>
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
            <label class="m-0 p-0 text-info">{{ $ds->code}}</label>
            <label class="m-0 p-0 text-muted"> - Total Item : {{ $ds->total_item}}</label>
          {{-- </a> --}}
        </div>
        <div class="col-4 text-right text-muted">
          <label class="m-0 p-0">Tanggal : {{ date('d M Y H:i:s', strtotime($ds->date)); }}</label>
        </div>
      </div>
      

      @if (count($ds->details)!=0)
      <hr style="margin:10px">
      <div class="row pr-3">
        <div class="col-md-6">
          <ul>
            @foreach ($ds->details as $detail)
            <div class="{{ ($loop->index >2)?'collapse':'' }}" id="{{ ($loop->index >2)?'collapse-'.$ds->code:'' }}">
              <li>
                <div class="row text-center pr-4">
                  <div class="col text-left text-sm">
                    <label class="m-0 p-0" >{{ Str::upper($detail->product_name) }}</label>
                    <p class="m-0 p-0">SKU : <span class="m-0 p-0" >{{ $detail->product_barcode }}</span></p>
                    <p class="m-0 p-0">Satuan : <span class="m-0 p-0" >{{$detail->uom??"--" }}</span></p>
                  </div>
                  <div class="col-3 text-right">
                    <p class="m-0 p-0">Harga</p>
                    <p  class="m-0 p-0">
                      <span >{{ number_format($detail->price, 0, ',', ',') }} <small>x</small> {{ number_format($detail->qty, 0, ',', ',') }}</span>
                    </p>
                  </div>
                </div>
                @if(!($loop->last))
                  <hr style="margin: 0px !important;">
                @endif
              </li>
            </div>
            @endforeach
          </ul>
          @if (count($ds->details) > 3)
            <div class="d-flex justify-content-center">
              <a data-toggle="collapse" href="#collapse-{{ $ds->code }}" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-angle-down"></i> Klik</a>
            </div>
          @endif
        </div>
        <div class="col-md-6 text-right">
          <div class="row mt-1">
            <div class="col">
              <p class="m-0 p-0">Subtotal</p>
              <p  class="m-0 p-0">
                <span >Rp. {{ number_format($ds->subtotal, 0, ',', ',') }}</span>
              </p>
              <p class="m-0 p-0"><small>
                Pembayaran : <span class="badge badge-info"> {{ $ds->paymentType->name }} 
                @if ($ds->bank !=null)
                  {{ $ds->bank->name }}
                @endif
                </span>
              </small></p>
              @if ($ds->reduce>0)
                  ({{ $ds->reduce }}%) Rp. {{ number_format($ds->reduce_value, 0, ',', ',') }}
              @endif
            </div>
            <div class="col">
              <p class="m-0 p-0">Diskon</p>
              <p  class="m-0 p-0">
                <span >Rp. {{ number_format(($ds->discount+$ds->additional_discount), 0, ',', ',') }}</span>
              </p>
            </div>
            <div class="col">
              <p class="m-0 p-0">Grand Total</p>
              <p  class="m-0 p-0">
                <label class="font-weight-bold" >Rp. {{ number_format(($ds->amount), 0, ',', ',') }}</label>
              </p>
              <br>
              <p class="m-0 pb-1 pt-1">
                <a target="_blank" rel="noopener noreferrer" href="/transaction/{{ $ds->code }}/edit" title="Lihat" class="btn btn-sm bg-gradient-success"><i class="fas fa-eye"> Detail</i></a> 
              </p>
              <form action="/transaction/struct/{{ $ds->code }}" method="GET">
                <button type="submit" title="Lihat" class="btn btn-sm bg-gradient-primary"><i class="fas fa-print"> Print Struk</i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
    @endforeach
    <div class="row d-flex text-right">
      <span class="pt-1">Perhalaman : </span> 
      <select class="form-control perpage" style="height: 37px;width:80px">
        <option {{ $query["perpage"]==20?'selected':'' }} value="20">20</option>
        <option {{ $query["perpage"]==50?'selected':'' }} value="50">50</option>
        <option {{ $query["perpage"]==100?'selected':'' }} value="100">100</option>
      </select>
      <span class="pl-1">{{ $directSales->links() }}</span>
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
            $('#to').attr('required',false)
          }else{
            $('#to').removeAttr('disabled')
            $('#to').attr('required',true)
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

    $('.perpage').on('change',function(){
      $('#perpage').val($(this).val())
      let query = getQueryString();
      query.perpage = $(this).val();
      let params = "?";
      for (const key in query) {
        params += `${key}=${query[key]}&`
      }
      let loc = window.location;
      window.location=`${loc.origin}${loc.pathname}${params}`
    })
  })
</script>
@endsection