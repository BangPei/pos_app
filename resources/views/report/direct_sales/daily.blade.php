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
                    <input value="{{ $code }}" type="text" placeholder="Kode Transaksi" class="form-control" id="code" name="code">
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                      <div class="input-group" style="flex-wrap: nowrap !important;">
                        <input value="{{ $date }}" type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="date-from" name="date-from">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                  <div class="form-group">
                      <div class="input-group" style="flex-wrap: nowrap !important;">
                        <input value="{{ $date }}" type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="date-to" name="date-to">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <select required name="payment_type_id" id="payment_type_id" class="form-control select2 @error('payment_type_id') is-invalid @enderror">
                      <option selected value="" disabled>--Pilih Pembayaran--</option>
                      @foreach ($payments as $ct)
                          @if (old('payment_type_id',$directSales->payment_type_id??'')==$ct->id)
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
              {{-- <div class="col-md-4">
                <div class="row">
                  <div class="col-6 text-center" style="display: grid">
                    <dt>Transaksi</dt>
                    <label for="" style="font-size: x-large">{{ number_format($total['data']) }}</label>
                  </div>
                  <div class="col-6 text-center" style="display: grid">
                    <dt>Total (Rp.)</dt>
                    <label for="" style="font-size: x-large">{{ number_format($total['amount']) }}</label>
                  </div>
                </div>
              </div> --}}
            </div>
          </form>
        </div>
    </div>
    <div class="card">
    </div>
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>

<script>
  $(document).ready(function(){
    $('#date-from').datepicker({
        uiLibrary: 'bootstrap',
        format:"dd mmmm yyyy",
        maxDate: function () {
            return $('#date-to').val();
        }
        // value:moment().format("DD MMMM YYYY")
    })
    $('#date-to').datepicker({
        uiLibrary: 'bootstrap',
        format:"dd mmmm yyyy",
        minDate: function () {
            return $('#date-from').val();
        }
        // value:moment().format("DD MMMM YYYY")
    })
  })
</script>
@endsection