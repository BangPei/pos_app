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
        <input value="true" type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input">
        <label class="custom-control-label" for="customRadioInline1">Distributor</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input value="false" type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
        <label class="custom-control-label" for="customRadioInline2">Non distributor / Trader</label>
      </div>
    </div>
  </div>
  {{-- form purchase --}}
  <div class="d-none" id="body-purchase">
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
              <div class="col-md-4 supplier">
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
                  <label for="pic">PIC</label>
                  <input type="text" class="form-control" name="pic" id="pic">
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
                  <input readonly type="text" class="form-control date-picker" id="date-time" data-toggle="datetimepicker" data-target="#date-time" name="date-time">
                </div>
              </div>
              <div class="col-md-4 due-date">
                <div class="form-group">
                  <label for="due-date">Tgl Jatuh Tempo</label>
                  <input readonly type="text" class="form-control date-picker" id="due-date" name="due-date" data-toggle="datetimepicker" data-target="#due-date">
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
              <div class="col-5">
                <label for="is-ppn">
                  <i style="font-size: 12px !important">Harga sudah termasuk PPN</i>
                </label>
                <input type="checkbox" id="is-ppn" name="is-ppn">
              </div>
            </div>
            <div class="row dpp d-none">
              <div class="col-md-6"><label for="">Dpp</label></div>
              <div class="col-md-1"><label for="">:</label></div>
              <div class="col-md-1"><label for="">Rp.</label></div>
              <div class="col-md-4 text-right"><label for="" id="po-dpp">0</label></div>
            </div>
            <div class="non-dpp d-none">
              <div class="row">
                <div class="col-md-6"><label for="">Subtotal</label></div>
                <div class="col-md-1"><label for="">:</label></div>
                <div class="col-md-1"><label for="">Rp.</label></div>
                <div class="col-md-4 text-right"><label for="" id="po-subtotal">0</label></div>
              </div>
              <div class="row">
                <div class="col-md-6"><label for="">Diskon Extra</label></div>
                <div class="col-md-1"><label for="">:</label></div>
                <div class="col-md-1"><label for="">Rp.</label></div>
                <div class="col-md-4 text-right">
                    <input type="text" placeholder="0" id="po-discount-extra" class="text-right font-weight-bold number2" style="width: 100%">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6"><label for="">Total</label></div>
                <div class="col-md-1"><label for="">:</label></div>
                <div class="col-md-1"><label for="">Rp.</label></div>
                <div class="col-md-4 text-right"><label for="" id="po-amount">0</label></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6"><label for="">PPN (<span id="po-tax">0</span> %)</label> <a data-toggle="modal" data-target="#modal-ppn" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit text-primary"></i></a></div>
              <div class="col-md-1"><label for="">:</label></div>
              <div class="col-md-1"><label for="">Rp.</label></div>
              <div class="col-md-4 text-right"><label for="" id="po-tax-paid">0</label></div>
            </div>
            <div class="row">
              <div class="col-md-6"><label for="">Total Faktur</label></div>
              <div class="col-md-1"><label for="">:</label></div>
              <div class="col-md-1"><label for="">Rp.</label></div>
              <div class="col-md-4 text-right"><label for="" id="po-total-amount">0</label></div>
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
    <div class="card-detail">
  {{-- body detai; --}}
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <div class="card">
          <div class="card-body">
            <label for="" id="label-no-data" class="d-none"> Tidak Ada Data </label>
            <button onclick="onSubmit()" id="btn-save" class="btn btn-primary d-none" type="button"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-ppn" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">PPN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="ppn-text">Masukan Nilai PPN (%)</label>
              <input autocomplete="off" type="text" class="form-control number2 text-right" id="ppn-text" name="ppn-text">
            </div>
          </div>
          <div class="col-md-12 text-center">
            <button onclick="setPPN()" class="btn btn-primary" type="button">Submit</button>
          </div>
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
        supplier:null,
        pic:null,
        payment_type:null,
        date:null,
        due_date:null,
        subtotal:0,
        dpp:0,
        discount_extra:0,
        tax_in_price:false,
        tax:0,
        tax_paid:0,
        amount:0,
        is_distributor:null,
        total_amount:0,
        details:[]
  }
  $(document).ready(function(){
    $('a[data-widget="pushmenu"]').click()
    $('#date-time').val(moment(new Date()).format("DD MMMM YYYY"))
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
        let detail = {
          stock:data,
          qty:1,
          price_per_pcs:0,
          subtotal:0,
          convertion:product.convertion,
          uom:product.uom,
          product_barcode:product.barcode,
          detail_modals:[],
        }
        data.products.forEach(e => {
          let detail_modal = {
            product:e,
            modal:0,
            dpp:0,
            tax_paid:0,
            current_price:e.price,
            new_price:e.price,
            periode:$('#date').val()
          }
          detail.detail_modals.push(detail_modal)
        });
        detail.price_per_pcs = detail.subtotal/(detail.qty*detail.convertion)
        purchase.details.push(detail)
        calculate();
      });
      $("#modal-product").modal('hide');
    })

    $('#modal-product').on('hidden.bs.modal', function (e) {
      $('#table-product').DataTable().destroy();
    })
    

    $('.card-detail').on('click','table .btn-detele',function(){
      let id = $(this).attr('data-id');
      let filter =  purchase.details.filter(e=>e.stock.id !=id);
      purchase.details = filter;
      calculate();
    })
    $('.card-detail').on('change','select',function(){
      let id =parseInt($(this).find('option:selected').attr("data-id"));
      let convertion =parseInt($(this).val());
      purchase.details.forEach(e=>{
        if (e.stock.id == id) {
          e.convertion = convertion;
          e.product_barcode = e.stock.products.filter(p=>p.convertion==convertion)[0].barcode;
          e.uom = e.stock.products.filter(p=>p.convertion==convertion)[0].uom??null;
        }
      })
      calculate()
    })
    $('.card-detail').on('change','.qty-order',function(){
      let id =parseInt($(this).attr("data-id"));
      let val  = $(this).val();
      val = (val== null||val =="")?0:parseInt(val);
      
      purchase.details.forEach(e=>{
        if (e.stock.id == id) {
          e.qty = val;
        }
      })
      calculate()
    })
    $('.card-detail').on('change','.subtotal-order',function(){
      let id =parseInt($(this).attr("data-id"));
      let val  = $(this).val();
      val = (val== null||val =="")?0:parseInt(val);
      
      purchase.details.forEach(e=>{
        if (e.stock.id == id) {
          e.subtotal = val;
        }
      })
      calculate();
    })
    $('.card-detail').on('change','.new-price',function(){
      let stockId =parseInt($(this).attr("data-stock"));
      let barcode =$(this).attr("data-barcode");
      let val  = $(this).val();
      val = (val== null||val =="")?0:parseInt(val);
      
      purchase.details.forEach(e=>{
        if (e.stock.id == stockId) {
          e.detail_modals.forEach(m=>{
            if (m.product.barcode == barcode) {
              m.new_price = val
            }
          })
        }
      })
      calculate();
    })

    $('#po-discount-extra').on('change',function(){
      let val = $(this).val().replace(/,/g, "");
      purchase.discount_extra = (val==""||val==null)?0:parseInt(val);
      calculate();
    })

    $('#is-ppn').on('click',function () {
      purchase.tax_in_price = $(this).prop('checked');
      calculate();
    })

    $('input[name="customRadioInline"]').on('click',function(){
      if (purchase.is_distributor==null || purchase.tax == 0) {
        $('#modal-ppn').modal()
      }
      purchase.is_distributor = $(this).val()==='true'
      if (purchase.is_distributor) {
        $('.supplier').removeClass('d-none')
      }else{
        $('.supplier').addClass('d-none')
      }
    })

    $('#payment-type').on('change',function(){
      let val = $(this).val();
      if (val === 'lunas') {
        $('.due-date').addClass('d-none')
      }else{
        $('.due-date').removeClass('d-none')
      }
    })
  })


  function setPPN(){
    if ($('#ppn-text').val()=="" || $('#ppn-text').val()==null) {
      purchase.tax = 0
    }else{
      purchase.tax = parseInt($('#ppn-text').val())
    }
    $('#modal-ppn').modal('hide');
    calculate();
  }

  function calculate(){
    $('#body-purchase').removeClass('d-none')
    let subtotal = 0;
    purchase.details.forEach(e=>{
      subtotal = subtotal+e.subtotal;
      e.price_per_pcs = e.subtotal/(e.qty*e.convertion)
      e.detail_modals.forEach(m=>{
        let modal = m.product.convertion*e.price_per_pcs
        if(purchase.tax_in_price){
          m.dpp = modal*(100/(100+purchase.tax));
          m.tax_paid = modal- m.dpp;
          m.modal = modal;
        }else{
          m.dpp = modal;
          m.modal = modal+(modal*(purchase.tax/100));
          m.tax_paid = m.modal-m.dpp;
        }
        m.margin_before_tax = m.new_price-m.dpp;
        m.margin_after_tax = m.new_price-m.modal;
      })
    })
    if (purchase.tax_in_price) {
      purchase.total_amount = subtotal;
      purchase.dpp = purchase.total_amount*(100/(100+purchase.tax));
      purchase.subtotal = purchase.dpp;
      purchase.amount = purchase.subtotal-purchase.discount_extra;
      purchase.tax_paid = purchase.total_amount-purchase.dpp;
      $('.dpp').removeClass('d-none')
      $('.non-dpp').addClass('d-none')
    }else{
      purchase.subtotal = subtotal;
      purchase.amount = purchase.subtotal-purchase.discount_extra;
      purchase.dpp = purchase.amount;
      purchase.tax_paid = purchase.amount*(purchase.tax/100)
      purchase.total_amount = purchase.amount+purchase.tax_paid;
      $('.dpp').addClass('d-none')
      $('.non-dpp').removeClass('d-none')
    }


    $('#po-dpp').text(formatNumber(purchase.dpp));
    $('#po-amount').text(formatNumber(purchase.amount));
    $('#po-total-amount').text(formatNumber(purchase.total_amount));
    $('#po-subtotal').text(formatNumber(purchase.subtotal));
    $('#po-tax').text(purchase.tax)
    $('#po-tax-paid').text(formatNumber(purchase.tax_paid));

    if (purchase.details.length !=0) {
      $('#label-no-data').addClass('d-none')
      $('#btn-save').removeClass('d-none')
    }else{
      $('#label-no-data').removeClass('d-none')
      $('#btn-save').addClass('d-none')
    }
    renderDetailElement()
  }

  function renderDetailElement(){
    $('.card-detail').empty();
    purchase.details.forEach(e=>{
      $('.card-detail').append(renderDetail(e))
      e.stock.products.forEach(d=>{
        $(`.card-detail #stock-${e.stock.id} table tbody #uom-${e.stock.id}`).append(`
          <option ${e.product_barcode==d.barcode?'selected':''} data-id=${e.stock.id} value="${d.convertion}">${d.convertion} / ${d.uom?.name??'--'}</option>
        `)
      })
      e.detail_modals.forEach(modal=>{
        $(`.card-detail #stock-${e.stock.id} .card-body`).append(renderProduct(modal,e.stock.id))
      })
    })
  }

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

  function renderDetail(data){
    let rowDetail =  `
    <div class="card" id='stock-${data.stock.id}'>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
          <table class="table table-striped table-bordered table-sm">
            <thead>
              <th>Stok Group</th>
              <th>Satuan</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th>Harga</th>
              <th>#</th>
            </thead>
            <tbody>
              <tr>
                <td  style="width:350px">${data.stock.name}</td>
                <td >
                  <select name="uom-${data.stock.id}" id="uom-${data.stock.id}" class="form-control select2">
                  </select>
                </td>
                <td class="text-center" style="width:80px"><input type="text" class="text-right qty-order" data-id="${data.stock.id}" style="width: 80px" onkeypress="return IsNumeric(event);" value="${data.qty}"></td>
                <td class="text-center"><input type="text" class="text-right subtotal-order" data-id="${data.stock.id}" style="width: 100px" onkeypress="return IsNumeric(event);" value="${data.subtotal}"></td>
                <td class="text-right" style="width: 100px">${formatNumber(data.price_per_pcs)}</td>
                <td class="text-center"><button class="btn bg-gradient-danger btn-detele" data-id="${data.stock.id}"> <i class="fa fa-trash"></i></button></td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>`
    return rowDetail;
  }

  function renderProduct(data,stockId){
    return `
    <div class="row text-center product-${data.product.barcode}">
          <div class="col-2 text-left">
            <label class="m-0 p-0" >${data.product.name}</label>
            <p class="m-0 p-0">SKU : <label class="m-0 p-0" >${data.product.barcode}</label></p>
          </div>
          <div class="col-2">
            <p class="m-0 p-0">Satuan</p>
            <p class="m-0 p-0"><label class="m-0 p-0" >${data.product.convertion}/${data.product.uom?.name??'--'}</label></p>
          </div>
          <div class="col-2">
            <p class="m-0 p-0">Modal <small>(dpp+pajak)</small></p>
            <p class="m-0 p-0"><small>${formatNumber(data.dpp)} + ${formatNumber(data.tax_paid)}</small></p>
            <p class="m-0 p-0"><label class="m-0 p-0" >Rp. ${formatNumber(data.modal)}</label></p>
          </div>
          <div class="col-2">
            <p class="m-0 p-0">Harga Jual Saat Ini</p>
            <p  class="m-0 p-0 p-price-"><label >Rp. ${formatNumber(data.current_price)}</label></p>
          </div>
          <div class="col-2 text-right">
            <p class="m-0 p-0">Harga Jual Baru</p>
            <p  class="m-0 p-0 p-price-">
              <input type="text" data-stock = ${stockId} data-barcode = ${data.product.barcode} value="${data.new_price}" class="form-control text-right new-price">
            </p>
          </div>
          <div class="col-2">
            <p class="m-0 p-0"><small>Laba sebelum Pajak : Rp.${formatNumber(data.margin_before_tax)}</small></p>
            <p class="m-0 p-0"><small>Laba setelah Pajak : Rp.${formatNumber(data.margin_after_tax)}</small></p>
          </div>
        </div>
    `
  }

  function onSubmit(){
    purchase.invoice_no = $('#invoice-no').val();
    purchase.pic = $('#pic').val();
    purchase.payment_type = $('#payment-type').val();
    if ((purchase.payment_type === "lunas")) {
      purchase.due_date = null;
    }else{
      if ($('#due-date').val()=="" ||$('#due-date').val()==null) {
        alert('Tanggal Jatuh Tempo Tidak Boleh Kosong')
        return false;
      }else{
        purchase.due_date = moment($('#due-date').val(),"DD MMMM YYYY").format('YYYY-MM-DD');
      }
    }
    purchase.date = moment($('#date-time').val(),"DD MMMM YYYY").format('YYYY-MM-DD');
    if (purchase.is_distributor) {
      if ($('#supplier').val() == "" || $('#supplier').val()==null) {
        alert('Supplier Tidak Boleh Kosong')
        return false;
      }else{
        purchase.supplier = {
            id:$('#supplier').val()
          };
      }
    }else{
      purchase.supplier= null
    }
    ajax(purchase, "{{ route('purchase-order.store') }}", "POST",
      function(json) {
        toastr.success('Transaksi Berhasil Disimpan')
        console.log(json)
      },function(json){
        console.log(json)
      }
    )
  }
</script>
@endsection
