@extends('layouts.user.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Hi, {{ auth()->user()->name }}
                    </h4>
                    <hr>
                </div>
                <div class="card-body">
                    @if (auth()->user()->kandidat_id == null)
                        @php
                            $open = strtotime($vote_date_start.' '.$vote_open);
                            $close = strtotime($vote_date_end.' '.$vote_closed);
                        @endphp 
                        @if (strtotime(date('Y-m-d H:i')) >= strtotime($open) && strtotime(date('Y-m-d H:i')) <= strtotime($close))
                                <p>Silahkan Klik Tombol Dibawah Ini Untuk Melaksanakan Pemilihan!.</p>
                                <a href="{{ route('voting') }}" class="btn btn-primary">Voting Sekarang</a>
                        @elseif(strtotime(date('Y-m-d H:i')) < strtotime($open))
                            <p>Pilkosis Akan Dilaksanakan Pada Tanggal {{ $vote_date_start }} Jam {{ $vote_open }}.</p>
                        @elseif(strtotime(date('Y-m-d H:i')) > strtotime($close))
                            <p>Pilkosis Telah Dilaksanakan Pada Tanggal {{ $vote_date_end }} Jam {{ $vote_closed }}.</p>
                        @else
                            <p>Pilkosis Telah Ditutup Pada Tanggal {{ $vote_date_end }} Jam {{ $vote_closed }}.</p>
                            <p>Silahkan Buka Halaman Hasil Untuk Mengetahui Siapa Pasangan Yang Jadi Pemenangnya.</p>
                        @endif
                    @else
                        <p>Terimakasih, Kamu Telah Mengirimkan Suaramu!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
