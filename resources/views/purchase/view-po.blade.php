@extends('layouts.main-layout')
@section('content-class')
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <style>
    span.select2{
      width: 100% !important;
    }
  </style>
@endsection

@section('content-child')
<div class="col-md-12">
    {{-- header --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Form Pembelian</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12"><label for="" class="text-primary">Kode Transaksi : {{ $po->code }}</label></div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">No. Invoice</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="" class="text-info">{{ $po->invoice_no??'--' }}</label></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Kategori</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="" class="text-info">{{ $po->is_distributor?'Distributor':'Non Distributor' }}</label></div>
                            </div>
                            @if ($po->is_distributor)
                                <div class="row">
                                    <div class="col-5">Supplier</div>
                                    <div class="col-1"> : </div>
                                    <div class="col-6"><label for="" class="text-info">{{ $po->is_distributor?$po->supplier->name:'' }}</label></div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-5">PIC</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="" class="text-info">{{ $po->pic}}</label></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">Pembayaran</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="" class="text-info">{{ $po->payment_type}}</label></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Tanggal</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for="" class="text-info">{{ date('d M Y', strtotime($po->date)); }}</label></div>
                            </div>
                            @if ($po->payment_type !='lunas')
                                <div class="row">
                                    <div class="col-5">Jatuh Tempo</div>
                                    <div class="col-1"> : </div>
                                    <div class="col-6"><label for="" class="text-info">{{ date('d M Y', strtotime($po->due_date)); }}</label></div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-5">Status</div>
                                <div class="col-1"> : </div>
                                <div class="col-6"><label for=""class="badge {{ $po->status?'badge-success':'badge-danger' }}">{{$po->status?'Lunas':'Belum lunas' }}</label></div>
                            </div>
                            @if (($po->payment_type!='lunas') && ($po->status))
                                <div class="row">
                                    <div class="col-5">Tgl Pembayaran</div>
                                    <div class="col-1"> : </div>
                                    <div class="col-6"><label for="" class="text-info">{{ date('d M Y', strtotime($po->payment_date)); }}</label></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    @if ($po->tax_in_price)
                        <div class="row">
                            <div class="col-5">DPP</div>
                            <div class="col-1"> : </div>
                            <div class="col-1"> Rp. </div>
                            <div class="col-5 text-right"><label for="">{{ number_format($po->dpp, 0, ',', ',') }}</label></div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-5">Subtotal</div>
                            <div class="col-1"> : </div>
                            <div class="col-1"> Rp. </div>
                            <div class="col-5 text-right"><label for="">{{ number_format($po->subtotal, 0, ',', ',') }}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-5">Discount Extra</div>
                            <div class="col-1"> : </div>
                            <div class="col-1"> Rp. </div>
                            <div class="col-5 text-right"><label for="">{{ number_format($po->discount_extra, 0, ',', ',') }}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-5">Total</div>
                            <div class="col-1"> : </div>
                            <div class="col-1"> Rp. </div>
                            <div class="col-5 text-right"><label for="">{{ number_format($po->amount, 0, ',', ',') }}</label></div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-5">PPN ({{ $po->tax }}%)</div>
                        <div class="col-1"> : </div>
                        <div class="col-1"> Rp. </div>
                        <div class="col-5 text-right"><label for="">{{ number_format($po->tax_paid, 0, ',', ',') }}</label></div>
                    </div>
                    <div class="row">
                        <div class="col-5">Total Faktur</div>
                        <div class="col-1"> : </div>
                        <div class="col-1"> Rp. </div>
                        <div class="col-5 text-right"><label for="">{{ number_format($po->total_amount, 0, ',', ',') }}</label></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="">Detail Transaksi</label>
        </div>
    </div>
    @if (count($po->details)>0)
        @forEach($po->details as $detail)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="m-0 p-0">Group Stok</p>
                                    <p  class="m-0 p-0">
                                        <label for="">{{ $detail->stock->name??'---' }}</label>
                                    </p>
                                </div>
                                <div class="col text-center">
                                    <p class="m-0 p-0">Satuan</p>
                                    <p  class="m-0 p-0">
                                        <label for="">{{ $detail->convertion }} / {{ $detail->uom->name??'---' }}</label>
                                    </p>
                                </div>
                                <div class="col text-center">
                                    <p class="m-0 p-0">Qty</p>
                                    <p  class="m-0 p-0">
                                        <label for="">{{ number_format($detail->qty, 0, ',', ',') }}</label>
                                    </p>
                                </div>
                                <div class="col text-center">
                                    <p class="m-0 p-0">Harga Satuan</p>
                                    <p  class="m-0 p-0">
                                        <label for="">Rp. {{ number_format($detail->price_per_pcs, 0, ',', ',') }}</label>
                                    </p>
                                </div>
                                <div class="col text-center">
                                    <p class="m-0 p-0">Subtotal</p>
                                    <p  class="m-0 p-0">
                                        <label for="">Rp. {{ number_format($detail->subtotal, 0, ',', ',') }}</label>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            @if (count($detail->detail_modals)>0)
                                <ul>
                                    @forEach($detail->detail_modals as $modal)
                                    <li>
                                        <div class="row">
                                            <div class="col">
                                                <label class="m-0 p-0" >{{ Str::upper($modal->product->name) }}</label>
                                                <p class="m-0 p-0">SKU : <span class="m-0 p-0" >{{ $modal->product->barcode }}</span></p>
                                            </div>
                                            <div class="col text-center">
                                                <div class="m-0 p-0" >Satuan</div>
                                                <p class="m-0 p-0"><label for="">{{ $modal->product->convertion }}/{{ $modal->product->uom->name??"--" }}</label></p>
                                            </div>
                                            <div class="col text-center">
                                                <div class="m-0 p-0" >Modal <small>(DPP + Pajak)</small></div>
                                                <p class="m-0 p-0">
                                                    <small class="m-0 p-0">{{ number_format($modal->dpp, 0, ',', ',') }}+{{ number_format($modal->tax_paid, 0, ',', ',') }}</small>
                                                </p>
                                                <p class="m-0 p-0"><label for="">Rp. {{ number_format($modal->modal, 0, ',', ',') }}</label></p>
                                            </div>
                                            <div class="col text-center">
                                                <div class="m-0 p-0" >Harga lama</small></div>
                                                <p class="m-0 p-0"><label for="">Rp. {{ number_format($modal->current_price, 0, ',', ',') }}</label></p>
                                            </div>
                                            <div class="col text-center">
                                                <div class="m-0 p-0" >Harga Baru</small></div>
                                                <p class="m-0 p-0"><label for="">Rp. {{ number_format($modal->new_price, 0, ',', ',') }}</label></p>
                                            </div>
                                        </div>
                                        @if(!($loop->last))
                                            <hr style="margin: 0px !important;">
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <label for="" id="label-no-data" class="d-none"> Tidak Ada Data </label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <label for="" id="label-no-data" class="d-none"> Tidak Ada Data </label>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
</div>

@endsection

@section('content-script')
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function(){
        $('a[data-widget="pushmenu"]').click()
    })
</script>
@endsection
