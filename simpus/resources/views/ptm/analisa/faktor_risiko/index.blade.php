@extends('layouts.table_ptm')
@section('title', 'Hasil Anamnesa Deteksi Dini Faktor Risiko PTM')
@section('judultable', 'Hasil Anamnesa Deteksi Dini Faktor Risiko PTM')
{{-- @section('subjudul', '(Hasil Anamnesa Deteksi Dini Faktor Risiko PTM)') --}}
@section('menu1', 'Analisa')
@section('menu2', 'Hasil Anamnesa Deteksi Dini Faktor Risiko PTM')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Grafik Hasil Anamnesa Deteksi Dini Faktor Risiko PTM</h3>
                        </div>
                        <div class="ibox-tools">

                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl mt-3">
                    <div class="d-flex">
                        <div class="p-0">
                            <div class="form-group col-md" id="periode_bln">
                                <p class="font-bold">Periode Komulatif</p>
                                <div class="input-group date">
                                    <span class="input-group-addon px-3 bg-primary rounded-left"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-group-addon rounded-right py-2"
                                        name="periode" id="periode" name="periode" autocomplete="off" value="Apr-2022">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-sm">
                        <div class="row">
                            <div class="col-md-12 px-2 pb-4">
                                <canvas id="bar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @push('scripts')
        <script type="text/javascript">
            $('#periode_bln .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true,
                format: "M-yyyy"
            });
            const data = {
                labels: ['JUMLAH HADIR','MEROKOK','KURANG AKTIFITAS FISIK','DIET TIDAK SEIMBANG','KONSUMSI ALKOHOL'],
                datasets: [
                    {
                        label: '',
                        data: [5,5,3,6,3,2],
                        backgroundColor: [
                            '#1ab32c',
                            '#73b31a',
                            '#efc82d',
                            '#f79d3c',
                            '#ea394c',
                        ],
                        borderColor: [
                        ],
                        borderWidth: 1
                    }
                ]
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    legend: {
                        display: false,
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Grafik Analisa Hasil Anamnesa Deteksi Dini Faktor Risiko PTM'
                    },
                    layout: {
                        padding: {
                            top: 32,
                            right: 16,
                            bottom: 16,
                            left: 8
                        }
                    },
                    scales: {
                        x: {
                            grid : {
                                display : false,
                            },
                            stacked: false,
                        },
                        y: {
                            ticks : {
                                color : '#000',
                            },
                            stacked: false,
                        }
                    }
                },
            };
            const ctx = document.getElementById('bar-chart');
            const myChart = new Chart(ctx, config);

        </script>
        @endpush
