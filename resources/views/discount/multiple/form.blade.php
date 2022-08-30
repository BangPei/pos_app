@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/plugins/dataTables-checkboxes/css/dataTables.checkboxes.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Paket Diskon</h2>
        </div>
        <div class="card-body ">
            <form autocomplete="off" form-validate=true id="form-multiple-discount">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="name">Nama Promosi</label>
                            <input required value="{{ old('name',$multipleDiscount->name??'') }}"  type="text" autofocus="true" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="min_qty">Qty</label>
                            <input required value="{{ old('name',$multipleDiscount->min_qty??'') }}" type="text" class="form-control number2" name="min_qty" id="min_qty">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="discount">Diskon</label>
                            <input required value="{{ old('name',$multipleDiscount->discount??'') }}" type="text" class="form-control number2" name="discount" id="discount">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-primary" href="" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-sm" id="table-product-discount">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col md-12 text-center">
                        <button type="button" onclick="saveMultipleDiscount()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
                        <table class="table table-striped table-bordered table-sm" width="100%" id="table-product">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkAll"></th>
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
<script src="/plugins/dataTables-checkboxes/js/dataTables.checkboxes.min.js"></script>
<script>
    let dataId = "<?=isset($multipleDiscount)?$multipleDiscount->id:null?>";
    let multipleDiscount = {
        "_token": "{{ csrf_token() }}",
        name:null,
        min_qty:0,
        discount:0,
        details:[],
    }
    $(document).ready(function(){
        tblProductDiscount= $('#table-product-discount').DataTable({
            paging: false,
            searching: false,
            ordering:  false,
            data: multipleDiscount.details,
            columns:[
                {
                    data:"item_convertion.name",
                    defaultContent:"--",
                },
                {
                    data:"item_convertion.price",
                    defaultContent:"0",
                    mRender:function(data,type,full){
                        return `Rp. ${formatNumber(data)}`
                    }
                },
                {
                    data:"is_active",
                    defaultContent:"-",
                    mRender:function(data,type,full){
                        return `<div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                </div>`
                    }
                },
                {
                    data:"item_convertion.id",
                    mRender:function(data,type,full){
                        return `<a title="Hapus" class="btn btn-sm bg-gradient-danger delete-product"><i class="fas fa-trash"></i></a>`
                    }
                }
            ]
        })
        $('#modal-product').on('hidden.bs.modal', function (e) {
            $('#table-product').DataTable().destroy();
        })
        $('#modal-product').on('show.bs.modal', function (e) {
            tblProduct = $('#table-product').DataTable({
                processing:true,
                serverSide:true,
                ordering:false,
                ajax:{
                    url:"{{URL::to('item-convertion/dataTable')}}",
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
                ],
                columnDefs: [
                    { 
                        className: "text-center",
                        targets: [0,2,3]
                    },
                ],
                order: [[1, 'desc']],
                drawCallback: function( settings ) {
                    var api = this.api();
                    var node = api.rows().nodes()
                    for (var i = 0; i < node.length; i++) {
                        let dataId = $(node[i]).find('input').attr('data-id')
                        let isExist = multipleDiscount.details.some(item => item.item_convertion_id == dataId)
                        if (isExist) {
                            $(node[i]).find('input').prop('checked',true)
                        }
                    }
                }
            })
            $('div.dataTables_filter input', tblProduct.table().container()).focus();
        })

        $('#table-product').on('change','td input[type="checkbox"]',function() {
            let item_convertion = tblProduct.row($(this).parents('tr')).data();
            let val = $(this).prop('checked');
            let detail = {
                item_convertion_id:item_convertion.id,
                item_convertion:item_convertion,
                is_active:true,
            }
            if (val == true) {
                multipleDiscount.details.push(detail)
            }else{
                multipleDiscount.details.splice(detail, 1);
            }
            reloadJsonDataTable(tblProductDiscount, multipleDiscount.details);
        })

        $('#table-product-discount').on('click','.delete-product',function(){
            let data = tblProductDiscount.row($(this).parents('tr')).index();
            multipleDiscount.details.splice(data, 1);
            reloadJsonDataTable(tblProductDiscount, multipleDiscount.details);
        })

        dataId!=""?getMultipleDiscount():null;
    })

    function getMultipleDiscount(){
            let data = {
                id:dataId,
            }
            ajax(data, `{{URL::to('multiple-discount/show')}}`, "GET",
                function(json) {
                    multipleDiscount = json;
                    reloadJsonDataTable(tblProductDiscount,multipleDiscount.details);
            })
        }

    function saveMultipleDiscount(){
        let name = $('#name').val();
        let min_qty = $('#min_qty').val();
        let discount = $('#discount').val();
        if (name == "" || min_qty =="" || discount =="") {
            alert('Nama Promosi, Qty dan Discount tidak boleh kosong');
            return false;
        }
        multipleDiscount.name = name;
        multipleDiscount.min_qty = parseInt(min_qty.replace(/,/g, ""));
        multipleDiscount.discount = parseFloat(discount.replace(/,/g, ""));
        let method = dataId == ""?"POST":"PUT";
        let url = dataId == ""?"{{ route('multiple-discount.store') }}":"{{URL::to('multiple-discount/update')}}"
        ajax(multipleDiscount, url, method,
            function(json) {
                toastr.success('Berhasil Memproses Data')
                resetForm($('#form-multiple-discount'))
                multipleDiscount.details = [];
                reloadJsonDataTable(tblProductDiscount,multipleDiscount.details);
                setTimeout(() => {
                    // location.reload()
                    method == "POST"?
                    location.reload():
                    window.location = "{{URL::to('multiple-discount')}}";
                }, 1000);
        })
        
    }
</script>
@endsection

