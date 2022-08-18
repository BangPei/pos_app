@extends('layouts.main-layout')

@section('content-style')
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Form Paket Diskon</h2>
      </div>
      <div class="card-body ">
        <form autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="name">Nama Promosi</label>
                        <input required type="text" autofocus="true" class="form-control" name="name" id="name">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input required  type="text" class="form-control" name="qty" id="qty">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="discount">Diskon</label>
                        <input required  type="text" class="form-control" name="discount" id="discount">
                    </div>
                </div>
            </div>
          </form>
      </div>
    </div>
  </div>
@endsection
