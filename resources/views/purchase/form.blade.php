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
  </div>
  {{-- Pilih sumber barang --}}
  <div class="row">
    <div class="col-md-12">
      <label for="">Pilih Sumber Barang : </label>
      <div class="custom-control custom-radio custom-control-inline">
        <input value="distributor" type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input">
        <label class="custom-control-label" for="customRadioInline1">Distributor</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input value="mandiri" type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
        <label class="custom-control-label" for="customRadioInline2">Mandiri</label>
      </div>
    </div>
  </div>
  {{-- form purchase --}}
  <div class="row">
    {{-- purchase informtion --}}
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="invoice-no">No. Faktur</label>
                <input type="text" class="form-control" name="invoice-no" id="invoice-no">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" class="form-control select2">
                  <option disabled selected>-- pilih supplier--</option>
                  @foreach ($supplier as $s)
                      <option value="{{ $s->id }}">{{ $s->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="pic">PIC / Salesman</label>
                <input type="text" class="form-control" name="pic" id="invoice-name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="payment-type">Tipe Pembayaran</label>
                <select name="payment-type" id="payment-type" class="form-control">
                  <option value="tempo">Tempo</option>
                  <option value="lunas">Lunas</option>
              </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="date-time">Tgl Datang Barang</label>
                <input type="text" class="form-control" name="date-time" id="date-time">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="due-date">Tgl Jatuh Tempo</label>
                <input type="text" class="form-control" name="due-date" id="due-date">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- purcase total --}}
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6"><label for="">Subtotal</label></div>
            <div class="col-md-1"><label for="">:</label></div>
            <div class="col-md-1"><label for="">Rp.</label></div>
            <div class="col-md-4 text-right"><label for="">120.000.000</label></div>
          </div>
          <div class="row">
            <div class="col-md-6"><label for="">Total Diskon</label></div>
            <div class="col-md-1"><label for="">:</label></div>
            <div class="col-md-1"><label for="">Rp.</label></div>
            <div class="col-md-4 text-right"><label for="">10.000.000</label></div>
          </div>
          <div class="row">
            <div class="col-md-6"><label for="">Diskon Extra</label></div>
            <div class="col-md-1"><label for="">:</label></div>
            <div class="col-md-1"><label for="">Rp.</label></div>
            <div class="col-md-4 text-right">
                <input type="text" placeholder="0" id="discount-2" class="text-right font-weight-bold number2" style="width: 100%">
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6"><label for="">Total</label></div>
            <div class="col-md-1"><label for="">:</label></div>
            <div class="col-md-1"><label for="">Rp.</label></div>
            <div class="col-md-4 text-right"><label for="">110.000.000</label></div>
          </div>
          <div class="row">
            <div class="col-md-6"><label for="">PPN (11%)</label></div>
            <div class="col-md-1"><label for="">:</label></div>
            <div class="col-md-1"><label for="">Rp.</label></div>
            <div class="col-md-4 text-right"><label for="">12.100.000</label></div>
          </div>
          <div class="row">
            <div class="col-md-6"><label for="">Total Faktur</label></div>
            <div class="col-md-1"><label for="">:</label></div>
            <div class="col-md-1"><label for="">Rp.</label></div>
            <div class="col-md-4 text-right"><label for="">122.100.000</label></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 text-right">
      <a class="btn btn-primary" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
        <i class="fas fa-eye"></i> List Produk
      </a>
    </div>
  </div>
  <br>
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
                  <th>Harga Jual</th>
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
      columns:[

      ],
    })

    // keyupTableNumber($('#table-order'))

    $('#modal-product').on('show.bs.modal', function (e) {
      tblProduct = $('#table-product').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
          url:"{{URL::to('product/dataTable')}}",
          type:"GET",
        },
        columns:[
          {
            data:"barcode",
            defaultContent:"--"
          },
          {
            data:"name",
            defaultContent:"--",
            
          },
          {
            data:"price",
            defaultContent:"--",
            className:"text-right",
            mRender:function(data,type,full){
              return `Rp. ${formatNumber(data)}`
            }
          },
          {
            data: 'id',
            className:"text-center",
            mRender: function(data, type, full) {
              return `<a title="add" class="btn btn-sm bg-gradient-primary add-product"><i class="fas fa-check"></i></a>`
            }
          }
        ],
        columnDefs:[
          { width: '10%',
            targets: 3
          },
          { width: '15%',
            targets: [0,2]
          },
        ],
      })
    })

    $('#table-product').on('click','.add-product',function() {
      let product = tblProduct.row($(this).parents('tr')).data();
      getStockBy(product.stock.id,function(data){
        console.log(data)
      });
      $("#modal-product").modal('hide');
    })

    $('#modal-product').on('hidden.bs.modal', function (e) {
      $('#table-product').DataTable().destroy();
    })
 
    // dsCode!=""?getDirectSales():null;
  })

  function getStockBy(id,callback) {
    let data = {id:id}
    ajax(data, `{{URL::to('/stock/show')}}`, "GET",
      function(data) {
        callback(data)
      },function(json){
       console.log(json)
      }
    )
  }
</script>
@endsection
