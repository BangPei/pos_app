    @extends('layouts.main-layout')

    @section('content-style')
    @endsection

    @section('content-child')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Form Produk</h2>
            </div>
            <div class="card-body ">
                <form form-validate=true id="form-product">
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
                                <label for="barcode">Barcode</label>
                                <input {{ isset($product)? 'readonly':'' }} required value="{{ old('barcode',$product->barcode??'') }}" type="text" autofocus="true" class="form-control @error('barcode') is-invalid @enderror" name="barcode" id="barcode">
                                @error('barcode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Nama Produk</label>
                                <input required  type="text" value="{{ old('name',$product->name??'') }}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
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
                                        @if (old('category_id',$product->category_id??'')==$ct->id)
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
                        <div class="col-md-12 text-right">
                            <a class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-convertion">
                                <i class="fas fa-plus-circle"></i> Tambah Konversi
                            </a>
                        </div>
                        <div class="col-md-12 mt-3 table-responsive">
                            <table class="table table-striped table-bordered table-sm" width="100%" id="table-convertion">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>qty</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" onclick="history.back()" class="btn btn-default "><i class="fas fa-arrow-left"></i> Kembali</button>
                            <button type="submit" class="btn btn-primary "><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-convertion" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Form Konversi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form form-validate=true id="form-convertion">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="barcode-convertion">Barcode</label>
                                    <input class="d-none" id="id-convertion" name="id-conversion">
                                    <input required type="text" class="form-control" id="barcode-convertion" name="barcode-convertion">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="name-convertion">Nama</label>
                                    <input required type="text" class="form-control" id="name-convertion" name="name-convertion">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="uom_id">Satuan</label>
                                    <select required name="uom_id" id="uom_id" class="form-control @error('uom_id') is-invalid @enderror">
                                        <option selected value="" disabled>--Pilih Satuan--</option>
                                        @foreach ($uoms as $ct)
                                            @if (old('uom_id',$product->uom_id??'')==$ct->id)
                                                <option selected value="{{$ct->id}}">{{$ct->name}}</option>
                                            @else
                                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="qty-convertion">Qty Koversi</label>
                                    <input required type="text" class="form-control number2" id="qty-convertion" name="qty-convertion">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="price-convertion">Harga</label>
                                    <input required type="text" class="form-control number2" id="price-convertion" name="price-convertion">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('component.modal-description')
    @endsection


    @section('content-script')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        let barcode ="<?=isset($product)?$product->barcode:null?>";
        let product = {
            items_convertion : [],
            category:null,
            barcode:null,
            name:null,
        }
        $(document).ready(function(){
            tblConvertion =  $('#table-convertion').DataTable({
                paging: false,
                searching: false,
                data:product.items_convertion,
                columns:[
                    {
                        data:"barcode",
                        defaultContent:"-"
                    },
                    {
                        data:"name",
                        defaultContent:"-"
                    },
                    {
                        data:"uom.name",
                        defaultContent:"-"
                    },
                    {
                        data:"qtyConvertion",
                        defaultContent:"-",
                        className:"text-center",
                        mRender:function(data,type,full){
                            return `${formatNumber(data)}`
                        }
                    },
                    {
                        data:"price",
                        defaultContent:"-",
                        mRender:function(data,type,full){
                            return `Rp. ${formatNumber(data)}`
                        }
                    },
                    {
                        data:"is_active",
                        defaultContent:"--",
                        mRender:function(data,type,full){
                            // return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
                            return `<div class="custom-control custom-switch">
                                        <input type="checkbox" ${data?'checked':''} name="my-switch" class="custom-control-input" id="switch-${full.barcode}">
                                        <label class="custom-control-label" for="switch-${full.barcode}"></label>
                                    </div>`
                        }
                    },
                    {
                        data:null,
                        defaultContent:"-",
                        mRender: function(data, type, full) {
                            return `<a title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-eye"></i></a>
                            <a title="Hapus Produk" onclick="return confirm('Apakah Yakin Ingin Menghapus Produk ini?)" class="btn btn-sm bg-gradient-danger delete-product">
                                <i class="fas fa-trash"></i>
                            </a>
                            `
                        }
                    },
                ],
                order:[[3,'asc']],
                columnDefs: [
                    { 
                        className: "text-right",
                        targets: [3,4]
                    },
                    { 
                        className: "text-center",
                        targets: [2,5]
                    },
                    { 
                        width: '8%',
                        targets: [2,3,5,6]
                    },
                    { 
                        width: '12%',
                        targets: 5
                    },
                    { 
                        width: '20%',
                        targets: 0
                    },
                    { 
                        width: '10%',
                        targets: [3,4]
                    },
                ],
            })

            $('#table-convertion').on('click', '.delete-product', function() {
                let data = tblConvertion.row($(this).parents('tr')).data();
                product.items_convertion.splice(data, 1);
                reloadJsonDataTable(tblConvertion, product.items_convertion);
            });
            $('#table-convertion').on('click', '.edit-product', function() {
                let data = tblConvertion.row($(this).parents('tr')).data();
                $('#id-convertion').val(data.id)
                $('#barcode-convertion').val(data.barcode)
                
                $('#name-convertion').val(data.name)
                $('#qty-convertion').val(formatNumber(data.qtyConvertion))
                $('#price-convertion').val(formatNumber(data.price))
                $('#uom_id').val(data.uom.id).trigger('change')
                $('#modal-convertion').modal();
                $('input#barcode-convertion').attr('readonly','readonly')
            });

            $('#table-convertion').on('click','.custom-control-input',function() {
                let bool = $(this).prop('checked');
                let data = tblConvertion.row($(this).parents('tr')).data();
                data.is_active = bool?1:0;
            })

            saveProduct();
            addConvertion();

            $('#modal-convertion').on('show.bs.modal', function (e) {
                $('input#barcode-convertion').removeAttr('readonly')
                if ( product.items_convertion.length ==0) {
                    $('#barcode-convertion').val($('#barcode').val())
                    $('#name-convertion').val($('#name').val())
                }
            })

            $(window).on('beforeunload', function(e){
                e.preventDefault();
                if (product.items_convertion.length!=0) {
                    return event.returnValue = "Do you want to exit this page?";
                }
            });

            barcode!=""?getProduct():null;
        })

        function getProduct(){
            let data = {
                barcode:barcode,
            }
            ajax(data, `{{URL::to('product/show')}}`, "GET",
                function(json) {
                    product = json;
                    reloadJsonDataTable(tblConvertion,product.items_convertion);
            })
        }

        function saveProduct(){
            formValid($('#form-product'),function(){
                if (product.items_convertion.length==0) {
                    alert('Konversi Satuan dan Harga Tidak boleh kosong');
                    return false;
                }
                product.barcode = $('#barcode').val();
                product.name = $('#name').val();
                product.category ={id:$('#category_id').val()};
                let method = barcode == ""?"POST":"PUT";
                let url = barcode == ""?"{{ route('product.store') }}":"{{URL::to('product/update')}}"
                ajax(product, url, method,
                    function(json) {
                        toastr.success('Berhasil Memproses Data')
                        resetForm($('#form-product'))
                        product.items_convertion = [];
                        reloadJsonDataTable(tblConvertion,product.items_convertion);
                        console.log(json)
                        setTimeout(() => {
                            location.reload()
                            // method == "POST"?
                            // location.reload():
                            // window.location = "{{URL::to('product')}}";
                        }, 1000);
                })
            })
        }

        function addConvertion(){
            formValid($('#form-convertion'),function(){
                let id = parseInt($('#id-convertion').val()==""?0:$('#id-convertion').val());
                let qty = $('#qty-convertion').val() == ""?"0":$('#qty-convertion').val()
                let price = $('#price-convertion').val() == ""?"0":$('#price-convertion').val()
                if (id == 0) {
                    if (product.items_convertion.some(item => item.barcode ==$('#barcode-convertion').val())) {
                        alert('Barcode yang anda masukan sudah terdaftar')
                        return false;
                    }
                    if (product.items_convertion.some(item =>parseInt(item.uom.id) === parseInt($('#uom_id').val()))) {
                        alert('Satuan yang anda masukan sudah terdaftar')
                        return false;
                    }
                    let dataId =product.items_convertion.length==0?1: Math.max(...product.items_convertion.map(o => o.id))+1
                    let items_convertion = {
                        id:dataId,
                        barcode:$('#barcode-convertion').val(),
                        name:$('#name-convertion').val(),
                        is_active:true,
                        qtyConvertion:parseFloat(qty.replace(/,/g, "")),
                        price:parseFloat(price.replace(/,/g, "")),
                        uom:{
                            id:$('#uom_id').val(),
                            name:$("#uom_id option:selected" ).text(),
                        }
                    }
                    product.items_convertion.push(items_convertion);
                }
                else{
                    product.items_convertion.forEach(e => {
                        if ((e.uom.id==$('#uom_id').val()) && (e.id != id)) {
                            alert('Barcode yang anda masukan sudah terdaftar')
                            return false;
                        }
                        if (e.id == id) {
                            e.barcode = $('#barcode-convertion').val();
                            e.name = $('#name-convertion').val();
                            e.qtyConvertion = parseFloat(qty.replace(/,/g, ""));
                            e.uom.id = $('#uom_id').val();
                            e.uom.name = $("#uom_id option:selected" ).text();
                            e.price = parseFloat(price.replace(/,/g, ""));
                        }
                    });
                }
                reloadJsonDataTable(tblConvertion,product.items_convertion);
                $('#modal-convertion').modal('hide')
            })
        }
    </script>

    @endsection
