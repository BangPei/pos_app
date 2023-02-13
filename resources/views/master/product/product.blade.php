@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content-child')
<div class="col-md-12">
  <div class="card card-primary card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-2"><h2 class="card-title mt-2">List Produk</h2></div>
        <div class="col-6">
          <form action="" method="">
            <div class="input-group">
              <input autofocus="true" type="text" name="search" id="search" class="form-control" placeholder="Cari Barcode atau Nama Barang" >
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-4 text-right">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-danger"><i class="fa fa-upload"></i> Import</button>
            <button type="button" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
            <a class="btn btn-primary" href="/product/create">
              <i class="fas fa-plus-circle"></i> Tambah
          </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (count($products) == 0)
      <div class="card">
        <div class="row">
          <div class="col-12 text-center">
            Tidak Ada Product
          </div>
        </div>
      </div>
  @endif

  @foreach ($products as $p)
      <div class="card p-2">
        <div class="row text-center">
          <div class="col">
            @if ((!isset($p->image))|| ($p->image==""))
            <img width="80" src="{{ asset('image/logo/logo.png') }}" class="rounded float-left img-thumbnail" alt="{{ $p->name }}">
            @else
            <img width="80" src="{{ asset('storage/'.$p->image) }}" class="rounded float-left img-thumbnail" alt="{{ $p->name }}">
            @endif
          </div>
          <div class="col-3 text-left">
            <label class="m-0 p-0" for="">{{ Str::upper($p->name) }}</label>
            <p class="m-0 p-0">SKU : <label class="m-0 p-0" for="">{{ $p->barcode }}</label></p>
            <p class="m-0 p-0">Satuan : <label class="m-0 p-0" for="">{{$p->convertion."/".$p->uom?->name??"" }}</label></p>
            <p class="m-0 p-0">Kategori : <label class="m-0 p-0" for="">{{ $p->category?->name??"" }}</label></p>
          </div>
          <div class="col-3">
            <p class="m-0 p-0">Harga Jual</p>
            <p class="m-0 p-0"><label for="">Rp. {{ number_format($p->price, 0, ',', ',') }}</label></p>
          </div>
          <div class="col-3">
            <p class="m-0 p-0">Stok</p>
            <p class="m-0 p-0"> <label for="">{{ isset($p->stock)?number_format($p->stock?->value??0 / $p->convertion??0, 0, ',', ','):0 }}</label></p>
          </div>
          <div class="col">
            <p class="m-0 p-0">
              status
              <div class="custom-control custom-switch">
                <input type="checkbox" {{ $p->is_active?'checked':'' }} name="my-switch" class="custom-control-input" id="switch-{{ $p->id }}">
                <label class="custom-control-label" for="switch-{{ $p->id }}"></label>
              </div>
            </p>
          </div>
          <div class="col">
            <p class="m-0 p-0">
              <a href="/product/{{$p->id}}/edit" title="Edit" class="btn btn-sm bg-gradient-success edit-product"><i class="fas fa-eye"></i> Lihat</a>
            </p>
          </div>
        </div>
      </div>
  @endforeach

  <div class="d-flex justify-content-center">
    {{ $products->links() }}
  </div>
</div>
@endsection

@section('content-script')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
    tblProduct = $('#table-product').DataTable({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{ route('product.index') }}",
        type:"GET",
      },
      columns:[
        {
          data:"name",
          defaultContent:"--"
        },
        {
          data:"category.name",
          defaultContent:"--"
        },
        {
          data:"is_active",
          defaultContent:"--",
          mRender:function(data,type,full){
            // return `<div class="badge badge-${data==1?'success':'danger'}">${data==1?'Aktif':'Tidak Aktif'}</div>`
            return `<div class="custom-control custom-switch">
                      <input type="checkbox" ${data?'checked':''} name="my-switch" class="custom-control-input" id="switch-${full.id}">
                      <label class="custom-control-label" for="switch-${full.id}"></label>
                    </div>`
          }
        },
        {
					data: 'id',
					mRender: function(data, type, full) {
						return `<a href="/product/${full.id}/edit" title="Edit" class="btn btn-sm bg-gradient-primary edit-product"><i class="fas fa-edit"></i></a>`
					}
				}
      ],
      columnDefs: [
          { 
            className: "text-center",
            targets: [1,2,3]
          },
        ],
      order:[[3,'desc'],[0,'asc']]
    })
    $('div.dataTables_filter input', tblProduct.table().container()).focus();

    $('#table-product').on('click','.custom-control-input',function() {
      let bool = $(this).prop('checked');
      let data = tblProduct.row($(this).parents('tr')).data();
      data.is_active = bool?1:0;
      data.category_id = data.category.id;
      ajax(data, `{{URL::to('/product/status')}}`, "PUT",
          function(json) {
            tblProduct.clear().draw();
      })
    })
  })
</script>
@endsection