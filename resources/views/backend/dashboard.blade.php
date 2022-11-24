@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon blue mb-2">
                                <i class="iconly-boldProfile"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Kandidat</h6>
                            <h6 class="font-extrabold mb-0">{{ $data['kandidat'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2">
                                <i class="iconly-boldProfile"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Pemilih</h6>
                            <h6 class="font-extrabold mb-0">{{ $data['pemilih'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldTick-Square"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Sudah Memilih</h6>
                            <h6 class="font-extrabold mb-0" id="sudah_milih">Loading</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon red mb-2">
                                <i class="iconly-boldDanger"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Belum Memilih</h6>
                            <h6 class="font-extrabold mb-0" id="belum_milih">Loading</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h4>Hasil Pilketos</h4>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button class="btn btn-light icon" onclick="getData()"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chartHasil"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('mazer') }}/assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script>
        function chartHasil(data) {
          $('#chartHasil').empty()
            var label = [];
            var jumlah = [];
            var persentase = [];
            for (var i in data) {
                label.push(data[i].name)
                jumlah.push(data[i].jumlah)
                persentase.push(data[i].persentase)
            }
            var optionsChartHasil = {
                series: [{
                    name: 'Vote',
                    type: 'column',
                    color: '#435ebe',
                    data: jumlah
                }, {
                    name: 'Persentase',
                    type: 'line',
                    color: '#198754',
                    data: persentase
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [1, 4]
                },
                title: {
                    text: '',
                    align: 'left',
                    offsetX: 110
                },
                xaxis: {
                    categories: label,
                },
                yaxis: [
                {
                    seriesName: 'Vote',
                    opposite: false,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#435ebe'
                    },
                    labels: {
                        style: {
                            colors: '#435ebe',
                        }
                    },
                    title: {
                        text: "Vote",
                        style: {
                            color: '#435ebe',
                        }
                    },
                },
                {
                    seriesName: 'Persentase',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#198754'
                    },
                    max: 100.00,
                    labels: {
                        style: {
                            colors: '#198754',
                        },
                    },
                    title: {
                        text: "Persentase",
                        style: {
                            color: '#198754',
                        }
                    }
                },
                ],
                tooltip: {
                    fixed: {
                        enabled: true,
                        position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                        offsetY: 30,
                        offsetX: 60
                    },
                },
                legend: {
                    horizontalAlign: 'left',
                    offsetX: 40
                }
            };
            var chartHasil = new ApexCharts(
                document.querySelector("#chartHasil"),
                optionsChartHasil
            )
            chartHasil.render()
        }

        function getData() {
            $('#sudah_milih').text('Loading');
            $('#belum_milih').text('Loading');
            $.ajax({
                url: '{{ route('backend.dashboard.ajax') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#sudah_milih').text(data.pemilih_done);
                    $('#belum_milih').text(data.pemilih_pending);
                    chartHasil(data.hasil)
                }
            });
        }
        $(document).ready(function() {
            getData();
            setInterval(() => {
                getData();
            }, 30000);
        });
    </script>
@endpush
