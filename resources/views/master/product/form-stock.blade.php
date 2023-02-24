@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Group Stock</h2>
        </div>
        <div class="card-body ">
            <form id="form-stock" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('message'))
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ session('message') }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="name">Nama Group Stock</label>
                            <input required  type="text" value="{{ old('name',$stock->name??'') }}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="value">Jumlah Stok</label>
                            <input required number type="text" value="{{ old('name',number_format($stock->value??0)) }}" class="form-control @error('value') is-invalid @enderror" name="value" id="value">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-right mb-3">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
                            <i class="fas fa-eye"></i> List Produk
                        </a>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped table-bordered table-sm" id="table-stock-product">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Produk</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Stock Tersedia</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" onclick="history.back()" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</button>
                        <button type="button" onclick="saveStock()" class="btn btn-primary "><i class="fas fa-save"></i> Simpan</button>
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
                    <th><input type="checkbox" class="checkAll"></th>
                    <th>Barcode</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Harga</th>
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
    let stockId = "<?=isset($stock)?$stock->id:null?>";
    let stock = {
        name:null,
        value:0,
        products:[]
    }
    $(document).ready(function(){
        stockId!=""?getStock():null;
        tblStockProduct=$('#table-stock-product').DataTable({
            paging: false,
            searching: false,
            ordering:  false,
            data:stock.products,
            columns:[
                {
                    data:"barcode",
                    bSortable: false,
                    defaultContent:"--",
                },
                {
                    data:"name",
                    bSortable: false,
                    defaultContent:"--",
                },
                {
                    data:"uom.name",
                    bSortable: false,
                    defaultContent:"--",
                    className:"text-center",
                    mRender:function(data,type,full){
                        return `${full.convertion} / ${data??"--"}`
                    }
                },
                {
                    data:"price",
                    bSortable: false,
                    defaultContent:"--",
                    className:"text-right",
                    mRender:function(data,type,full){
                        return `${formatNumber(data)}`
                    }
                },
                {
                    data:"convertion",
                    bSortable: false,
                    defaultContent:"--",
                    className:"text-right",
                    mRender:function(data,type,full){
                        return `${formatNumber(Math.floor(stock.value/data))}`
                    }
                },
                {
                    data:"id",
                    bSortable: false,
                    defaultContent:"--",
                    className:"text-right",
                    mRender: function(data, type, full) {
                        return `<a title="delete" class="btn btn-sm bg-gradient-danger delete-product"><i class="fas fa-trash"></i></a>`
                    }
                },
            ]
        })

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
                        data:"id",
                        defaultContent:"--",
                        mRender:function(data,type,full){
                            return `<input type="checkbox" class="input-check" data-id="${data}">`
                        }
                    },
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
                ],
                columnDefs: [
                    { 
                        className: "text-center",
                        targets: [0,3,4]
                    },
                ],
                order: [[1, 'desc']],
                drawCallback: function( settings ) {
                    var api = this.api();
                    var node = api.rows().nodes()
                    for (var i = 0; i < node.length; i++) {
                        let dataId = $(node[i]).find('input').attr('data-id')
                        let isExist = stock.products.some(item => item.id == dataId)
                        if (isExist) {
                            $(node[i]).find('input').prop('checked',true)
                        }
                    }
                },
            })
            $('div.dataTables_filter input', tblProduct.table().container()).focus();
        })
        $('#modal-product').on('hidden.bs.modal', function (e) {
            $('#table-product').DataTable().destroy();
        })
        $('#table-product').on('change','td input[type="checkbox"]',function() {
            let product = tblProduct.row($(this).parents('tr')).data();
            let val = $(this).prop('checked');
            
            if (val == true) {
                stock.products.push(product)
            }else{
                stock.products.splice(product, 1);
            }
            reloadJsonDataTable(tblStockProduct, stock.products);
        })
        $('#table-stock-product').on('click','.delete-product',function(){
            let data = tblStockProduct.row($(this).parents('tr')).index();
            stock.products.splice(data, 1);
            reloadJsonDataTable(tblStockProduct, stock.products);
        })
    })

    function getStock(){
        let data = {
            id:stockId,
        }
        ajax(data, `{{URL::to('stock/show')}}`, "GET",
            function(json) {
                stock = Object.assign({}, json);
                reloadJsonDataTable(tblStockProduct,json.products);
        })
    }

    function saveStock(){
        stock.name = $('#name').val();
        let value = $('#value').val();
        if (stock.name == "" || value =="") {
            toastr.error('Nama Group dan Stok tidak boleh kosong');
            return false;
        }
        stock.value = parseFloat(value.replace(/,/g, ""));
        let method = stockId == ""?"POST":"PUT";
        let url = stockId == ""?"{{ route('stock.store') }}":"{{URL::to('stock/update')}}"
        
        ajax(stock, url, method,
            function(json) {
                toastr.success('Berhasil Memproses Data')
                resetForm($('#form-stock'))
                stock.products = [];
                reloadJsonDataTable(tblStockProduct,stock.products);
                setTimeout(() => {
                    location.reload()
                }, 1000);
        })
        
    }
</script>
@endsection
