@extends('layouts.main-layout')

@section('content-child')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1 text-primary"></i>
                {{ $title }}
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus-circle"></i> Tambah
                </button>
            </div>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content p-0">
                
            </div>
        </div><!-- /.card-body -->
    </div>
</div>

<div class="modal fade" id="modal-default"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="">
                            <div class="form-group">
                                <label for="category-text">Kategori</label>
                                <input type="text" class="form-control" id="category-text" name="category-text" placeholder="Kategori">
                            </div>
                            <div class="form-group">
                                <label for="description-text">Deskripsi</label>
                                <textarea type="text" class="form-control" id="description-text" name="description-text" placeholder="Deskripsi"></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is-active">
                                <label class="form-check-label" for="is-active">Aktif</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection