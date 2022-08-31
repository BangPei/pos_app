@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Form Penjualan <em id="edit-area"></em></h2>
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
          <div id="reduce-area" class="d-none">
            <div class="row">
              <div class="col-sm-4 font-weight-bold">Biaya Kartu (<span id="reduce-persentage">0</span>%)</div>
              <div class="col-sm-2 font-weight-bold">:</div>
              <div class="col-sm-6 font-weight-bold text-right" id="reduce">0</div>
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
              <div class="col-sm-4 font-weight-bold">Uang Tunai</div>
              <div class="col-sm-2 font-weight-bold">:</div>
              <div class="col-sm-6 text-right">
                <div class="row">
                  <div class="col-5">
                    <label for="is-cash">
                      <i style="font-size: 10px !important">Uang Pas</i>
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
              <div class="col-sm-4 font-weight-bold">Kembalian</div>
              <div class="col-sm-2 font-weight-bold">:</div>
              <div class="col-sm-2 font-weight-bold">Rp.</div>
              <div class="col-sm-4 font-weight-bold text-right" id="change">0</div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 font-weight-bold">Nama Pembeli</div>
            <div class="col-sm-2 font-weight-bold">:</div>
            <div class="col-sm-6 text-right">
              <input type="text" placeholder="Nama Pembeli" id="customer-name" class="font-weight-bold" style="width: 100%">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12 col-sam-12 col-xs-12 text-center">
              <a class="btn btn-danger" onclick="cancelTransaction()"><i class="fas fa-trash"></i> Batal</a>
              <a href="javascript:void(0)" onclick="saveTransaction()" class="btn btn-primary btn-save"><i class="fas fa-save"></i> Simpan</a>
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
  let directSales= {
    code:null,
    customer_name:null,
    amount:0,
    discount:0,
    additional_discount:0,
    cash:0,
    change:0,
    total_item:0,
    subtotal:0,
    reduce:0,
    details:[]
  };
  $(document).ready(function(){
    $('a[data-widget="pushmenu"]').click()
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


    $('#table-product').on('click','.add-product',function() {
      let product = tblProduct.row($(this).parents('tr')).data();
      addProduct(product);
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
        let val = $(this).val() ==""?"1":$(this).val()
        data.qty =parseInt(val.replace(/,/g, ""));
      
        getMultipleDiscount(data.product.barcode,data.product,
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
    $('#cash').on('keyup', function() {
        let value = $(this).val().replace(/,/g, "");
        directSales.cash = parseFloat(value===""?0:value);
        
        directSales.change = directSales.cash-directSales.amount;
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
          ajax({"barcode":val}, `{{URL::to('/item-convertion/show')}}`, "GET",
              function(item) {
                if (Object.keys(item).length != 0) {
                  addProduct(item);
                  $("#barcode").val("")
                }else{
                  $("#barcode").val(val.toLowerCase())
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

    dsCode!=""?getDirectSales():null;
  })

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
  function saveTransaction(){
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
    directSales.customer_name = $("#customer-name").val();
    directSales.payment_type_id = $('#payment-type').val();
    $('.btn-save').attr('disabled', 'disabled').removeClass('btn-primary').addClass('btn-default')
    ajax(directSales, "{{ route('transaction.store') }}", "POST",
        function(json) {
          toastr.success('Transaksi Berhasil Disimpan')
          cancelTransaction();
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
    let persentResult = (subAmount*(directSales.reduce/100));
    directSales.amount = subAmount+persentResult;
    $('#reduce').html(formatNumber(persentResult))
    $('#subtotal').html(formatNumber(directSales.subtotal))
    $('#discount-1').html(formatNumber(directSales.discount))
    $('#total-qty').html(formatNumber(directSales.total_item))
    $('#total').html(formatNumber(directSales.amount))
    $('#barcode').animate({left:0,duration:'slow'});
    $('#barcode').focus();
  }

  function addProduct(params) {
    getMultipleDiscount(params.barcode,params,
      function(json){
        if (directSales.details.some(item => item.product.id === params.id)) {
          directSales.details.forEach(data => {
            if (data.product_id == params.id) {
              data.qty = data.qty+1;
              data.subtotal = parseFloat(data.price)*parseInt(data.qty);
              data.program = 0;
              if (Object.keys(json).length != 0){
                let mod = 0;
                for (let i = 1; i <= data.qty; i++) {
                  if(i%json.program.min_qty==0){
                      mod = mod+1
                  }
                }
                data.program = mod*json.program.discount;
              }
            }
          });
        }else{
          let detail = {
            product:params,
            product_id:params.id,
            qty:1,
            price:parseFloat(params.price),
            discount:0,
            subtotal:parseFloat(params.price)*1,
            program:0,
          }
          if (Object.keys(json).length != 0){
            let mod = 0;
            for (let i = 1; i <= detail.qty; i++) {
              if(i%json.program.min_qty==0){
                  mod = mod+1
              }
            }
            detail.program = mod*json.program.discount;
          }
          directSales.details.push(detail);
        }
        reloadJsonDataTable(tblOrder,directSales.details);
        countTotality();
      }
    )
  }

  function getMultipleDiscount(barcode,product,callback) {
    ajax({"item_convertion_barcode":barcode}, `{{URL::to('multiple-discount-detail/show')}}`, "GET",
        function(json) {
            callback(json)
    })
  }

  function cancelTransaction() {
    $('#cash').val('');
    $('#is-cash').prop('checked',false);
    $('input[name="bank"]').prop('checked',false)
    $('#customer-name').val('')
    directSales.details = [];
    reloadJsonDataTable(tblOrder,directSales.details);
    countTotality();
  }
</script>
@endsection
