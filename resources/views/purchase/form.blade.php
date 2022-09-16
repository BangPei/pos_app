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
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Form Pembelian <em id="edit-area"></em></h2>
      <div class="card-tools">
        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-eye"></i> List Produk
        </a>
      </div>
    </div>
    <div class="card-body table-responsive">
      <div class="row">
        <div class="col-md-4 col-sm-12">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <input type="text" id="barcode" name="barcode" autocomplete="off" autofocus placeholder="Scann Barcode" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">No Faktur</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6">
              <div class="form-group">
                <input type="text" placeholder="No Invoice / Faktur" id="invoice-no" class="font-weight-bold form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Supplier</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6">
              <div class="form-group">
                <select name="supplier" id="supplier" class="form-control select2">
                  <option disabled selected>-- pilih supplier--</option>
                  @foreach ($supplier as $s)
                      <option value="{{ $s->id }}">{{ $s->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">PIC / Supir</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6">
              <div class="form-group">
                <input type="text" placeholder="pic" id="pic" class="font-weight-bold form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Tipe Pembayaran</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6">
              <div class="form-group">
                <select name="payment-type" id="payment-type" class="form-control">
                  <option value="tempo">Tempo</option>
                  <option value="lunas">Lunas</option>
              </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Tgl Datang</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6">
              <div class="form-group">
                <input type="text" placeholder="Tgl Datang Barang" id="date-time" class="font-weight-bold form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Tgl Tempo</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6">
              <div class="form-group">
                <input type="text" placeholder="Tgl Jatuh Tempo" id="due-date" class="font-weight-bold form-control">
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-4 font-weight-bolder"><h4>Total</h4></div>
            <div class="col-2 font-weight-bolder"><h4>:</h4></div>
            <div class="col-2 font-weight-bolder"><h4>Rp.</h4></div>
            <div class="col-4 font-weight-bolder text-right"><h4 id="total">0</h4></div>
          </div>
        </div>
        <div class="col-md-8 col-sm-12">
          <table class="table table-striped table-bordered table-sm" id="table-order">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Harga (pcs)</th>
                <th>Pajak (pcs)</th>
                <th>Harga (dpp/pcs)</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
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
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  let dsCode = "<?=isset($directSales)?$directSales->code:null?>";
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
    $('a[data-widget="pushmenu"]').click()
    tblOrder = $('#table-order').DataTable({
      paging: false,
      searching: false,
      ordering:  false,
      bInfo:false,
      data:purchase.details,
    })

    keyupTableNumber($('#table-order'))

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
            className:"text-right",
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
            {
              width: '12%',
              targets: 0,
            },
            {
              width: '10%',
              targets: [2,3,4],
            },
          ],
      })
      $('div.dataTables_filter input', tblProduct.table().container()).focus();
    })

    
    $(window).bind('beforeunload', function(){
      if (purchase.details.length!=0) {
        return "Do you want to exit this page?";
      }
    });

    $('#modal-product').on('hidden.bs.modal', function (e) {
      $('#barcode').focus()
      $('#table-product').DataTable().destroy();
    })
 
    $('#barcode').on('keypress',function(e){
      if(e.keyCode == 13){
        let val = $(this).val();
        if (val !="") {
          ajax({"barcode":val}, `{{URL::to('/item-convertion/show')}}`, "GET",
              function(item) {
                if (Object.keys(item).length != 0) {
                  console.log(item)
                  // addProduct(item);
                  // $("#barcode").val("")
                }else{
                  $("#barcode").val(val.toLowerCase())
                }
          })
          
        }
      }
    })
    
    // dsCode!=""?getDirectSales():null;
  })
</script>
@endsection
