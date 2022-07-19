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
        <form action="">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="barcode">Barcode</label>
                        <input type="text" autofocus="true" class="form-control" name="barcode" id="barcode">
                        
                      </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" class="form-control" name="name" id="name">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="uom_id">Satuan</label>
                        <select name="uom_id" id="uom_id" class="form-control">
                            <option value="" disabled selected>--pilih Satuan--</option>
                            @foreach ($uoms as $uom)
                                <option value="{{$uom->id}}">{{$uom->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="category_id">Kategori</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="" disabled selected>--pilih Kategori--</option>
                            @foreach ($categories as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                            @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input onkeypress="return IsNumeric(event);" type="text" class="form-control number2" name="price" id="price">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary "><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
          </form>
      </div>
    </div>
  </div>
@endsection

@section('content-script')
<script src="/plugins/select2/js/select2.full.min.js"></script>
@endsection