@extends('layouts.main-layout')

@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/plugins/dataTables-checkboxes/css/dataTables.checkboxes.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form SKU Online Shop</h2>
        </div>
        <div class="card-body ">
            <form autocomplete="off" form-validate=true id="form-multiple-discount">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input value="{{ old('name',$sku->name??'') }}"  type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="code">SKU</label>
                            <input readonly value="{{ $sku->code??'' }}"  type="text" class="form-control" name="code" id="code">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="total-item">Total Produk</label>
                            <input readonly value="{{ $sku->total_item??'' }}" type="text" class="form-control" name="total-item" id="total-item">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <a id="btn-gift" href="" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
                            <small>Klik untuk Input Variasi Hadiah </small> 
                            <i class="fa fa-edit"></i>
                        </a>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12"><label for="">List Hadiah </label></div>
                        </div>
                        <div class="row gift-element">
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a id="btn-add-product" class="btn btn-primary" href="" data-toggle="modal" data-target="#modal-product" data-backdrop="static" data-keyboard="false">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-sm" id="table-product-sku">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Variasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col md-12 text-center">
                        <button type="button" onclick="submitSKU()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
@include('component.base')
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/dataTables-checkboxes/js/dataTables.checkboxes.min.js"></script>
<script>
    let skuId = "<?=isset($sku)?$sku->id:null?>";
    let sku = {
        id:null,
        code:null,
        name:null,
        total_item:null,
        details:[],
        gifts:[],
    }
    let isGift= false;
    $(document).ready(function(){
        skuId!=""?getSku():null;
        tblProductSku= $('#table-product-sku').DataTable({
            paging: false,
            searching: false,
            ordering:  false,
            data: sku.details,
            columns:[
                {
                    data:"product.barcode",
                    defaultContent:"--",
                },
                {
                    data:"product.name",
                    defaultContent:"--",
                },
                {
                    data:"qty",
                    bSortable: false,
                    defaultContent:"0",
                    mRender:function(data,type,full){
                        return `<input value="${data?formatNumber(data):0}" onfocus="this.select();" onkeypress="return IsNumeric(event);" class="number2 text-right qty-order" style="width:100%" placeholder="0" />`
                    }
                },
                {
                    data:"is_variant",
                    defaultContent:"--",
                    className:"text-center",
                    mRender:function(data,type,full){
                        // return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
                        return `<div class="custom-control custom-switch">
                                <input type="checkbox" ${data?'checked':''} name="variant-switch" class="custom-control-input is-variant" id="variant-${full.product.barcode}">
                                <label class="custom-control-label" for="variant-${full.product.barcode}"></label>
                                </div>`
                    }
                },
                {
                    data:"product.barcode",
                    className:"text-center",
                    mRender:function(data,type,full){
                        return `<a title="Hapus" class="btn btn-sm bg-gradient-danger delete-product"><i class="fas fa-trash"></i></a>`
                    }
                }
            ],
            columnDefs: [],
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
                    url:"{{URL::to('product/dataTable')}}",
                    type:"GET",
                },
                columns:[
                    {
                        data:"id",
                        defaultContent:"--",
                        mRender:function(data,type,full){
                            return `<input ${full.program?"disabled":""} type="checkbox" class="input-check" data-id="${data}">`
                        }
                    },
                    {
                        data:"barcode",
                        defaultContent:"--",
                    },
                    {
                        data:"name",
                        defaultContent:"--",
                        mRender:function(data,type,full){
                            if (full.program) {
                                return `${data}<br> <small><i>(${full.program.multiple_discount.name})</i></small>`
                            }else{
                                return data
                            }
                        }
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
                        targets: [0,3,4]
                    },
                ],
                order: [[1, 'desc']],
                drawCallback: function( settings ) {
                    var api = this.api();
                    var node = api.rows().nodes()
                    if (isGift) {
                        for (var i = 0; i < node.length; i++) {
                            let dataId = $(node[i]).find('input').attr('data-id')
                            let isExist = sku.gifts.some(item => item.product.id == dataId)
                            if (isExist) {
                                $(node[i]).find('input').prop('checked',true)
                            }
                        }
                    }else{
                        for (var i = 0; i < node.length; i++) {
                            let dataId = $(node[i]).find('input').attr('data-id')
                            let isExist = sku.details.some(item => item.product.id == dataId)
                            if (isExist) {
                                $(node[i]).find('input').prop('checked',true)
                            }
                        }
                    }
                },
            })
        })

        $('#table-product').on('change','td input[type="checkbox"]',function() {
            let product = tblProduct.row($(this).parents('tr')).data();
            let val = $(this).prop('checked');
            if (isGift) {
                let gift = {
                    product_barcode:product.barcode,
                    product:product,
                    qty:1,
                }
                if (val == true) {
                    sku.gifts.push(gift)
                }else{
                    sku.gifts.splice(gift, 1);
                }
                renderGift()
            }else{
                let detail = {
                    product_barcode:product.barcode,
                    product:product,
                    qty:1,
                    is_variant:false,
                }
                if (val == true) {
                    sku.details.push(detail)
                }else{
                    sku.details.splice(detail, 1);
                }
                $('#total-item').val(sku.details.length)
                reloadJsonDataTable(tblProductSku, sku.details);
            }
        })

        $('#table-product-sku').on('click','.delete-product',function(){
            let data = tblProductSku.row($(this).parents('tr')).index();
            sku.details.splice(data, 1);
            $('#total-item').val(sku.details.length)
            reloadJsonDataTable(tblProductSku, sku.details);
        })
        $('#table-product-sku').on('change','.is-variant',function(){
            let bool = $(this).prop('checked');
            let data = tblProductSku.row($(this).parents('tr')).data();
            data.is_variant = bool;
        })
        $('#table-product-sku').on('change','.qty-order',function(){
            let value = $(this).val();
            let data = tblProductSku.row($(this).parents('tr')).data();
            data.qty = value;
        })

        $('#btn-add-product').on('click',function(){
            isGift = false;
        })
        $('#btn-gift').on('click',function(){
            isGift = true;
        })
        $('input[name="customRadioInline"]').on('click',function(){
            
            sku.gift = $(this).val()==='true'
            console.log(sku.gift);
            if (sku.gift) {
                $('.gift-element').removeClass('d-none')
            }else{
                $('.gift-element').addClass('d-none')
            }
        })
    })

    function renderGift(){
        $('.gift-element').empty();
        for (let i = 0; i < sku.gifts.length; i++) {
            const gift = sku.gifts[i];
            $('.gift-element').append(`
                <div class="col-3">
                    <div class="alert alert-light" style="padding-block: 0.5rem !important;padding-inline: 0.5rem !important;">
                        <div class="row">
                            <div class="col-2"><small class="badge badge-info">${i+1}</small></div>
                            <div class="col">
                                <div class="row"><small class="col-12">${gift.product.name??'--'}</small></div>
                                <div class="row"><small class="col-12"><i>${gift.product.barcode??'--'}</i></small></div>
                            </div>
                            <div class="col-2"> <a onclick="deleteGift(${gift.product.id??'--'})" title="delete-gift" data-id="${gift.product.id??'--'}"><i class="fa fa-trash text-danger"></i></a> </div>
                        </div>
                    </div>
                </div>`)
        }
    }

    function deleteGift(productId){
        let filters = sku.gifts.filter(e=>e.product.id!=productId)
        sku.gifts = filters;
        renderGift();
    }

    function submitSKU() {
        sku.name = $('#name').val();
        sku.total_item = sku.details.length;
        let url = skuId!=""?`{{URL::to('sku/${skuId}')}}`:"{{ route('sku.store') }}"
        let method = skuId!=""?`PUT`:"POST";
        ajax(sku, url, method,
            function(json) {
                toastr.success('Transaksi Berhasil Disimpan')
                setTimeout(() => {
                    window.location.href = `${baseUrl}/sku/${skuId==""?json.id:skuId}/edit`
                }, 200);
            }
        )
    }

    function getSku(){
        ajax(null, `{{URL::to('sku/${skuId}')}}`, "GET",
            function(json) {
                sku = Object.assign({}, json);
                reloadJsonDataTable(tblProductSku,json.details);
                renderGift()
            },
        )
    }
</script>
@endsection

