@extends('layouts.master_ptm')
<style>
    .element {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@section('title', 'Beranda PTM')
@section('konten_ptm')

<!-- content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content b-r-xl">
                    <div>
                        <h5>Jumlah Deteksi Dini Faktor Risiko</h5>
                        <div class="row">
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Merokok</p>
                            </div>
                            <div class="col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Kurang Aktifitas Fisik</p>
                            </div>
                            <div class=" col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Diet Tidak Seimbang</p>
                            </div>
                            <div class=" col-lg text-center">
                                <h3>0</h3>
                                <p class="element">Konsumsi
                                    Alkohol</p>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <p>Total</p>
                        <div class="row">
                            <div class="col-lg-2 my-auto">
                                <button class="btn btn-primary btn-lg" type="button"><i class="fa fa-user"></i>
                                </button>
                            </div>
                            <div class="col-lg">
                                <h2 class="">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title b-r-xl bg-primary">
                    <div class="d-flex w-25">
                        <div class="my-auto">
                            <p class="font-bold">Periode</p>
                        </div>
                        <div class="p-2">
                            <div class="form-group col-md row" id="periode_bln">
                                <div class="input-group date">
                                    <input type="text" class="form-control input-group-addon rounded py-2"
                                        style="color: black" name="periode" id="periode" name="periode"
                                        autocomplete="off" value="Apr-2022">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl mt-2">
                    <h3 class="pb-4">Grafik Kasus Penyakit Tidak Menular</h3>

                    <div class="p-2">
                        <canvas id="myChart" height="140"></canvas>
                    </div>
                </div>
                <div class="ibox-content b-r-xl mt-2">
                    <h3 class="pb-4">Grafik Kasus Gangguan Jiwa</h3>
                    <div class="p-2">
                        <canvas id="myChart2" height="140"></canvas>
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

<!-- Data picker -->
<script src="{{ asset('/inspinia/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

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
        $('#periode_bln .input-group.date').datepicker({
            minViewMode: 1,
            keyboardNavigation: false,
            forceParse: false,
            forceParse: false,
            autoclose: true,
            todayHighlight: true,
            format: "M-yyyy"
        });

        table = $('#table1').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [],
        });
    });

    const data = {
        labels: ['IMA', 'DECOMP. CORDIS', 'HIPERTENSI', 'STROKE', 'DM TGT INSULIN', 'DM TAK TGT INSULIN','CA MAMMAE','CA SERVIKS','LEUKIMIA','RETINIBLASTOMA','CA KOLORECTAL','TALASEMIA','PPOK','ASMA BRONKHIALE','GAGAL GINJAL KRONIK','OSTEOPOROSIS','OBESITAS'],
        datasets: [
            {
                label: 'Laki-laki',
                data: [6,3,8,3,12, 19, 3, 5, 7, 3,7,3,2,3,1,6,9,],
                backgroundColor: '#1ab394',
                borderColor: [
                ],
                borderWidth: 1,
                borderRadius: 5,
            },
            {
                label: 'Perempuan',
                data: [6,3,7,3,2,3,1,6,9,8,3,12, 19, 3, 5, 7, 3],
                backgroundColor: '#ed5565',
                borderColor: [
                ],
                borderWidth: 1,
                borderRadius: 5,
            }
        ]
    };
    const data2 = {
        labels: ['DEMENSIA F00', 'GANGGUAN ANSIETAS F.4', 'GANGGUAN CAMPURAN ANSIETAS DAN DEPRESI F41.2', 'GANGGUAN DEPRESI F.32 dan F33', 'GANGGUAN PENYALAHGUNAAN NAPZA F10 - F19', 'GANGGUAN PERKEMBANGAN PADA ANAK DAN REMAJA F80-90#','GANGGUAN PSIKOTIK AKUT F23','SKIZOFRENIA F20','GANGGUAN SOMATOFORM F45','INSOMNIA F51.0','PERCOBAAN BUNUH DIRI','REDARTASI MENTAL F.70 - F.79','GANGGUAN KEPRIBADIAN DAN PERILAKU F.60'],
        datasets: [
            {
                label: 'Laki-laki',
                data: [6,3,8,3,12, 13,1,6,9,9,12,8,7],
                backgroundColor: '#1ab394',
                borderColor: [
                ],
                borderWidth: 1,
                borderRadius: 5,
            },
            {
                label: 'Perempuan',
                data: [6,3,9,3,1,5,13,9,9,3,7, 7, 3],
                backgroundColor: '#ed5565',
                borderColor: [
                ],
                borderWidth: 1,
                borderRadius: 5,
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
                display: false,
                text: 'Chart.js Pie Chart'
            }
        },
    };
    const config2 = {
        type: 'bar',
        data: data2,
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
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');
    const myChart = new Chart(ctx, config);
    const myChart2 = new Chart(ctx2, config2);


</script>

@endpush
