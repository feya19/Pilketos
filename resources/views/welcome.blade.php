@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        <div class="row" style="padding-bottom: 2.5rem;padding-top: 2.5rem;">
            <div class="col-md-7 pt-md-5 mb-3 text-center text-md-start">
                <h1 class="text-uppercase mb-3">Selamat Datang Di E-Pemilu</h1>
                <h4 class="mb-3">Mari Kita Sukseskan Pemilihan Umum Bupati Kabupaten Tulungagung</h4>
                <a href="#row-paslon" class="btn btn-outline-primary rounded-pill">Lihat Paslon</a>
            </div>
            <div class="col-md-5">
                <img src="{{ asset('image/clip-voting.gif') }}" alt="" srcset="" class="w-100">
            </div>
        </div>
        <div class="row mt-5 pt-4" id="row-paslon">
            <div class="col-md-12 text-center mb-5">
                <h2>Daftar Calon Bupati</h2>
            </div>
            <div class="col-md-12">
                <div class="row d-flex justify-content-center">
                    @foreach ($data['kandidat'] as $kandidat)
                        @php
                            $visi = json_encode(explode('| ', $kandidat->visi));
                            $misi = json_encode(explode('| ', $kandidat->misi));
                        @endphp    
                        <div class="col-md-4 px-3">
                            <div class="card">
                                <div class="card-content">
                                    <img class="img-fluid w-100" src="{{ $kandidat->photo_path }}" alt="Card image cap">
                                    <a class="card-nomor h3">{{ $kandidat->nomor_urut }}</a>
                                    <div class="card-body pb-0">
                                        <h6 class="text-center pt-2">{{ $kandidat->name }}</h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-primary btn-block"  data-bs-toggle="modal"
                                    data-bs-target="#default"
                                    data-visi="{{ $visi }}"
                                    data-misi="{{ $misi }}"
                                    data-title="{{ $name[0] ?? $kandidat->name }}"
                                    >Visi & Misi</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <!--Basic Modal -->
    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1"></h5>
                </div>
                <div class="modal-body">
                    <h6>Visi :</h6>
                    <ol id="visi"></ol>
                    <h6>Misi :</h6>
                    <ol id="misi"></ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(() => {
        $('button[data-bs-toggle="modal"]').prop('disabled', false);
        $('#default').on('show.bs.modal', function(e) {
            var visi = $(e.relatedTarget).data('visi');
            var misi = $(e.relatedTarget).data('misi');
            var title = $(e.relatedTarget).data('title');
            $('#myModalLabel1').text(`Visi Misi ${title}`);
            $('#visi,#misi').html('');
            $.each(visi, (i, v) => {
                $('#visi').append(`<li>${v}</li>`);
            });
            $.each(misi, (i, v) => {
                $('#misi').append(`<li>${v}</li>`);
            })
        });
    })
</script>
@endpush