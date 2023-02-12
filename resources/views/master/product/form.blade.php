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
                <form method="post" action="/product" enctype="multipart/form-data">
                    @csrf
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
                                <label for="barcode">Kode Barang</label>
                                <input required autofocus="true"  type="text" value="{{ old('barcode',$product->barcode??'') }}" class="form-control @error('barcode') is-invalid @enderror" name="barcode" id="barcode">
                                @error('barcode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
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
                    </div>
                    <div class="row">
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
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="uom_id">Satuan</label>
                                <select required name="uom_id" id="uom_id" class="form-control select2 @error('uom_id') is-invalid @enderror">
                                    <option selected value="" disabled>--Pilih Satuan--</option>
                                    @foreach ($uoms as $uom)
                                        @if (old('uom_id',$product->uom_id??'')==$uom->id)
                                            <option selected value="{{$uom->id}}">{{$uom->name}}</option>
                                        @else
                                            <option value="{{$uom->id}}">{{$uom->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="stock_id">Stok Group</label>
                                <div class="input-group mb-3">
                                    <select required name="stock_id" id="stock_id" class="form-control select2 @error('stock_id') is-invalid @enderror">
                                        <option selected value="" disabled>--Pilih Group Stok--</option>
                                        @foreach ($stocks as $stock)
                                            @if (old('stock_id',$product->stock_id??'')==$stock->id)
                                                <option selected value="{{$stock->id}}">{{$stock->name}}</option>
                                            @else
                                                <option value="{{$stock->id}}">{{$stock->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="btn-stock" data-toggle="modal" data-target="#modal-stock"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="convertion">Konversi Qty</label>
                                <input required  type="number" value="{{ old('convertion',$product->convertion??'') }}" class="form-control @error('convertion') is-invalid @enderror" name="convertion" id="convertion">
                                @error('convertion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="price">Harga Jual</label>
                                <input required  type="number" value="{{ old('price',$product->price??'') }}" class="form-control @error('price') is-invalid @enderror" name="price" id="price">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input style="padding-left: 3px !important; padding-top:3px !important" type="file"  class="form-control " name="image" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" onclick="history.back()" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</button>
                            <button type="submit" class="btn btn-primary "><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-stock" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Form Group Stok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/stock">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Nama Group</label>
                                    <input required type="text"  class="form-control " name="name" id="stock-name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="value">Jumlah Stock</label>
                                    <input required type="number"  class="form-control " name="value" id="stock-value">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary "><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('content-script')
    @endsection
