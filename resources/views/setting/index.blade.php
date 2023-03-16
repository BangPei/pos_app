@extends('layouts.main-layout')
@section('content-class')
@endsection

@section('content-child')
<div class="col-12">
    <div class="card p-2">
        <nav class="w-100">
            <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link {{(Request::query('tab') == null||Request::query('tab')=='info')?'active':''}}" href="/setting?tab=info"><i class="fa fa-home"></i> Informasi Toko</a>
                <a class="nav-item nav-link {{Request::query('tab')=='deduction'?'active':''}}" href="setting?tab=deduction"><i class="fa fa-dollar-sign"></i> Potongan</a>
                <a class="nav-item nav-link {{Request::query('tab')=='users'?'active':''}}" href="/setting?tab=users"><i class="fa fa-users"></i> User</a>
            </div>
        </nav>
        <div class="tab-content p-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">{{ $tab }}</div>
            <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <h4>Potongan Tambahan</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-primary" id="btn-add" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <table class="table table-striped table-bordered table-sm " id="table-category">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Potongan (%)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reduce as $r)
                                <tr>
                                    <td>{{ $r->name }}</td>
                                    <td><input type="text" value="{{ $r->reduce }}" class="form-control text-right reduce" style="width: 100%"></td>
                                    <td class="text-center"><a class="btn btn-primary"><i class="fa fa-save"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">Tab3</div>
        </div>
    </div>
</div>


@endsection

@section('content-script')
<script src="js/script.js"></script>
@endsection