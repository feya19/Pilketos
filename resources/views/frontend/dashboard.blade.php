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
                        @if (strtotime(date('Y-m-d H:i')) >= $open && strtotime(date('Y-m-d H:i')) <= $close)
                                <p>Silahkan Klik Tombol Dibawah Ini Untuk Melaksanakan Pemilihan!.</p>
                                <a href="{{ route('voting') }}" class="btn btn-primary">Voting Sekarang</a>
                        @elseif(strtotime(date('Y-m-d H:i')) < $open)
                            <p>Pilketos Akan Dilaksanakan Pada Tanggal {{ $vote_date_start }} {{ $vote_open }} - {{ $vote_date_end }} {{ $vote_closed }}.</p>
                        @elseif(strtotime(date('Y-m-d H:i')) > $close)
                            <p>Pilketos Telah Dilaksanakan Pada Tanggal {{ $vote_date_start }} {{ $vote_open }} - {{ $vote_date_end }} {{ $vote_closed }}.</p>
                        @else
                            <p>Pilketos Telah Ditutup Pada Tanggal {{ $vote_date_end }} Jam {{ $vote_closed }}.</p>
                            <p>Silahkan Buka Halaman Hasil Untuk Mengetahui Siapa Pasangan Yang Jadi Pemenangnya.</p>
                        @endif
                    @else
                        <p>Terimakasih, Kamu Telah Mengirimkan Suaramu!</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input type="hidden" name="pemilih" value="1">
                            <button class="btn btn-danger" onclick="event.preventDefault();
                            this.closest('form').submit();">Logout</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
