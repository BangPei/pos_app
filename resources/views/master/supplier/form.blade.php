@extends('layouts.main-layout')

@section('content-style')
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Form Supplier</h2>
        
      </div>
      <div class="card-body ">
        <form form-validate=true method="POST" action="{{ !isset($supplier)?"/supplier":"/supplier/$supplier->id" }}">
            @if (isset($supplier))
                @method('PUT')
            @endif
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <input value="{{ $supplier->id }}" type="text" class="form-control d-none" name="id" id="id">
                        <label for="name">Nama</label>
                        <input required value="{{ old('name',$supplier->name??'') }}" type="text" autofocus="true" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="phone">No. Tlp</label>
                        <input type="text" value="{{ old('phone',$supplier->phone??'') }}" class="form-control" name="phone" id="phone">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="npwp">No. Npwp</label>
                        <input type="text" value="{{ old('npwp',$supplier->npwp??'') }}" class="form-control npwp" name="npwp" id="npwp">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="pic">PIC / Supir</label>
                        <input type="text" value="{{ old('pic',$supplier->pic??'') }}" class="form-control" name="pic" id="pic">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="mobile">No. HP</label>
                        <input type="text" value="{{ old('mobile',$supplier->mobile??'') }}" class="form-control" name="mobile" id="mobile">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="address">Alamat Supplier</label>
                        <textarea class="form-control" name="address" id="address" cols="30" rows="3">{{ old('address',$supplier->address??'') }}</textarea>
                    </div>
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
@endsection
