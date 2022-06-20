@extends('layouts.master')
@section('title', 'Beranda')
@section('konten')

            <!-- content -->
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-sm">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Pasien Pelayanan Poli Umum</h5>
                                        <h1 class="no-margins">40 886</h1>
                                        <small class=" rounded p-1">Total</small>
                                    </div>
                                    <a href="#" class=" my-auto pr-3">
                                        <i class="fa fa-info-circle fa-5x text-info" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Pasien Pelayanan Poli Gigi</h5>
                                        <h1 class="no-margins">40 886</h1>
                                        <small class=" rounded p-1">Total</small>
                                    </div>
                                    <a href="#" class=" my-auto pr-3">
                                        <i class="fa fa-info-circle fa-5x text-info" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Pasien Pelayanan Poli KIA</h5>
                                        <h1 class="no-margins">40 886</h1>
                                        <small class=" rounded p-1">Total</small>
                                    </div>
                                    <a href="#" class=" my-auto pr-3">
                                        <i class="fa fa-info-circle fa-5x text-info" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Pasien Pelayanan Poli MTBS </h5>
                                        <h1 class="no-margins">40 886</h1>
                                        <small class=" rounded p-1">Total</small>
                                    </div>
                                    <a href="#" class=" my-auto pr-3">
                                        <i class="fa fa-info-circle fa-5x text-info" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Pasien Pelayanan Poli Konsultasi</h5>
                                        <h1 class="no-margins">40 886</h1>
                                        <small class=" rounded p-1">Total</small>
                                    </div>
                                    <a href="#" class=" my-auto pr-3">
                                        <i class="fa fa-info-circle fa-5x text-info" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Kunjungan Pasien</h5>
                                <div class="float-right">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-xs btn-primary btn-outline waktu active " onclick="changetime(this.name)" name="0">Mingguan</button>
                                        <button type="button"
                                            class="btn btn-xs btn-primary btn-outline waktu" onclick="changetime(this.name)" name="1">Bulanan</button>
                                        <button type="button"
                                            class="btn btn-xs btn-primary btn-outline waktu" onclick="changetime(this.name)" name="2">Tahunan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <canvas id="lineChart" height="140"></canvas>
                                    </div>
                                    <div class="col-lg-3">
                                        <ul class="stat-list">
                                            <li>
                                                <h2 class="no-margins">2,346</h2>
                                                <small>Total Pasien Berkunjung</small>
                                                <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i>
                                                </div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 48%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 class="no-margins ">4,422</h2>
                                                <small>Total Pasien Dirujuk</small>
                                                <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i>
                                                </div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 60%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 class="no-margins ">9,180</h2>
                                                <small>Total Pasien Pulang</small>
                                                <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i>
                                                </div>
                                                <div class="progress progress-mini">
                                                    <div style="width: 22%;" class="progress-bar"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Obat Kadaluarsa</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content table-responsive">
                                        <table class="table table-hover no-margins" id="table_obat_kadaluarsa">
                                            <thead>
                                                <tr>
                                                    <th>Obat</th>
                                                    <th>Value</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Parasetamol</td>
                                                    <td> 66 </td>
                                                    <td><i class="fa fa-clock-o"></i> 11/01/2015</td>
                                                    <td><span class="label label-danger">Kadaluarsa</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>Parasetamol</td>
                                                    <td> 66 </td>
                                                    <td><i class="fa fa-clock-o"></i> 11/01/2015</td>
                                                    <td><span class="label label-danger">Kadaluarsa</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>Parasetamol</td>
                                                    <td> 66 </td>
                                                    <td><i class="fa fa-clock-o"></i> 11/01/2015</td>
                                                    <td><span class="label label-danger">Kadaluarsa</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>Parasetamol</td>
                                                    <td> 66 </td>
                                                    <td><i class="fa fa-clock-o"></i> 11/01/2015</td>
                                                    <td><span class="label label-danger">Kadaluarsa</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>Parasetamol</td>
                                                    <td> 66 </td>
                                                    <td><i class="fa fa-clock-o"></i> 11/01/2015</td>
                                                    <td><span class="label label-danger">Kadaluarsa</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>Parasetamol</td>
                                                    <td> 66 </td>
                                                    <td><i class="fa fa-clock-o"></i> 11/01/2015</td>
                                                    <td><span class="label label-danger">Kadaluarsa</span> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Stok Obat yang Tersedia</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content table-responsive">
                                        <table class="table table-hover no-margins" id="table_stok_obat">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jenis Obat</th>
                                                    <th>Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> H1DN</td>
                                                    <td>Parasetamol</td>
                                                    <td>Puseng</td>
                                                    <td>1000 </td>
                                                </tr>
                                                <tr>
                                                    <td> H1DN</td>
                                                    <td>Parasetamol</td>
                                                    <td>Puseng</td>
                                                    <td>1000 </td>
                                                </tr>
                                                <tr>
                                                    <td> H1DN</td>
                                                    <td>Parasetamol</td>
                                                    <td>Puseng</td>
                                                    <td>1000 </td>
                                                </tr>
                                                <tr>
                                                    <td> H1DN</td>
                                                    <td>Parasetamol</td>
                                                    <td>Puseng</td>
                                                    <td>1000 </td>
                                                </tr>
                                                <tr>
                                                    <td> H1DN</td>
                                                    <td>Parasetamol</td>
                                                    <td>Puseng</td>
                                                    <td>1000 </td>
                                                </tr>
                                                <tr>
                                                    <td> H1DN</td>
                                                    <td>Parasetamol</td>
                                                    <td>Puseng</td>
                                                    <td>1000 </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Status Dokter</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content table-responsive">
                                        <table class="table table-hover no-margins" id="table_status_dokter">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Nama Dokter</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="label label-danger">Tidak Aktif</span> </td>
                                                    <td>Monica</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="label label-primary">Aktif</span> </td>
                                                    <td>Monica</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end content -->
@endsection
@push('scripts')
<script>
    function changetime(name){
        $(".waktu").removeClass("active");
        $("button[name='"+name+"']").addClass("active");
    }
</script>

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
    <script>
        $(document).ready(function () {

            var barData = {
                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: [
                    {
                        label: "Pasien  Berkunjung",
                        backgroundColor: "#dc3545",
                        data: [65, 59, 80, 81, 56, 55, 40, 19, 86, 27, 90, 100]
                    },
                    {
                        label: "Pasien Dirujuk",
                        backgroundColor: "#18a689",
                        data: [28, 48, 40, 19, 86, 27, 90, 100, 12, 23, 24, 45]
                    },
                    {
                        label: "Pasien Pulang",
                        backgroundColor: "#17a2b8",
                        data: [40, 19, 86, 27, 59, 80, 81, 56, 55, 90, 100, 65]
                    },
                ]
            };

            var barOptions = {
                responsive: true
            };

            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {
                type: 'bar',
                data: barData,
                options: barOptions
            });

        });
    </script>
@endpush
