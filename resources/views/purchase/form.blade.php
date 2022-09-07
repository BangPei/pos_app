@extends('layouts.main-layout')

@section('content-style')
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Pembelian</h2>
        </div>
        <div class="card-body ">
            <form form-validate=true id="form-product">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="invoice-no">No Invoice / Faktur</label>
                            <input required type="text" autofocus="true" class="form-control" name="invoice-no" id="invoice-no">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select required name="supplier" id="supplier" class="form-control select2">
                                <option selected value="" disabled>--Pilih Supplier--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="pic">PIC / Driver</label>
                            <input required  type="text" class="form-control" name="pic" id="pic">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label for="due-date">Tgl Datang Barang</label>
                        <input readonly required name="date-time" type="text" id="date-time" class="form-control datepicker"/>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="payment-type">Tipe Pembayaran</label>
                            <select required name="payment-type" id="payment-type" class="form-control select2">
                                <option value="tempo">Tempo</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 due-date">
                        <div class="form-group">
                            <label for="due-date">Tgl Jatuh Tempo</label>
                            <input readonly required type="text" name="due-date" id="due-date" class="form-control datepicker"/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-convertion">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                    </div>
                    <div class="col-md-12 mt-3 table-responsive">
                        <table class="table table-striped table-bordered table-sm" width="100%" id="table-purchase">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                    <th>Pajak</th>
                                    <th>Harga Modal</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" onclick="history.back()" class="btn btn-default "><i class="fas fa-arrow-left"></i> Kembali</button>
                        <button type="submit" class="btn btn-primary "><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
    let purchase = {
        invoice_no:null,
        pic:null,
        supplier:null,
        amount:0,
        subtotal:0,
        discount:0,
        dpp:0,
        tax_paid:0,
        total_item:0,
        tax:0,
        date_time:null,
        due_date:null,
        payment_type:null,
        picture:null,
        delails:[],
    }
    $(document).ready(function(){
        tblPurchase = $('#table-purchase').DataTable({
            paging: false,
            searching: false,
            ordering:  false,
            bInfo : false,
        })

        $('#payment-type').on('change',function(){
            let val = $(this).val();
            if (val == "tempo") {
                $('.due-date').removeClass('d-none')
                $('#due-date').attr('required','required')
            } else {
                $('.due-date').addClass('d-none')
                $('#due-date').removeAttr('required')
            }
        })
    })
</script>
@endsection
