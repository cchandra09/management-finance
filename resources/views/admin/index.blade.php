@extends('layouts.admin.app')
@section('title')
HIPHOP - DASHBOARD
@endsection
@section('content')
<section id="dashboard-analytics">
    <div class="row match-height">
        <div class="col-lg-3 col-sm-2 col-12">
            <div class="card">
                <div class="card-header flex-column align-items-start pb-0">
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="dollar-sign" class="font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bolder mt-1">Rp{{$transactionPurcashePrice}}</h2>
                    <p class="card-text">Transaksi Masuk Harga Beli</p>
                </div>
                <div id="gained-chart"></div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-2 col-12">
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
        <div class="col-lg-2 col-sm-2 col-12">
            <div class="card">
                <div class="card-header flex-column align-items-start pb-0">
                    <div class="avatar bg-light-warning p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="dollar-sign" class="font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bolder mt-1">Rp{{$differenceTransaction}}</h2>
                    <p class="card-text">Pendapatan</p>
                </div>
                <div id="order-chart"></div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-12">
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
<div class="content-body">
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Data Transaksi</h4><br>
                        <h3>Total Transaksi : {{count($transaction)}}</h3>
                    </div>
                    
                    {{-- <div class="content-body"> --}}
                        <table class="table table-responsive" id="datatables1">
                            <thead>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>Status</th>
                                    <th>Makanan</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($transaction) < 1)
                                    <tr>
                                        <td colspan="6">Tidak Ada Data</td>
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
                                        <td>{{$item->User->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')

@endsection