@extends('layouts.employee.app')
@section('title')
HIPHOP - TAMBAH TRANSAKSI
@endsection
@section('content')

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{route('employee.transaction.store')}}" method="POST">
                            <div class="row">
                                @csrf
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Tanggal Transaksi</label>
                                        <input type="text" id="fp-default" name="date_transaction" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Kategori</label>
                                        <select class="form-control" name="category_id" id="basicSelect">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="amount">Nominal</label>
                                        <input type="text" id="amount" name="amount" class="form-control" placeholder="Nominal" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="last-name-column">Status</label>
                                            <select class="form-control" name="status" id="basicSelect">
                                                <option>-- Pilih Status --</option>
                                                <option value="1">Masuk</option>
                                                <option value="0">Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Deskripsi</label>
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Textarea"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Email</label>
                                        <input type="email" id="email-id-column" class="form-control" name="email-id-column" placeholder="Email" />
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')

@endsection