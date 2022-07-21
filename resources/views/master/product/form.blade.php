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
        <form form-validate=true method="POST" action="{{ !isset($product)?"/product":"/product/$product->barcode" }}">
            @if (isset($product))
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
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
                        <label for="uom_id">Satuan</label>
                        <select required name="uom_id" id="uom_id" class="form-control @error('uom_id') is-invalid @enderror">
                            <option disabled selected>--pilih Satuan--</option>
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
                        <label for="category_id">Kategori</label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="" disabled selected>--pilih Kategori--</option>
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
                        <label for="price">Harga</label>
                        <input value="{{ old('price',$product->price??0) }}" required onkeypress="return IsNumeric(event);" type="text" class="form-control number2 @error('price') is-invalid @enderror" name="price" id="price">
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="2">{{ old('description',$product->description??'') }}</textarea>
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
