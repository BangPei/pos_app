@extends('layouts.main-layout')

@section('content-style')
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
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
                        <div class="input-group mb-3">
                            <select required name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="" disabled selected>--pilih Kategori--</option>
                            </select>
                            <div class="input-group-append">
                                <a data-toggle="modal" data-target="#modal-description" class="btn btn-outline-secondary bg-secondary" type="button"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-right">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#modal-convertion">
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
    <div class="modal-dialog modal-md modal-dialog-scrollable">
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
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="barcode-convertion">Barcode</label>
                                <input required type="text" class="form-control" id="barcode-convertion" name="barcode-convertion">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
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
                                <select required name="uom_id" id="uom_id" class="form-control">
                                    <option value="" disabled selected>--pilih Satuan--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="qty-convertion">Qty Koversi</label>
                                <input required type="text" class="form-control .number2" id="qty-convertion" name="qty-convertion">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="price-convertion">Harga</label>
                                <input required type="text" class="form-control .number2" id="price-convertion" name="price-convertion">
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
    let product = {
        itemConvertion : [],
        category:null,
        barcode:null,
        name:null,
    }
    $(document).ready(function(){
        $('#table-convertion').DataTable({
            paging: false,
            searching: false,
            ordering:  false,
            data:product.itemConvertion,
            columns:[
                {
                    name:"barcode",
                    defaultContent:"-"
                },
                {
                    name:"name",
                    defaultContent:"-"
                },
                {
                    name:"uom.name",
                    defaultContent:"-"
                },
                {
                    name:"qtyConvertion",
                    defaultContent:"-"
                },
                {
                    name:"price",
                    defaultContent:"-"
                },
                {
                    name:"is_active",
                    defaultContent:"-"
                },
                {
                    name:"barcode",
                    defaultContent:"-"
                },
            ]
        })

        formValid($('#form-product'),function(){
            saveProduct();
        })
        formValid($('#form-convertion'),function(){
            addConvertion();
        })

        $('#form-convertion #uom_id').on('show.bs.dropdown', function () {
            alert('ok')
        })
        $('#category_id').on('click change', function () {
            $('#category_id').append(`<option value="1">Kesehatan</option>`)
        })
    })

    function saveProduct(){
        alert('ok')
    }

    function addConvertion(){
        let qty = $('#qty-convertion').val() == ""?"0":$('#qty-convertion').val()
        let price = $('#price-convertion').val() == ""?"0":$('#price-convertion').val()
        let itemConvertion = {
            barcode:$('#barcode-convertion').val(),
            name:$('#name-convertion').val(),
            qtyConvertion:parseFloat(qty.replace(/,/g, "")),
            price:parseFloat(price.replace(/,/g, "")),
            uom:{
                id:$('#uom_id').val(),
                name:$("#uom_id option:selected" ).text(),
            }
        }
    }
</script>

@endsection
