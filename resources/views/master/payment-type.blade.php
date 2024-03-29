@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">List Tipe Pembayaran</h2>
      {{-- <div class="card-tools">
        <a class="btn btn-primary" id="btn-add" data-toggle="modal" data-target="#modal-description" data-backdrop="static" data-keyboard="false">
          <i class="fas fa-plus-circle"></i> Tambah
        </a>
      </div> --}}
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-bordered table-sm " id="table-payment-type">
        <thead>
          <tr>
            <th>Tipe Pembayaran</th>
            <th>Deskripsi</th>
            <th>Set Utama</th>
            <th>Status</th>
            {{-- <th>Aksi</th> --}}
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

{{-- @include('component.modal-description') --}}
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function(){
    paymentType= $('#table-payment-type').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('payment.index') }}",
        type:"GET",
      },
      columns:[
        {
          data:"name",
          defaultContent:"--"
        },
        {
          data:"description",
          defaultContent:"--"
        },
        {
          data:"is_default",
          defaultContent:"--",
          mRender:function(data,type,full){
            return `<div class="custom-control custom-switch">
                      <input type="checkbox" ${data?'checked':''} name="my-switch" class="custom-control-input change-default" id="default-${full.id}">
                      <label class="custom-control-label" for="default-${full.id}"></label>
                    </div>`
          }
        },
        {
          data:"is_active",
          defaultContent:"--",
          mRender:function(data,type,full){
            // return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
            return `<div class="custom-control custom-switch">
                      <input type="checkbox" ${data?'checked':''} name="status-switch" class="custom-control-input change-status" id="switch-${full.id}">
                      <label class="custom-control-label" for="switch-${full.id}"></label>
                    </div>`
          }
        },
        // {
        //   data: 'id',
        //   mRender: function(data, type, full) {
        //     return `<a data-toggle="modal" data-target="#modal-description" title="Edit" class="btn btn-sm bg-gradient-primary edit-payment"><i class="fas fa-eye"></i></a>`
        //   }
        // }
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [2,3]
          },
        ],
      order:[[3,'desc']]
    })
    $('div.dataTables_filter input', paymentType.table().container()).focus();

    $('#table-payment-type').on('click','.edit-payment',function() {
      let data = paymentType.row($(this).parents('tr')).data();
      $('#id').val(data.id??'--');
      $('#name').val(data.name??'--');
      $('#description').val(data.description??'');
      $('#form-method').append(`
        @method('put')
      `)
      $('#form-description').attr('action',`/payment/${data.id}`)
    })

    $('#table-payment-type').on('click','.change-default',function() {
      let data = paymentType.row($(this).parents('tr')).data();
      console.log(data)
    })

    $('#btn-add').on('click',function(){
      $('#form-description').attr('action','/payment')
      $('#form-method').append(`
        @method('post')
      `)
    })

    $('#table-payment-type').on('click','.change-status',function() {
      let bool = $(this).prop('checked');
      let data = paymentType.row($(this).parents('tr')).data();
      data.is_active = bool?1:0;
      ajax(data, `{{URL::to('payment/status')}}`, "PUT",
          function(json) {
            paymentType.clear().draw();
      })
    })
    $('#table-payment-type').on('click','.change-default',function() {
      let bool = $(this).prop('checked');
      let data = paymentType.row($(this).parents('tr')).data();
      data.is_default = bool?1:0;
      ajax(data, `{{URL::to('payment/default')}}`, "PUT",
          function(json) {
            paymentType.clear().draw();
      })
    })
  })
</script>
@endsection