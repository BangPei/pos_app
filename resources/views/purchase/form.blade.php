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
                                @foreach ($supplier as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
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
                        <label for="date-time">Tgl Datang Barang</label>
                        <input readonly required name="date-time" type="text" id="date-time" class="form-control"/>
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
                        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
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


<div class="modal fade" id="modal-product" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">List Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-sm table-striped table-bordered" width="100%" id="table-product">
              <thead>
                <tr>
                  <th>Barcode</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
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

        $('#modal-product').on('show.bs.modal', function (e) {
      tblProduct = $('#table-product').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
          url:"{{URL::to('item-convertion/dataTable')}}",
          type:"GET",
        },
        columns:[
          {
            data:"barcode",
            defaultContent:"--"
          },
          {
            data:"name",
            defaultContent:"--"
          },
          {
            data:"uom.name",
            defaultContent:"--"
          },
          {
            data:"price",
            defaultContent:"0",
            mRender:function(data,type,full){
              return `Rp. ${formatNumber(data)}`
            }
          },
          {
            data: 'id',
            mRender: function(data, type, full) {
              return `<a title="delete" class="btn btn-sm bg-gradient-primary add-product"><i class="fas fa-check"></i></a>`
            }
          }
        ],
        columnDefs: [
            { 
              className: "text-center",
              targets: [2,4]
            },
          ],
      })
      $('div.dataTables_filter input', tblProduct.table().container()).focus();
    })

    $('#modal-product').on('hidden.bs.modal', function (e) {
      $('#barcode').focus()
      $('#table-product').DataTable().destroy();
    })

        $('#date-time').datepicker({
            uiLibrary: 'bootstrap4',
            format:"dd mmmm yyyy",
        });

        $('#due-date').datepicker({
            uiLibrary: 'bootstrap4',
            format:"dd mmmm yyyy",
        });

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
