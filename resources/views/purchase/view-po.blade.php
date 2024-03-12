@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <style>
    span.select2{
      width: 100% !important;
    }
  </style>
@endsection

@section('content-child')
<div class="col-md-12">
    {{-- header --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Pembelian <em id="edit-area"></em></h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-3">Code</div>
                        <div class="col-1">:</div>
                        <div class="col-8">123455</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Kategori</div>
                        <div class="col-1">:</div>
                        <div class="col-8">Distributor</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Supplier</div>
                        <div class="col-1">:</div>
                        <div class="col-8">CSA</div>
                    </div>
                    <div class="row">
                        <div class="col-3">PIC</div>
                        <div class="col-1">:</div>
                        <div class="col-8">RAMA</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-3">Tipe Pembayaran</div>
                        <div class="col-1">:</div>
                        <div class="col-8">Tempo</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Tanggal Datang</div>
                        <div class="col-1">:</div>
                        <div class="col-8">20 Januari 2023</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Tanggal Tempo</div>
                        <div class="col-1">:</div>
                        <div class="col-8">6 Februari 2023</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
</script>
@endsection
