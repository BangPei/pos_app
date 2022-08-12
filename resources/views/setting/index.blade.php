@extends('layouts.main-layout')
@section('content-class')
@endsection

@section('content-child')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
        <h2 class="card-title">Potangan Tambahan</h2>
        <div class="card-tools">
            <a class="btn btn-primary" id="btn-add" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-plus-circle"></i> Tambah
            </a>
        </div>
        </div>
        <div class="card-body">
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

@endsection

@section('content-script')
<script src="js/script.js"></script>
@endsection