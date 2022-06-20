@extends('layouts.master_kia')
<style>
    .element {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@section('title', 'Beranda KIA')
@section('konten_kia')

<!-- content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class=" col-lg-4">
            <div class="ibox">
                <div class="ibox-content b-r-xl">
                    <div>
                        <h5>Jumlah Sasaran</h5>
                        <div class="row">
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Laki-laki</p>
                            </div>
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p>Peremepuan</p>
                            </div>
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p>Total</p>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <p>Total Penduduk</p>
                        <div class="row">
                            <div class="col-lg-2 my-auto">
                                <button class="btn btn-primary btn-lg" type="button"><i class="fa fa-users"></i>
                                </button>
                            </div>
                            <div class="col-lg">
                                <h2 class="">0</h2>
                            </div>
                            <div class="col-lg text-right my-auto">
                                <button class="btn btn-danger btn-circle btn-sm btn-outline" type="button"><i
                                        class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content b-r-xl">
                    <div>
                        <h5>Jumlah Penduduk Semua Wilayah</h5>
                        <div class="row">
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Bumil</p>
                            </div>
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p>Bulin</p>
                            </div>
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p>Bayi</p>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <p>Total Sasaran</p>
                        <div class="row">
                            <div class="col-lg-2 my-auto">
                                <button class="btn btn-primary btn-lg" type="button"><i class="fa fa-star"></i>
                                </button>
                            </div>
                            <div class="col-lg">
                                <h2 class="">0</h2>
                            </div>
                            <div class="col-lg text-right my-auto">
                                <button class="btn btn-danger btn-circle btn-sm btn-outline" type="button"><i
                                        class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content b-r-xl">
                    <div>
                        <h5>Order Statistics</h5>
                        <div class="row">
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Remaja 10 - 14 Th</p>
                            </div>
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Remaja Usia 15 - &lt;18 </p>
                            </div>
                            <div class=" col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Total Remaja</p>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <p>Total Remaja</p>
                        <div class="row">
                            <div class="col-lg-2 my-auto">
                                <button class="btn btn-primary btn-lg" type="button"><i class="fa fa-user"></i>
                                </button>
                            </div>
                            <div class="col-lg">
                                <h2 class="">0</h2>
                            </div>
                            <div class="col-lg text-right my-auto">
                                <button class="btn btn-danger btn-circle btn-sm btn-outline" type="button"><i
                                        class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-title b-r-xl bg-primary">
                    <h5>Grafik PWS K4 Ibu Periode <span> 04-2022 </span></h5>
                </div>
                <div class="ibox-content b-r-xl mt-2">
                    <div class="d-flex w-25">
                        <div class="p-2 my-auto">
                            <p>Periode</p>
                        </div>
                        <div class="p-2">
                            <div class="form-group col-md row" id="periode_bln">
                                <div class="input-group date">
                                    <input type="text" class="form-control input-group-addon rounded py-2"
                                        name="periode" id="periode" name="periode" autocomplete="off" value="Apr-2022">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <canvas id="myChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4    ">
            <div class="ibox">
                <div class="ibox-title b-r-xl bg-primary">
                    <h5>Top Teratas 10 PWS Persalinan Periode <span> 04-2022 </span></h5>
                </div>
                <div class="ibox-content b-r-xl mt-2">
                    <div>
                        <canvas id="pieChart1" height="140"></canvas>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title b-r-xl bg-primary">
                    <h5>Top Terbawah 10 PWS Persalinan Periode <span> 04-2022 </span></h5>
                </div>
                <div class="ibox-content b-r-xl mt-2">
                    <div>
                        <canvas id="pieChart2" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl bg-primary">
                    <h5>Tabel PWS K4 Ibu Tahun 2022</h5>
                </div>
                <div class="ibox-content b-r-xl mt-2">
                    <div class="table-responsive">
                        <table id="table1" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Puskesmas</th>
                                    <th>Januari</th>
                                    <th>Februari</th>
                                    <th>Maret</th>
                                    <th>April</th>
                                    <th>Mei</th>
                                    <th>Juni</th>
                                    <th>Juli</th>
                                    <th>Agustus</th>
                                    <th>September</th>
                                    <th>Oktober</th>
                                    <th>November</th>
                                    <th>Desember</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Jepang</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- end content -->
@endsection
@push('scripts')

<!-- Mainly scripts -->
<script src="{{ asset('/inspinia/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('/inspinia/js/popper.min.js') }}"></script>
<script src="{{ asset('/inspinia/js/bootstrap.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Flot -->
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.spline.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.time.js') }}"></script>

<!-- Peity -->
<script src="{{ asset('/inspinia/js/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('/inspinia/js/demo/peity-demo.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/inspinia/js/inspinia.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/pace/pace.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('/inspinia/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Jvectormap -->
<script src="{{ asset('/inspinia/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- EayPIE -->
<script src="{{ asset('/inspinia/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('/inspinia/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Sparkline demo data  -->
<script src="{{ asset('/inspinia/js/demo/sparkline-demo.js') }}"></script>

<!-- ChartJS-->
<script src="{{ asset('/inspinia/js/plugins/chartJs/Chart.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('/inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('/inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('/inspinia/js/plugins/fullcalendar/moment.min.js')}}"></script>

<!-- Date range picker -->
<script src="{{ asset('/inspinia/js/plugins/daterangepicker/daterangepicker.js')}}"></script>

<!-- Datalables -->
<script src="{{ asset('/inspinia/js/plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js')}}"></script>
<script src="{{ asset('/inspinia/js/plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js')}}"></script>
<script>
    import {Chart} from 'chart.js';
        import ChartDataLabels from 'chartjs-plugin-datalabels';
</script>


<script>
    $(document).ready(function () {
        table = $('#table1').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [],
        });
    });

    const data = {
        labels: ['Puskesmas1', 'Puskesmas2', 'Puskesmas3', 'Puskesmas3', 'Puskesmas4', 'Puskesmas5'],
        datasets: [{
            label: 'Dataset',
            data: [12, 19, 3, 5, 2, 3],
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
            ],
            borderColor: [
            ],
            borderWidth: 1
        }]
    };
    const data2 = {
        labels: ['Puskesmas1', 'Puskesmas2', 'Puskesmas3', 'Puskesmas3', 'Puskesmas4', 'Puskesmas5'],
        datasets: [{
            label: 'Dataset',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                '#27AE60',
                '#6FCF97',
                '#2F80ED',
                '#56CCF2',
                '#9B51E0',
                '#EB5757',
                '#F2994A',
                '#F2C94C',
                '#219653',
                '#6A6965',
            ],
            borderColor: [
            ],
            borderWidth: 1
        }]
    };
    const data3 = {
        labels: ['Puskesmas1', 'Puskesmas2', 'Puskesmas3', 'Puskesmas3', 'Puskesmas4', 'Puskesmas5'],
        datasets: [{
            label: 'Dataset',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                '#F2994A',
                '#F2C94C',
                '#219653',
                '#27AE60',
                '#6FCF97',
                '#2F80ED',
                '#56CCF2',
                '#9B51E0',
                '#EB5757',
                '#6A6965',
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
                display: false,
                text: 'Chart.js Pie Chart'
            }
        },
    };
    const config2 = {
        type: 'pie',
        data: data2,
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: false,
                text: 'Chart.js Pie Chart'
            }
        },
    };
    const config3 = {
        type: 'pie',
        data: data3,
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: false,
                text: 'Chart.js Pie Chart'
            }
        },
    };
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('pieChart1');
    const ctx3 = document.getElementById('pieChart2');
    const myChart = new Chart(ctx, config);
    const pieChart1 = new Chart(ctx2, config2);
    const pieChart2 = new Chart(ctx3, config3);


</script>

@endpush
