@extends('layouts.table_ptm')
@section('title', 'Temuan IVA (+) dan Tindakan Kriotherapi')
@section('judultable', 'Temuan IVA (+) dan Tindakan Kriotherapi')
{{-- @section('subjudul', '(Temuan IVA (+) dan Tindakan Kriotherapi)') --}}
@section('menu1', 'Analisa')
@section('menu2', 'Temuan IVA (+) dan Tindakan Kriotherapi')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Grafik Temuan IVA (+) dan Tindakan Kriotherapi</h3>
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
                labels: ['Usia < 30 Tahun','Usia 30 - 39 Tahun','Usia 40 - 50 Tahun','Usia > 50 Tahun'],
                datasets: [
                    {
                        label: ' IVA (+) ',
                        data: [12,5,1,5],
                        backgroundColor: '#ea394c',
                        borderRadius: 5,
                        borderWidth: 1
                    },
                    {
                        label: ' Krioterapi ',
                        data: [2,4,6,3,],
                        backgroundColor:'#007bff',
                        borderRadius: 5,
                        borderWidth: 1
                    },
                ]
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                        // position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Grafik Analisa Temuan IVA (+) dan Tindakan Kriotherapi'
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
