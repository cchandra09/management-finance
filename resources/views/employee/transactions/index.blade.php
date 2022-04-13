@extends('layouts.employee.app')
@section('title')
HIPHOP - TRANSACTION
@endsection
@section('content')

<div class="content-body">
    <section id="dashboard-analytics">
        <div class="row match-height">
            <div class="col-lg-12">
                <div class="card" style="padding: 25px;">
                    <form action="{{route('employee.transaction')}}" method="get">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="month" id="basicSelect">
                                        <option value="01">Januari</option>
                                        <option value="02">Febuari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="year" id="basicSelect">
                                        @foreach(getYears() as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-m">Lihat Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <div class="col-lg-4 col-sm-2 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="dollar-sign" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">Rp{{$transactionPurcashePrice}}</h2>
                        <p class="card-text">Transaksi Masuk Pembelian</p>
                    </div>
                    <div id="gained-chart"></div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-2 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="dollar-sign" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">Rp{{$transactionSalePrice}}</h2>
                        <p class="card-text">Transaksi Masuk Penjualan</p>
                    </div>
                    <div id="order-chart"></div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-2 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="dollar-sign" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">Rp{{$differenceTransaction}}</h2>
                        <p class="card-text">Selisih Transaksi</p>
                    </div>
                    <div id="order-chart"></div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-2 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="dollar-sign" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">Rp{{$tranactionAssetFirst}}</h2>
                        <p class="card-text">5% Pendapatan</p>
                    </div>
                    <div id="order-chart"></div>
                </div>
            </div>
        </div>
    </section>
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Data Transaksi</h4>
                        <a href="{{route('employee.transaction.create')}}" class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" data-repeater-create="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add New</span>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>Status</th>
                                    <th>Makanan</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($transaction) < 1)
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endif
                                @foreach($transaction as $item)
                                    <tr>
                                        <td>{{$item->date_transaction}}</td>
                                        <td>@if($item->status == "1") <span class="badge badge-pill badge-light-success mr-1">Masuk</span> @else <span class="badge badge-pill badge-light-danger mr-1">Keluar</span> @endif</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->total}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item" href="{{route('employee.transaction.edit', $item->id)}}">
                                                        <i data-feather="edit-2" class="mr-50"></i>
                                                        <span>Edit</span>
                                                    </a> --}}
                                                    <a class="dropdown-item" data-toggle="modal" href="#deleteModalTransaction-{{$item->id}}">
                                                        <i data-feather="trash" class="mr-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="animated">
    @foreach ($transaction as $item)    
        <div class="modal fade" id="deleteModalTransaction-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
            data-backdrop="static" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel">Hapus Data Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah Anda yakin ingin menghapus data ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                        document.getElementById('deleteTransaction-{{$item->id}}').submit();">Confirm</button>
                    <form action="{{route('employee.transaction.delete', $item->id)}}" style="display: none" id="deleteTransaction-{{$item->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
@section('scripts')

@endsection