@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Form Penjualan</h2>
      <div class="card-tools">
        <a class="btn btn-primary" id="btn-product" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
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
            <div class="col-sm-4 font-weight-bold">Subtotal</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-2 font-weight-bold">Rp.</div>
            <div class="col-sm-4 font-weight-bold text-right" id="subtotal">0</div>
          </div>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Diskon 1</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-2 font-weight-bold">Rp.</div>
            <div class="col-sm-4 font-weight-bold text-right" id="discount-1">0</div>
          </div>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Diskon 2</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-6 text-right">
              <input type="text" placeholder="0" id="discount-2" class="text-right font-weight-bold number2" style="width: 100%">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Total Qty</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-6 font-weight-bold text-right" id="total-qty">0</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-4 font-weight-bolder"><h4>Total</h4></div>
            <div class="col-sm-2 font-weight-bolder"><h4>:</h4></div>
            <div class="col-sm-2 font-weight-bolder"><h4>Rp.</h4></div>
            <div class="col-sm-4 font-weight-bolder text-right"><h4 id="total">0</h4></div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Tipe Pembayaran</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-6 text-right">
              <select name="payment-type" id="payment-type" class="form-control">
                @foreach ($payment as $pt)
                @if (isset($defaultPayment))
                    @if ($pt->id === $defaultPayment->$payment_type_id)
                      <option selected value="{{$pt->id}}">{{$pt->name}}</option>
                    @else
                      <option value="{{$pt->id}}">{{$pt->name}}</option>
                      @endif
                  @else
                      <option value="{{$pt->id}}">{{$pt->name}}</option>
                @endif
                  
                @endforeach
            </select>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Uang Tunai</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-6 text-right">
              <input type="text" placeholder="0" id="cash" class="text-right font-weight-bold number2" style="width: 100%">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Kembalian</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-2 font-weight-bold">Rp.</div>
            <div class="col-sm-4 font-weight-bold text-right" id="change">0</div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Nama Pembeli</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-6 text-right">
              <input type="text" placeholder="nama Pembeli" id="customer-name" class="font-weight-bold" style="width: 100%">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12 col-sam-12 col-xs-12 text-center">
              <a class="btn btn-danger" id="btn-cancel"><i class="fas fa-trash"></i> Batal</a>
              <a href="javascript:void(0)" onclick="saveTransaction()" class="btn btn-primary" id="btn-save"><i class="fas fa-save"></i> Simpan</a>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-12">
          <table class="table table-striped table-bordered table-sm" id="table-order">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Diskon</th>
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
            <table class="table table-striped table-bordered" width="100%" id="table-product">
              <thead>
                <tr>
                  <th>Barcode</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Kategori</th>
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
  let directSales= {
    "_token": "{{ csrf_token() }}",
    code:null,
    customer_name:null,
    amount:0,
    discount:0,
    additional_discount:0,
    cash:0,
    change:0,
    total_item:0,
    subtotal:0,
    details:[]
  };
  $(document).ready(function(){
    tblOrder = $('#table-order').DataTable({
      paging: false,
      searching: false,
      ordering:  false,
      data:directSales.details,
      columns:[
        {
          data:"product.name",
          bSortable: false,
          defaultContent:"--"
        },
        {
          data:"product.uom.name",
          bSortable: false,
          defaultContent:"--"
        },
        {
          data:"qty",
          bSortable: false,
          defaultContent:"0",
          mRender:function(data,type,full){
            return `<input value="${data?formatNumber(data):0}" onkeypress="return IsNumeric(event);" class="number2 text-right qty-order" style="width:100%" placeholder="0" />`
            // return `Rp. ${formatNumber(data)}`
          }
        },
        {
          data:"price",
          bSortable: false,
          defaultContent:"0",
          mRender:function(data,type,full){
            return `Rp. ${formatNumber(data)}`
          }
        },
        {
          data:"subtotal",
          bSortable: false,
          defaultContent:"0",
          mRender:function(data,type,full){
            return `Rp. ${formatNumber(data)}`
          }
        },
        {
          data:"discount",
          bSortable: false,
          defaultContent:"0",
          mRender:function(data,type,full){
            return `<input value="${formatNumber(data)}" placeholder="0" onkeypress="return IsNumeric(event);" class="number2 text-right discount-order" style="width:100%" placeholder="0" />`
            // return `Rp. ${formatNumber(data)}`
          }
        },
        {
					data: null,
          bSortable: false,
					mRender: function(data, type, full) {
						return `<a href="#" title="Hapus" class="btn bg-gradient-danger delete-product"><i class="fas fa-trash"></i></a>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-right",
            targets: [2,3,4,5]
          },
        ],
    })

    keyupTableNumber($('#table-order'))

    $('#modal-product').on('show.bs.modal', function (e) {
      tblProduct = $('#table-product').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
          url:"{{ route('product.index') }}",
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
            data:"category.name",
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
              return `<a title="delete" class="btn bg-gradient-success add-product"><i class="fas fa-check"></i></a>`
            }
          }
        ],
        columnDefs: [
            { 
              className: "text-center",
              targets: [2,3,5]
            },
          ],
      })
      $('div.dataTables_filter input', tblProduct.table().container()).focus();
    })


    $('#table-product').on('click','.add-product',function() {
      let product = tblProduct.row($(this).parents('tr')).data();
      addProduct(product)
      reloadJsonDataTable(tblOrder,directSales.details)
      countTotality();
      $("#modal-product").modal('hide');
    })
    $('#modal-product').on('hidden.bs.modal', function (e) {
      $('#barcode').focus()
      $('#table-product').DataTable().destroy();
    })

    $('#table-order').on('click', '.delete-product', function() {
        let data = tblOrder.row($(this).parents('tr')).index();
        directSales.details.splice(data, 1);
        countTotality();
        reloadJsonDataTable(tblOrder, directSales.details);
    });
    $('#table-order').on('change', '.qty-order', function() {
        let data = tblOrder.row($(this).parents('tr')).data();
        data.qty =parseInt($(this).val().replace(/,/g, ""));
        countTotality();
        reloadJsonDataTable(tblOrder, directSales.details);
    });
    $('#discount-2').on('change', function() {
        let value = $(this).val().replace(/,/g, "");
        directSales.additional_discount = parseFloat(value===""?0:value);
        countTotality();
    });
    $('#cash').on('change', function() {
        let value = $(this).val().replace(/,/g, "");
        directSales.cash = parseFloat(value===""?0:value);
        
        directSales.change = directSales.cash-directSales.amount;
        $("#cash").html(formatNumber(directSales.cash))
        $("#change").html(formatNumber(directSales.change))
    });
    $('#table-order').on('change', '.discount-order', function() {
        let data = tblOrder.row($(this).parents('tr')).data();
        data.discount =parseFloat($(this).val().replace(/,/g, ""));
        countTotality();
        reloadJsonDataTable(tblOrder, directSales.details);
    });
 
    $('#barcode').on('keypress',function(e){
      if(e.keyCode == 13){
        let val = $(this).val();
        if (val !="") {
          $.ajax({
              url:`{{URL::to('product/show')}}`,
              type:"GET",
              data:{"barcode":val},
              dataType:"json",
              success:function (item) {
                if ( Object.keys(item).length != 0) {
                  addProduct(item)
                  reloadJsonDataTable(tblOrder,directSales.details)
                  countTotality();
                  $("#barcode").val("")
                }else{
                  $("#barcode").val(val.toLowerCase())
                }
              },
              error:function(params){
                console.log(params)
              }
          })
        }
      }
    })

    $(window).bind('beforeunload', function(){
      if (directSales.details.length!=0) {
        return "Do you want to exit this page?";
      }
    });
  })

  function saveTransaction(){
    if (directSales.details.length==0 || $('#cash').val()=="") {
      alert('Transaksi atau Uang Cash Tidak boleh kosong')
      return false;
    }
    directSales.customer_name = $("#customer-name").val();
    directSales.payment_type_id = $('#payment-type').val();
    $.ajax({
      data:directSales,
      url:"{{ route('transaction.store') }}",
      type:"POST",
      dataType:"json",
      success:function (params) {
        console.log(params);
      },
      error:function(params){
        console.log(params)
      }
    })
  }

  function countTotality() {
    let subtotal = 0;
    let qty = 0;
    let discount = 0;
    directSales.details.forEach(data=>{
      qty = qty+data.qty;
      data.subtotal = data.qty*data.price;
      subtotal =subtotal+ data.subtotal
      discount = discount+(data.discount*data.qty);
    })
    directSales.subtotal = subtotal;
    directSales.discount = discount;
    directSales.total_item = qty;
    
    directSales.amount = directSales.subtotal-(directSales.discount+(directSales.additional_discount))
    $('#subtotal').html(formatNumber(directSales.subtotal))
    $('#discount-1').html(formatNumber(directSales.discount))
    $('#total-qty').html(formatNumber(directSales.total_item))
    $('#total').html(formatNumber(directSales.amount))
    $('#barcode').animate({left:0,duration:'slow'});
    $('#barcode').focus();
  }

  function addProduct(params) {
    if (directSales.details.some(item => item.product.id === params.id)) {
        directSales.details.forEach(data => {
          if (data.product_id == params.id) {
            data.qty = data.qty+1;
            data.subtotal = parseFloat(data.price)*parseInt(data.qty)
          }
        });
      }else{
        let detail = {
            product:params,
            product_id:params.id,
            qty:1,
            price:parseFloat(params.price),
            discount:0,
            subtotal:parseFloat(params.price)*1
          }
          directSales.details.push(detail);
      }
  }
</script>
@endsection
