@extends('layouts.admin.app')
@section('title')
HIPHOP - DASHBOARD
@endsection
@section('content')
<section id="dashboard-analytics">
    <div class="row match-height">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card card-congratulations">
                <div class="card-body text-center">
                    <img src="../../../app-assets/images/elements/decore-left.png" class="congratulations-img-left" alt="card-img-left" />
                    <img src="../../../app-assets/images/elements/decore-right.png" class="congratulations-img-right" alt="card-img-right" />
                    <div class="avatar avatar-xl bg-primary shadow">
                        <div class="avatar-content">
                            <i data-feather="award" class="font-large-1"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="mb-1 text-white">Congratulations {{Auth::user()->name;}},</h1>
                        <p class="card-text m-auto w-75">
                            Kita Mendapatkan Profit <strong>{{round($percentage)}}%</strong> Pada Penjualan Bulan ini
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-2 col-12">
            <div class="card">
                <div class="card-header flex-column align-items-start pb-0">
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather="dollar-sign" class="font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bolder mt-1">Rp{{$transactionIn}}</h2>
                    <p class="card-text">Transaksi Masuk</p>
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
                    <h2 class="font-weight-bolder mt-1">Rp{{$transactionOut}}</h2>
                    <p class="card-text">Transaksi Keluar</p>
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
                        <a href="{{route('employee.transaction.create')}}" class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" data-repeater-create="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add New</span>
                        </a>
                    </div>
                    
                    <div class="card-datatable">
                        <table class="datatables-ajax table">
                            <thead>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction as $item)
                                    <tr>
                                        <td>{{$item->date_transaction}}</td>
                                        <td>{{$item->amount}}</td>
                                        <td>@if($item->status == "1") <span class="badge badge-pill badge-light-success mr-1">Masuk</span> @else <span class="badge badge-pill badge-light-danger mr-1">Keluar</span> @endif</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{$item->Category->name}}</td>
                                        <td>{{$item->User->name}}</td>
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
@endsection
@section('scripts')

@endsection