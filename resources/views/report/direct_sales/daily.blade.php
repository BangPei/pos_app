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
                        <input value="{{ $date }}" readonly type="text" autocomplete="off" placeholder="Masukan Tanggal" class="form-control" id="date" name="date">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar-alt"></i></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <select required name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                      <option selected value="" disabled>--Pilih Kategory--</option>
                      @foreach ($categories as $ct)
                          @if (old('category_id',$product->category_id??'')==$ct->id)
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
    $('#date').datepicker({
        uiLibrary: 'bootstrap',
        format:"dd mmmm yyyy",
        // value:moment().format("DD MMMM YYYY")
    })
  })
</script>
@endsection