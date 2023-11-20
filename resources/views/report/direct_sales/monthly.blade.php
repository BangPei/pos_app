@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
              <div class="col-4">
                  <div class="form-group">
                      <label for="date">Bulan</label>
                      <input required value="{{ $date }}" type="text" autocomplete="off" placeholder="Masukan Bulan" class="form-control month-picker" id="month" name="month">
                  </div>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" style="margin-top: 32px !important" type="submit"><i class="fa fa-search"></i> Submit</button>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-6 text-center" style="display: grid">
                    <dt>Transaksi</dt>
                    <label style="font-size: x-large">{{ number_format($total['data']) }}</label>
                  </div>
                  <div class="col-6 text-center" style="display: grid">
                    <dt>Total (Rp.)</dt>
                    <label for="" style="font-size: x-large">{{ number_format($total['amount']) }}</label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered table-sm "style="width: 100% !important" id="table-daily">
            <thead>
              <tr>
                <th class="text-right">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-right">Transaksi</th>
                <th class="text-right">Total (.Rp)</th>
                <th class="text-center">Detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($directSales as $ds)
                  <tr>
                      <td class="text-right">{{ $loop->index+1 }}</td>
                      <td class="text-center">{{ $date }}</td>
                      <td class="text-right">{{ number_format($ds['data']) }}</td>
                      <td class="text-right">{{ number_format($ds['amount']) }}</td>
                      <td class="text-center"></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
</div>
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/jquery-blockUI/js/jquery.blockUI.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
  let dsDetail = [];
    $(document).ready(function(){
        table = $('table').DataTable({
          paging: false,
          searching: false,
          ordering:  false,
          bInfo : false
        })
    })
</script>
@endsection
