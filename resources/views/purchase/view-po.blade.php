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
            <h2 class="card-title">Form Pembelian</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12"><label for="">Kode Transaksi : {{ $po->code }}</label></div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">No. Invoice</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ $po->invoice_no??'--' }}</label></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Kategori</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ $po->is_distributor?'Distributor':'Non Distributor' }}</label></div>
                            </div>
                            <div class="row {{ $po->is_distributor?'':'d-none' }}">
                                <div class="col-5">Supplier</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ $po->is_distributor?$po->supplier->name:'' }}</label></div>
                            </div>
                            <div class="row">
                                <div class="col-5">PIC</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ $po->pic}}</label></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">Pembayaran</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ $po->payment_type}}</label></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Tanggal</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ date('d M Y', strtotime($po->date)); }}</label></div>
                            </div>
                            <div class="row {{ $po->payment_type=='lunas'?'d-none':'' }}">
                                <div class="col-5">Jatuh Tempo</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ date('d M Y', strtotime($po->due_date)); }}</label></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Status</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{$po->status?'lunas':'Belum lunas' }}</label></div>
                            </div>
                            <div class="row {{ (($po->payment_type!='lunas') && ($po->status))?'':'d-none' }}">
                                <div class="col-5">Tgl Pembayaran</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="">{{ date('d M Y', strtotime($po->payment_date)); }}</label></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    
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
    $(document).ready(function(){
        $('a[data-widget="pushmenu"]').click()
    })
</script>
@endsection
