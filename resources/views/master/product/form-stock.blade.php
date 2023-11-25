@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <style>
    .modal .select2-container {
        width: 100% !important;
    }
  </style>
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
                    <div class="col-lg-4 col-md-4 col-sm-12">
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
                    <div class="col-lg-4 col-md-4 col-sm-12">
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
                    
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select required name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                                <option selected value="" disabled>--Pilih Kategory--</option>
                                @foreach ($categories as $ct)
                                    @if (old('category_id',$stock->category_id??'')==$ct->id)
                                        <option selected value="{{$ct->id}}">{{$ct->name}}</option>
                                    @else
                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                    @endif
                                @endforeach
                            </select>
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

<div class="modal fade" id="modal-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title">Form Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="barcode">Kode Barang</label>
                        <input required autofocus="true"  type="text" class="form-control" name="barcode" id="barcode">
                        <small><i id="barcode-error" class="text-danger"></i></small>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="product-name">Nama</label>
                        <input required  type="text" class="form-control" name="product-name" id="product-name">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="uom_id">Satuan</label>
                        <select required name="uom_id" id="uom_id" class="form-control select2">
                            <option selected value="" disabled>--Pilih Satuan--</option>
                            @foreach ($uoms as $uom)
                                <option value="{{$uom->id}}">{{$uom->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="convertion">Konversi Qty</label>
                        <input required  type="number" class="form-control" name="convertion" id="convertion">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="price">Harga Jual</label>
                        <input required  type="number" class="form-control" name="price" id="price">
                    </div>
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

        $('#table-stock-product').on('click','.delete-product',function(){
            let data = tblStockProduct.row($(this).parents('tr')).index();
            stock.products.splice(data, 1);
            reloadJsonDataTable(tblStockProduct, stock.products);
        })

        $('#barcode').on('change',function(){
            let barcode = $(this).val();
            barcodeCheck(barcode);
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

    function barcodeCheck(barcode){
        ajax(null, `{{URL::to('product/barcode/check/${barcode}')}}`, "GET",
            function(json) {
                $('#barcode-error').html("")
        },function (json) {
            let message = json?.responseJSON?.message??"error"
            $('#barcode').val('')
            $('#barcode-error').html(message)
        })
    }

    function saveStock(){
        stock.name = $('#name').val();
        stock.category={
            id:$('#category_id').val()
        };
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
