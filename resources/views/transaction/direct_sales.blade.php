@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Form Penjualan <em id="edit-area"></em></h2>
      <div class="card-tools d-inline">
        <div class="row text-right">
          <div class="col-6">
            <div class="form-group">
              <input type="text" autocomplete="off" class="form-control date-picker" id="trans-date" data-toggle="datetimepicker" data-target="#trans-date"/>
            </div>
          </div>
          <div class="col-6">
            <div class="btn-group" role="group" aria-label="Basic example">
              <a class="btn btn-primary" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-eye"></i> <small>Produk</small>
              </a>
              <a class="btn btn-warning text-white" data-toggle="modal" data-target="#modal-price" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-print"></i> <small>Harga Jual</small>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive">
      <div class="row">
        <div class="col-md-4 col-sm-12">
          <div class="row">
            <div class="col-12">
              <div class="input-group mb-3">
                <input type="text" id="barcode" name="barcode" autocomplete="off" placeholder="Scann Barcode" class="form-control">
                  <div class="input-group-append">
                      <button class="btn btn-primary" type="button" id="btn-multi-qty" data-toggle="modal" data-target="#modal-multi-qty" data-backdrop="static" data-keyboard="false">Multi Qty</button>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Subtotal</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-2 font-weight-bold">Rp.</div>
            <div class="col-4 font-weight-bold text-right" id="subtotal">0</div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Diskon 1</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-2 font-weight-bold">Rp.</div>
            <div class="col-4 font-weight-bold text-right" id="discount-1">0</div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Diskon 2</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6 text-right">
              <input type="text" placeholder="0" id="discount-2" class="text-right font-weight-bold number2" style="width: 100%">
            </div>
          </div>
          <div id="reduce-area" class="d-none">
            <div class="row">
              <div class="col-4 font-weight-bold">Biaya Kartu (<span id="reduce-persentage">0</span>%)</div>
              <div class="col-2 font-weight-bold">:</div>
              <div class="col-6 font-weight-bold text-right" id="reduce">0</div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Total Qty</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6 font-weight-bold text-right" id="total-qty">0</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-4 font-weight-bolder"><h4>Total</h4></div>
            <div class="col-2 font-weight-bolder"><h4>:</h4></div>
            <div class="col-2 font-weight-bolder"><h4>Rp.</h4></div>
            <div class="col-4 font-weight-bolder text-right"><h4 id="total">0</h4></div>
          </div>
          <hr>
          <div class="row">
            <div class="col-4 font-weight-bold">Tipe Pembayaran</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6 text-right">
              <select name="payment-type" id="payment-type" class="form-control select2 text" style="width: 100%">
                @foreach ($payment as $pt)
                  <option value="{{$pt->id}}" data-reduce="{{$pt->reduce->reduce??0 }}" show-cash="{{ $pt->show_cash }}"  data-atm="{{ $pt->show_atm }}" {{ $pt->is_default?'selected':""}} data-id="{{$pt->id}}">{{$pt->name}}</option>
                @endforeach
            </select>
            </div>
          </div>
          <div id="atm-area" class="d-none">
            @foreach ($bank as $b)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="bank" id="bank-{{ $b->id }}" value="{{ $b->id }}">
                <label class="form-check-label" for="bank-{{ $b->id }}">{{ $b->name }}</label>
              </div>
            @endforeach
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="bank" id="bank-other" value="other">
              <label class="form-check-label" for="bank-other">Lainnya</label>
            </div>
          </div>
          <div id="cash-area">
            <div class="row">
              <div class="col-4 font-weight-bold">Uang Tunai</div>
              <div class="col-2 font-weight-bold">:</div>
              <div class="col-6 text-right">
                <div class="row">
                  <div class="col-5">
                    <label for="is-cash">
                      <i style="font-size: 9px !important">Uang Pas</i>
                    </label>
                    <input type="checkbox" id="is-cash">
                  </div>
                  <div class="col-7">
                    <input type="text" placeholder="0" id="cash" class="text-right font-weight-bold number2" style="width: 100%">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 font-weight-bold">Kembalian</div>
              <div class="col-2 font-weight-bold">:</div>
              <div class="col-2 font-weight-bold">Rp.</div>
              <div class="col-4 font-weight-bold text-right" id="change">0</div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-4 font-weight-bold">Nama Pembeli</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6 text-right">
              <input type="text" placeholder="Nama Pembeli" id="customer-name" class="font-weight-bold" style="width: 100%">
            </div>
          </div>
          <div class="row">
            <div class="col-4 font-weight-bold">Print Struk</div>
            <div class="col-2 font-weight-bold">:</div>
            <div class="col-6 text-left">
              <input tabindex="-1" type="checkbox" id="is-printed">
            </div>
          </div>
          <hr>
          <div class="row width-screen">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <a class="btn btn-danger" onclick="cancelTransaction()"><i class="fas fa-trash"></i> Batal</a>
              <a href="javascript:void(0)" onclick="saveTransaction()" class="btn btn-primary btn-save"><i class="fas fa-save"></i> Simpan</a>
            </div>
          </div>
          @if (!isset($directSales))
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center pt-2">
              <a href="javascript:void(0)" tabindex="-1" onclick="saveTransaction('{{URL::to('transaction/dummy')}}')" class="btn btn-success btn-save"><i class="fas fa-print"></i> Print Struk</a>
            </div>
          </div>
          @endif
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
                <th>Program</th>
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
                  <th>Stock</th>
                  <th>Status</th>
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

<div class="modal fade" id="modal-price" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Form Harga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="input-group">
            <input onfocus="this.select();" type="text" id="modal-barcode" class="form-control barcode" placeholder="Masukan Kode Barang" >
            <div class="input-group-append">
              <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-8">
              <div class="form-group">
                <label for="">Produk</label>
                <input type="text" readonly class="form-control" id="product-name">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="">Harga</label>
                <input type="text" readonly class="form-control" id="product-price">
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-12 text-right">
            <button onclick="printPrice()" type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-multi-qty" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Form Qty</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="input-group">
            <input onfocus="this.select();" type="text" id="input-multi-barcode" class="form-control barcode" placeholder="Masukan Kode Barang" >
          </div>
          <hr>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="">Produk</label>
                <input tabindex="-1" type="text" readonly class="form-control" id="product-name-multi">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label for="">Harga</label>
                <input tabindex="-1" type="text" readonly class="form-control" id="product-price-multi">
              </div>
            </div>
            <div class="col-2">
              <div class="form-group">
                <label for="">Qty</label>
                <input id="product-qty-multi" onfocus="this.select();" placeholder="0" onkeypress="return IsNumeric(event);" class="number2 form-control text-right" placeholder="0" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-right">
              <button id="submit-multi-qty" type="button" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-error" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12 text-center">
            <i class="fa fa-times text-danger fa-5x"></i>
            <p><h2>Oppss !</h2></p>
            <p id="label-error"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
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
<script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/plugins/onscan/onscan.js"></script>
<script src="/plugins/jquery.hotkeys/jquery.hotkeys.js"></script>
<script>
  let dsCode = "<?=isset($directSales)?$directSales->code:null?>";
  let tempProduct=null;
  let directSales= {
    code:null,
    date:moment(new Date()).format("YYYY-MM-DD HH:mm:ss"),
    customer_name:null,
    amount:0,
    discount:0,
    additional_discount:0,
    cash:0,
    change:0,
    total_item:0,
    subtotal:0,
    reduce:0,
    reduce_value:0,
    is_cash:0,
    details:[]
  };

  $(document).ready(function(){

    initScanJs()
    shortcutKey()
    // $('#barcode').on('focus',function(){
    //   onScan.simulate(document, [48,49,50]);
    // })
    $('#is-printed').prop('checked',true)
    $('a[data-widget="pushmenu"]').click()
    tblOrder = $('#table-order').DataTable({
      paging: false,
      searching: false,
      ordering:  false,
      data:directSales.details,
      columns:[
        {
          data:"product",
          bSortable: false,
          defaultContent:"--",
          mRender:function(data,type,full){
            if (data.program) {
              if (data.program.is_active) {
                let discount = data.program.multiple_discount;
                return `${data.name}</br> <small class="badge badge-info">Beli ${discount.min_qty} Diskon Rp.${formatNumber(discount.discount)}</small>`
              }else{
                return data.name
              }
            }else{
              return data.name
            }
          }
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
            return `<input value="${data?formatNumber(data):0}" onfocus="this.select();" onkeypress="return IsNumeric(event);" class="number2 text-right qty-order" style="width:100%" placeholder="0" />`
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
            return `<input onfocus="this.select();" value="${formatNumber(data)}" placeholder="0" onkeypress="return IsNumeric(event);" class="number2 text-right discount-order" style="width:100%" placeholder="0" />`
            // return `Rp. ${formatNumber(data)}`
          }
        },
        {
          data:"program",
          bSortable: false,
          defaultContent:"0",
          mRender:function(data,type,full){
            return `Rp. ${formatNumber(data)}`
            // return `Rp. ${formatNumber(data)}`
          }
        },
        {
					data: null,
          bSortable: false,
					mRender: function(data, type, full) {
						return `<a title="Hapus" class="btn bg-gradient-danger delete-product"><i class="fas fa-trash"></i></a>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-right",
            targets: [1,2,3,4,5,6]
          },
          { width: '8%',
            targets: [1,2,5,6]
          },
          { width: '20%',
            targets: 0
          },
          { width: '5%',
            targets: 7
          },
          { width: '10%',
            targets: [3,4]
          },
        ],
    })

    keyupTableNumber($('#table-order'))
    $('#trans-date').val(moment(new Date()).format("DD MMMM YYYY"))

    $('#modal-product').on('shown.bs.modal', function (e) {
      onScan.detachFrom(document);
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
            data:"uom.name",
            defaultContent:"--",
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
            data:"convertion",
            defaultContent:"0",
            mRender:function(data,type,full){
              if (full.stock) {
                return formatNumber(Math.floor(full.stock.value/data))
              }else{
                return `Stock Belum Di Atur`
              }
            }
          },
          {
            data:"is_active",
            defaultContent:"--",
            className:"text-center",
            mRender:function(data,type,full){
              return `<small class="badge badge-${data==1?'info':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</small>`
            }
          },
          {
            data: 'id',
            mRender: function(data, type, full) {
              return `<a title="check" class="btn btn-sm bg-gradient-primary add-product"><i class="fas fa-check"></i></a>`
            }
          }
        ],
        columnDefs: [
            { 
              className: "text-center",
              targets: [2,4,5,6]
            },
            {
              width: '12%',
              targets: 0,
            },
            {
              width: '10%',
              targets: [2,3,4,5,6],
            },
          ],
      })
      $('div.dataTables_filter input', tblProduct.table().container()).focus();
    })

    $('#table-product').on('click','.add-product',function() {
      let product = tblProduct.row($(this).parents('tr')).data();
      if (product.is_active == 0) {
        $("#modal-product").modal('hide');
        $('#label-error').html(`Product dengan code ${product.barcode} tidak aktif`);
        $('#modal-error').modal({backdrop: 'static', keyboard: false});
        return false;
      }
      addProduct(product);
      $("#modal-product").modal('hide');
    })

    $('#modal-multi-qty,#modal-price').on('shown.bs.modal',function(){
      onScan.detachFrom(document);
      $('.barcode').trigger('focus')
    })

    $('#modal-product').on('hidden.bs.modal', function (e) {
      $('#table-product').DataTable().destroy();
      $('#barcode').trigger('focus')
      initScanJs()
    })
    $('#modal-price,#modal-error,#modal-multi-qty').on('hidden.bs.modal', function (e) {
      initScanJs()
    })
    $('#modal-error').on('shown.bs.modal', function (e) {
      onScan.detachFrom(document);
    })

    $('#table-order').on('click', '.delete-product', function() {
        let data = tblOrder.row($(this).parents('tr')).index();
        let detail = tblOrder.row($(this).parents('tr')).data();
        let paramStock = {
          stock_id :detail.product.stock.id,
          product_id :detail.product.id,
          qty:detail.qty,
          convertion:detail.convertion,
          param:"remove",
        }
        deleteStock(paramStock,function(json){
          directSales.details.splice(data, 1);
          countTotality();
          reloadJsonDataTable(tblOrder, directSales.details);
        })
    });
    $('#table-order').on('change', '.qty-order', function() {
        let data = tblOrder.row($(this).parents('tr')).data();
        let oldValue = data.qty;
        let val = ($(this).val() ==""||$(this).val()=="0")?"1":$(this).val()
        let newValue = parseInt(val.replace(/,/g, ""));

        let paramStock = {
          stock_id :data.product.stock.id,
          product_id :data.product.id,
          qty:newValue,
          convertion:data.convertion,
          param:null,
        }
        updateStock(paramStock,function(json){
          data.qty =newValue;
          getMultipleDiscount(data.product.id,data.product,
            function(json){
              if (Object.keys(json).length != 0){
                let mod = 0;
                for (let i = 1; i <= data.qty; i++) {
                  if(i%json.program.min_qty==0){
                      mod = mod+1
                  }
                }
                data.program = mod*json.program.discount;
              }
              countTotality();
              reloadJsonDataTable(tblOrder, directSales.details);
            }
          )
        },function(json){
          $('#label-error').html(`${json.message} untuk ${data.product.name}`);
          $('#modal-error').modal({backdrop: 'static', keyboard: false});
          $('#table-order .qty-order').val(oldValue)
          countTotality();
          reloadJsonDataTable(tblOrder, directSales.details);
        })
    });
    $('#discount-2').on('change', function() {
        let value = $(this).val().replace(/,/g, "");
        directSales.additional_discount = parseFloat(value===""?0:value);
        countTotality();
        $('#is-cash').prop('checked',false)
        directSales.cash = 0;
        directSales.change = 0;
        $("#cash").val(formatNumber(directSales.cash))
        $("#change").html(formatNumber(directSales.change))
    });
    $('#cash,#customer-name,#discount-2,#trans-date').focus(function() {
      onScan.detachFrom(document);
    })
    $('#cash,#customer-name,#discount-2,#trans-date').focusout(function() {
      initScanJs();
    })
    $('#cash').on('keyup', function() {
        let value = $(this).val().replace(/,/g, "");
        directSales.cash = parseFloat(value===""?0:value);
        directSales.change = directSales.cash-directSales.amount;
        
        $("#is-cash").prop('checked',directSales.cash!=directSales.amount?false:true)
        $("#cash").val(formatNumber(directSales.cash))
        $("#change").html(formatNumber(directSales.change))
    });
    $('#table-order').on('change', '.discount-order', function() {
        let data = tblOrder.row($(this).parents('tr')).data();
        let val = $(this).val() ==""?"0":$(this).val()
        data.discount =parseFloat(val.replace(/,/g, ""));
        countTotality();
        reloadJsonDataTable(tblOrder, directSales.details);
        $('#is-cash').prop('checked',false)
        directSales.cash = 0;
        directSales.change = 0;
        $("#cash").val(formatNumber(directSales.cash))
        $("#change").html(formatNumber(directSales.change))
    });

    $('#is-cash').on('change',function () {
      val = $(this).prop('checked')
      directSales.is_cash = val?1:0;
      if (val) {
        directSales.cash = directSales.amount;
        directSales.change = directSales.cash-directSales.amount;
      }else{
        directSales.cash = 0;
        directSales.change = 0;
      }
      $("#cash").val(formatNumber(directSales.cash))
      $("#change").html(formatNumber(directSales.change))
    })

    $('#barcode').on('keypress',function(e){
      if(e.keyCode == 13){
        let val = $(this).val();
        if (val !="") {
          getProductByBarcode(val,function(item){
            addProduct(item);
            $("#barcode").val("")
          })
        }
      }
    })
    $('#modal-barcode').on('keypress',function(e){
      if(e.keyCode == 13){
        let val = $(this).val();
        if (val !="") {
          getProductByBarcode(val,function(item){
            $('#product-name').val(item.name)
            $('#product-price').val(formatNumber(item.price))
          })
        }
      }
    })
    $('#input-multi-barcode').on('keypress',function(e){
      if(e.keyCode == 13){
        let val = $(this).val();
        if (val !="") {
          getProductByBarcode(val,function(item){
            $('#product-name-multi').val(item.name)
            $('#product-price-multi').val(formatNumber(item.price))
            $('#product-qty-multi').val("1").trigger('focus')
            tempProduct= item;
          })
        }
      }
    })

    $(window).bind('beforeunload', function(){
      if (directSales.details.length!=0) {
        return "Do you want to exit this page?";
      }
    });

    $('#payment-type').on('change',function(){
      let showAtm = $(this).find(':selected').attr('data-atm');
      let showCash = $(this).find(':selected').attr('show-cash');
      let dataReduce = $(this).find(':selected').attr('data-reduce');
      directSales.bank_id = null;
      directSales.is_cash = 0;
      $('input[name="bank"]').prop('checked',false)
      $('#is-cash').prop('checked',false)
      if (showAtm!="") {
        $('#atm-area').removeClass('d-none')
        $('#cash-area').addClass('d-none')
        $('#reduce-area').addClass('d-none')
        directSales.cash = 0;
        directSales.change = 0;
        directSales.reduce=0;
        $("#cash").val(formatNumber(directSales.cash))
        $("#change").html(formatNumber(directSales.change))
        $('#reduce-persentage').html("0")
      }else if(showCash!=""){
        directSales.reduce=0;
        $('#reduce-area').addClass('d-none')
        $('#atm-area').addClass('d-none')
        $('#cash-area').removeClass('d-none')
        $('#reduce-persentage').html("0")
      }else{
        $('#atm-area').addClass('d-none')
        $('#cash-area').addClass('d-none')
        $('#reduce-area').addClass('d-none')
        directSales.cash = 0;
        directSales.change = 0;
        directSales.reduce=0;
        $('#reduce-persentage').html("0")
        $("#cash").val(formatNumber(directSales.cash))
        $("#change").html(formatNumber(directSales.change))
        if (dataReduce!="") {
          $('#reduce-area').removeClass('d-none')
          directSales.reduce=parseInt(dataReduce);
          $('#reduce-persentage').html(dataReduce)
        }
      }
      countTotality()
    })

    $('input[name="bank"]').on('change',function(){
      let val = $(this).val();
      let dataReduce = $('#payment-type').find(':selected').attr('data-reduce');
      if (val == "other") {
        directSales.bank_id=null;
        directSales.reduce=parseInt(dataReduce);
        $('#reduce-persentage').html(dataReduce)
        $('#reduce-area').removeClass('d-none')
      }else{
        directSales.reduce=0;
        directSales.bank_id=val;
        $('#reduce-area').addClass('d-none')
        $('#reduce-persentage').html("0")
      }
      countTotality()
    })

    $('#submit-multi-qty').on('click',function(){
      if (tempProduct!=null) {
        let qty = $('#product-qty-multi').val().replace(/,/g, "");
        addProduct(tempProduct,parseInt(qty));
      }
    })

    dsCode!=""?getDirectSales():null;
  })

  function initScanJs() {
    onScan.attachTo(document, {
        suffixKeyCodes: [13],
        reactToPaste: true,
        onScan: function(sCode, iQty) {
          getProductByBarcode(sCode,function(item){
            addProduct(item);
          })
        },
    });
  }

  function printPrice() {
    let data = {
      name:$('#product-name').val(),
      price:$('#product-price').val(),
    }
    ajax(data, `{{URL::to('/transaction/price')}}`, "POST",
          function(item) {
      },
    )
  }
  function getProductByBarcode(barcode,callback) {
    ajax(null, `{{URL::to('/product/barcode/${barcode}')}}`, "GET",
      function(item) {
        callback(item)
      },function(json){
        $('#label-error').html(json.responseJSON.message);
        $('#modal-error').modal({backdrop: 'static', keyboard: false});
      }
    )
  }

  function getPayments() {
    ajax(null, `{{URL::to('payment/get')}}`, "GET",
          function(json) {
            json.forEach(e => {
              $('#payment-type').append(`
                <option value="${e.id}" data-reduce="${e.reduce?.reduce??0}" show-cash= ${e.show_cash}  data-atm=${e.show_atm} ${e.is_default?"selected":""} data-id="${e.id}">${e.name}</option>
              `)
            });
      })
  }

  function getDirectSales(){
      let data = {
          code:dsCode,
      }
      ajax(data, `{{URL::to('transaction/show')}}`, "GET",
          function(json) {
            directSales = Object.assign({}, json);
            reloadJsonDataTable(tblOrder,json.details);
            $('#payment-type').val(json.payment_type.id).trigger('change')
            $('#reduce-persentage').html(formatNumber(json.reduce))
            $('#cash').val(formatNumber(json.cash))
            $("#change").html(formatNumber(json.change))
            $('#subtotal').html(formatNumber(json.subtotal))
            $('#discount-1').html(formatNumber(json.discount))
            $('#total-qty').html(formatNumber(json.total_item))
            $('#total').html(formatNumber(json.amount))
            $('#trans-date').val(moment(json.date).format("DD MMMM YYYY"))
            $("#customer-name").val(json.customer_name??"")
            $('#edit-area').append(`<u>
              - ${json.code} / ${json.created_by.name} / 
              ${moment(json.created_at).format('DD MMMM YYYY HH:mm')}</u>
            `).addClass('text-primary')
            $('#is-cash').prop('checked',json.is_cash);
            if (json.bank) {
              $(`#bank-${json.bank.id}`).prop('checked',true)
            }else{
              $(`#bank-other`).prop('checked',true).trigger('change')
            }
      })
  }
  function saveTransaction(url=null){
    let dataAtm = $("#payment-type").find(':selected').attr('data-atm');
    let dataCash = $("#payment-type").find(':selected').attr('show-cash');
    let dataBank = $('input[name="bank"]:checked').val();
    if (directSales.details.length==0) {
      alert('Transaksi Tidak boleh kosong')
      return false;
    }
    if (dataAtm!="" && dataBank==undefined) {
      alert('Silahkan Pilih ATM')
      return false;
    }
    if (dataCash!="" && $('#cash').val()=="") {
      alert('Uang Tunai Tidak Boleh Kosong')
      return false;
    }
    let now = new Date();
    let val = `${$('#trans-date').val()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
    directSales.date = moment(val,"DD MMMM YYYY HH:mm:ss").format(`YYYY-MM-DD HH:mm:ss`)
    directSales.customer_name = $("#customer-name").val();
    directSales.payment_type_id = $('#payment-type').val();
    directSales.isPrinted = $('#is-printed').prop('checked')==true?1:0;
    $('.btn-save').attr('disabled', 'disabled').removeClass('btn-primary').addClass('btn-default')
    let method = dsCode==""?"POST":"PUT";
    if (url==null) {
      url = dsCode==""?"{{ route('transaction.store') }}":"{{URL::to('transaction/update')}}"
    }
    ajax(directSales, url, method,
        function(json) {
          toastr.success('Transaksi Berhasil Disimpan')
          dsCode==""?clearTransaction():null;
          $('.btn-save').removeAttr('disabled').addClass('btn-primary').removeClass('btn-default')
    },function(json){
      $('.btn-save').removeAttr('disabled').addClass('btn-primary').removeClass('btn-default')
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
      discount = discount+(data.discount*data.qty)+data.program;
    })
    directSales.subtotal = subtotal;
    directSales.discount = discount;
    directSales.total_item = qty;
    let subAmount = directSales.subtotal-(directSales.discount+(directSales.additional_discount))
    directSales.reduce_value = (subAmount*(directSales.reduce/100));
    directSales.amount = subAmount+directSales.reduce_value;
    $('#reduce').html(formatNumber(directSales.reduce_value))
    $('#subtotal').html(formatNumber(directSales.subtotal))
    $('#discount-1').html(formatNumber(directSales.discount))
    $('#total-qty').html(formatNumber(directSales.total_item))
    $('#total').html(formatNumber(directSales.amount))
    $('#barcode').animate({left:0,duration:'slow'});
    $('#barcode').focus();
  }
  function addProduct(params,manualQty=1) {
    let data = {
      stock_id:params.stock.id,
      product_id:params.id,
      qty:manualQty,
      convertion:params.convertion,
      param:"min",
    }
    postStock(data,function(json){
      let isExist = directSales.details.some(item => item.product.id === params.id);
      if (isExist) {
        directSales.details.forEach(data => {
          if (data.product_id == params.id) {
            data.qty = data.qty+manualQty;
            data.subtotal = parseFloat(data.price)*parseInt(data.qty);
            data.program = 0;
            if ((params.program!= null) && (params.program.is_active)){
              let mod = 0;
              for (let i = 1; i <= data.qty; i++) {
                let minQty = params.program.multiple_discount.min_qty;
                if((i%minQty)==0){
                    mod = mod+1
                }
              }
              data.program = mod*params.program.multiple_discount.discount;
            }
          }
        });
      } else {
        let detail = {
          product:params,
          product_name:params.name,
          product_id:params.id,
          convertion:params.convertion,
          uom:params.uom?.name??"--",
          category:params.category?.name??"--",
          qty:manualQty,
          price:parseFloat(params.price),
          discount:0,
          subtotal:parseFloat(params.price)*1,
          program:0,
        }
        if (params.program != null){
          let mod = 0;
          for (let i = 1; i <= detail.qty; i++) {
            if(i%params.program.multiple_discount.min_qty==0){
                mod = mod+1
            }
          }
          detail.program = mod*params.program.multiple_discount.discount;
        }
        directSales.details.push(detail);
      }
      reloadJsonDataTable(tblOrder,directSales.details);
      countTotality();
      $('#barcode').val("");
      $('#modal-multi-qty').modal('hide');
    },function(json){
      $('#modal-multi-qty').modal('hide')
      $('#label-error').html(`${json.message} untuk ${params.name}`);
      $('#modal-error').modal({backdrop: 'static', keyboard: false});
    });
  }

  function postStock(data,callback,error = null) {
    ajax(data, `{{URL::to('temp-stock/post-stock')}}`, "POST",
        function(json) {
            callback(json)
    },function(res){
      json = res.responseJSON;
      error?error(json):null;
    })
  }

  function updateStock(data,callback,error = null) {
    ajax(data, `{{URL::to('temp-stock/update-stock')}}`, "PUT",
        function(json) {
            callback(json)
    },function(res){
      json = res.responseJSON;
      error?error(json):null;
    })
  }

  function deleteStock(data,callback,error = null) {
    ajax(data, `{{URL::to('temp-stock/delete-stock')}}`, "DELETE",
        function(json) {
            callback(json)
    },function(res){
      json = res.responseJSON;
      error?error(json):null;
    })
  }

  function getMultipleDiscount(barcode,product,callback) {
    ajax({"product":barcode}, `{{URL::to('multiple-discount-detail/show')}}`, "GET",
        function(json) {
          callback(json)
    })
  }
  
  function cancelTransaction(){
    
    ajax(null, `{{URL::to('temp-stock/delete-transaction')}}`, "DELETE",
        function(json) {
          clearTransaction();
    })
  }

  function clearTransaction() {
    $('#cash').val('');
    $('#is-cash').prop('checked',false);
    $('#is-printed').prop('checked',true);
    $('input[name="bank"]').prop('checked',false)
    $('#customer-name').val('')
    $('#discount-2').val('')
    $('#total').html('0')
    $('#change').html('0')
    directSales.additional_discount = 0;
    let payId;
    $("#payment-type > option").each(function() {
      if ($(this).attr('selected')) {
        payId = $(this).val();
      }
    });
    $("#payment-type").val(payId).trigger('change');
    $('#trans-date').val(moment(new Date()).format("DD MMMM YYYY"))
    directSales.details = [];
    reloadJsonDataTable(tblOrder,directSales.details);
    countTotality();
  }

  function currentTime(selectDate = new Date()) {
    let date = selectDate; 
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();

    hh = (hh < 10) ? "0" + hh : hh;
    mm = (mm < 10) ? "0" + mm : mm;
    ss = (ss < 10) ? "0" + ss : ss;
      
    let time = hh + ":" + mm + ":" + ss + " ";

    $('#trans-date').val(`${moment(date).format("DD MMM YYYY")} ${time}`); 
    let t = setTimeout(function(){ currentTime() }, 1000);
  }

  function shortcutKey() {
    if ($('#barcode').is(':focus')) {
      $('#barcode').focusout();
      $(document).bind('keydown', 'alt+a', function(){
      if ($("#payment-type").find(':selected').attr('show-cash')=="1") {
        $('#cash').focus();
      }
    })
    $(document).bind('keydown', 'alt+w', function(){
      let value = $('#is-cash').prop('checked');
      if ($("#payment-type").find(':selected').attr('show-cash')=="1") {
        $('#is-cash').prop('checked',!value).trigger('change');
      }
    })
    }
  }
</script>
@endsection
