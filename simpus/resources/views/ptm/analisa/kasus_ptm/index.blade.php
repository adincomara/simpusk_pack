@extends('layouts.table_ptm')
@section('title', 'Kasus PTM')
@section('judultable', 'Kasus PTM')
{{-- @section('subjudul', '(Kasus PTM)') --}}
@section('menu1', 'Analisa')
@section('menu2', 'Kasus PTM')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Grafik Kasus PTM</h3>
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
                labels: ['IMA','DECOMP. CORDIS','HIPERTENSI','STROKE','DM TGT INSULIN','DM TAK TGT INSULIN','CA MAMMAE','CASERVIKS','LEUKIMIA','RETINIBLASTOMA','CA KOLORECTAL','TALASEMIA','PPOK','ASMA BRONKHIALE','GAGAL GINJAL KRONIK','OSTEOPOROSIS','OBESITAS'],datasets: [{
                    label: '',
                    data: [12,5,1,4,1,2,4,6,3,2,4,5,5,3,6,3,2],
                    backgroundColor: [
                        '#EB5757',
                        '#F2994A',
                        '#F2C94C',
                        '#219653',
                        '#27AE60',
                        '#6FCF97',
                        '#2F80ED',
                        '#56CCF2',
                        '#9B51E0',
                        '#6A6965',
                        '#EB5757',
                        '#F2994A',
                        '#F2C94C',
                        '#219653',
                        '#27AE60',
                        '#6FCF97',
                        '#2F80ED',
                    ],
                    borderColor: [
                    ],
                    borderWidth: 1
                }]
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
                        text: 'Grafik Analisa Kasus PTM'
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
