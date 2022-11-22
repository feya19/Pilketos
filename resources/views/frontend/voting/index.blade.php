<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $app_name }}</title>
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/main/app.css" />
    <link rel="stylesheet" href="{{ asset('css') }}/app.css"/>
    <link rel="shortcut icon" href="{{ asset('mazer') }}/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('mazer') }}/assets/images/logo/favicon.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/extensions/sweetalert2/sweetalert2.min.css" />
</head>

<body>
    <div id="app">

       <div class="container">
        <div class="row pt-4">
            <div class="col-md-12 text-center mb-3">
                <h2>Silahkan Pilih Kandidat Pilihanmu</h2>
            </div>
            <div class="col-md-12">
                <div class="row d-flex justify-content-center">
                    @foreach ($data['kandidat'] as $kandidat)
                        @php
                            $visi = json_encode(explode('| ', $kandidat->visi));
                            $misi = json_encode(explode('| ', $kandidat->misi));
                            $name = explode('-', $kandidat->name);
                        @endphp    
                        <div class="col-md-4 px-3">
                            <div class="card">
                                <div class="card-content">
                                    <img class="img-fluid w-100" src="{{ $kandidat->photo_path }}" alt="Card image cap">
                                    <a class="card-nomor h3">{{ $kandidat->nomor_urut }}</a>
                                    <a class="card-kelas h3">{{ $name[1] ?? $kandidat->name }}</a>
                                    <div class="card-body pb-0">
                                        <h4 class="card-title text-center pt-2">{{ $name[0] ?? '' }}</h4>
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
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close" disabled>
                        <i data-feather="x"></i>
                    </button>
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
<script src="{{ asset('mazer') }}/assets/js/bootstrap.js"></script>
<script src="{{ asset('mazer') }}/assets/js/app.js"></script>
<script src="{{ asset('mazer') }}/assets/extensions/jquery/jquery.min.js"></script>
<script src="{{ asset('mazer') }}/assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script>
        function konfirmasi(url) {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Memilih Pasangan Ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Ya, Pilih !",
                cancelButtonText: "Tidak.",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
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
</html>
