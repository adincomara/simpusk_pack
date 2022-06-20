<?php

use App\Http\Controllers\KIA\BerandaKiaController;
use App\Http\Controllers\PTM\AsistController;
use App\Http\Controllers\PTM\BerandaPtmController;
use App\Http\Controllers\PTM\FormDController;
use App\Http\Controllers\PTM\FrPtmKeswaController;
use App\Http\Controllers\PTM\KasusInderaController;
use App\Http\Controllers\PTM\KasusJiwaController;
use App\Http\Controllers\PTM\KasusPtmController;
use App\Http\Controllers\PTM\PanduController;
use App\Http\Controllers\PTM\SdqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Simpusk\LoginController;
use App\Http\Controllers\Simpusk\BerandaController;
use App\Http\Controllers\Simpusk\StaffController;

use App\Http\Controllers\Simpusk\PermissionController;
use App\Http\Controllers\Simpusk\RoleController;
use App\Http\Controllers\Simpusk\AboutController;
use App\Http\Controllers\Simpusk\AntrianController;
use App\Http\Controllers\Simpusk\SliderController;

use App\Http\Controllers\Simpusk\PoliController;
use App\Http\Controllers\Simpusk\SupplierController;
use App\Http\Controllers\Simpusk\JenisOperasiController;
use App\Http\Controllers\Simpusk\PasienController;
use App\Http\Controllers\Simpusk\PenyakitController;
use App\Http\Controllers\Simpusk\TindakanController;
use App\Http\Controllers\Simpusk\JabatanController;
use App\Http\Controllers\Simpusk\BidangController;
use App\Http\Controllers\Simpusk\PegawaiController;
use App\Http\Controllers\Simpusk\PendaftaranController;
use App\Http\Controllers\Simpusk\DiagnosaPenyakitController;
use App\Http\Controllers\Simpusk\IntegrasiBPJSController;
use App\Http\Controllers\Simpusk\KkController;
use App\Http\Controllers\Simpusk\ObatController;
use App\Http\Controllers\Simpusk\StokObatController;
use App\Http\Controllers\Simpusk\PengadaanObatController;
use App\Http\Controllers\Simpusk\PengeluaranObatController;
use App\Http\Controllers\Simpusk\PelayananpoliController;
use App\Http\Controllers\Simpusk\LaboratoriumController;
use App\Http\Controllers\Simpusk\LaporanController;
use App\Http\Controllers\Simpusk\RujukanController;
use App\Models\Simpusk\AntrianBPJS;
use App\Models\Simpusk\StokObat;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::post('/daftarbpjs', [PendaftaranController::class, 'pendaftaranBpjs']);
// Route::post('/bpjs', [PendaftaranController::class, 'pasienbpjs']);
Route::get('/', function () {
    return redirect()->route('manage.beranda');
})->name('home');
// Route::post('/upload', [BerandaController::class, 'import'])->name('file-import');

Route::get('/manage/login', [LoginController::class, 'index'])->name('manage.login');
Route::post('/manage/login', [LoginController::class, 'checkLogin'])->name('manage.checklogin');
Route::get('/antrian/operator', function(){
    return view('antrian/operator_antrian');
});
Route::get('/antrian/getdataoperator', [AntrianController::class, 'getDataOperator'])->name('getDataOperator');
Route::get('/antrian/getdataantrian', [AntrianController::class, 'getDataAntrian'])->name('getDataAntrian');
Route::get('/antrian/getallpoli', [AntrianController::class, 'getallpoli'])->name('getallpoli');
Route::get('/antrian/ambil_antrian', function(){
    return view('antrian/ambil_antrian');
});
Route::post('/antrian/postantrian', [AntrianController::class, 'postantrian'])->name('postantrian');
Route::get('manage/antrian/cetak/{no?}', [AntrianController::class, 'antriancetak'])->name('antrian.cetak');




// Route::get('/managee/{data}', [BerandaController::class, 'index2'])->name('manage.beranda2');
// Route::get('/manageee/{data}', [BerandaController::class, 'ngetes'])->name('beranda.ngetes');
Route::group(['middleware' => ['auth', 'acl:web']], function () {
    Route::group(['prefix' => 'manage/simpusk'], function(){
        Route::get('/manage', [BerandaController::class, 'index'])->name('manage.beranda');
        Route::get('/manage/logout', [LoginController::class, 'logout'])->name('manage.logout');

        // STAFF
        Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('staff/getdata', [StaffController::class, 'getData'])->name('staff.getdata');
        Route::get('staff/tambah', [StaffController::class, 'tambah'])->name('staff.tambah');
        Route::get('staff/detail/{id}', [StaffController::class, 'detail'])->name('staff.detail');
        Route::get('staff/ubah/{id}', [StaffController::class, 'ubah'])->name('staff.ubah');
        Route::delete('staff/hapus/{id?}', [StaffController::class, 'hapus'])->name('staff.hapus');
        Route::post('staff/simpan', [StaffController::class, 'simpan'])->name('staff.simpan');


        //SLIDER
        Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
        Route::post('slider/getdata', [SliderController::class, 'getData'])->name('slider.getdata');
        Route::get('slider/tambah', [SliderController::class, 'tambah'])->name('slider.tambah');
        Route::get('slider/ubah/{id}', [SliderController::class, 'ubah'])->name('slider.ubah');
        Route::delete('slider/hapus/{id?}', [SliderController::class, 'hapus'])->name('slider.hapus');
        Route::post('slider/simpan', [SliderController::class, 'simpan'])->name('slider.simpan');
        Route::get('slider/sorting/{id?}', [SliderController::class, 'sorting'])->name('slider.sorting');


        //ABOUT
        Route::get('tentang', [AboutController::class, 'form'])->name('about.index');
        Route::post('tentang/simpan', [AboutController::class, 'simpan'])->name('about.simpanumum');
        Route::post('tentang/simpaninfo', [AboutController::class, 'simpanInfo'])->name('about.simpaninfo');
        Route::post('tentang/simpanmedia', [AboutController::class, 'simpanMedia'])->name('about.simpanmedia');

        //PERMISSION
        Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('permission/tambah', [PermissionController::class, 'tambah'])->name('permission.tambah');
        Route::get('permission/ubah/{id}', [PermissionController::class, 'ubah'])->name('permission.ubah');
        Route::post('permission/simpan/{id?}', [PermissionController::class, 'simpan'])->name('permission.simpan');
        Route::get('permission/sidebar', [PermissionController::class, 'sidebar'])->name('permission.sidebar');

        //ROLE
        Route::get('role', [RoleController::class, 'index'])->name('role.index');
        Route::get('role/lihat/{id}', [RoleController::class, 'lihat'])->name('role.lihat');
        Route::get('role/tambah', [RoleController::class, 'form'])->name('role.tambah');
        Route::get('role/ubah/{id}', [RoleController::class, 'form'])->name('role.ubah');
        Route::get('role/user/{id}', [RoleController::class, 'formuser'])->name('role.user');
        Route::post('role/tambah', [RoleController::class, 'save'])->name('role.tambah');
        Route::post('role/ubah/{id}', [RoleController::class, 'save'])->name('role.ubah');
        Route::post('role/user/{id}', [RoleController::class, 'saveuser'])->name('role.user');
        Route::post('role/getdata', [RoleController::class, 'getData'])->name('role.getdata');
        Route::delete('role/hapus/{id?}', [RoleController::class, 'delete'])->name('role.hapus');

        //PROFILE
        Route::get('profil', [StaffController::class, 'profil'])->name('profil.index');
        Route::post('profil/simpan', [StaffController::class, 'profilSimpan'])->name('profil.simpan');
        Route::get('newpassword', [StaffController::class, 'profilPassword'])->name('profil.password');
        Route::post('password/simpan', [StaffController::class, 'profilNewPassword'])->name('profil.simpanpassword');

        // JABATAN
        Route::get('jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
        Route::post('jabatan/getdata', [JabatanController::class, 'getData'])->name('jabatan.getdata');
        Route::get('jabatan/tambah', [JabatanController::class, 'tambah'])->name('jabatan.tambah');
        Route::get('jabatan/detail/{id}', [JabatanController::class, 'detail'])->name('jabatan.detail');
        Route::get('jabatan/ubah/{id}', [JabatanController::class, 'ubah'])->name('jabatan.ubah');
        Route::delete('jabatan/hapus/{id?}', [JabatanController::class, 'hapus'])->name('jabatan.hapus');
        Route::post('jabatan/simpan', [JabatanController::class, 'simpan'])->name('jabatan.simpan');
        Route::post('jabatan/ngetes', [JabatanController::class, 'ngetes'])->name('jabatan.ngetes');

        // BIDANG
        Route::get('bidang', [BidangController::class, 'index'])->name('bidang.index');
        Route::post('bidang/getdata', [BidangController::class, 'getData'])->name('bidang.getdata');
        Route::get('bidang/tambah', [BidangController::class, 'tambah'])->name('bidang.tambah');
        Route::get('bidang/detail/{id}', [BidangController::class, 'detail'])->name('bidang.detail');
        Route::get('bidang/ubah/{id}', [BidangController::class, 'ubah'])->name('bidang.ubah');
        Route::delete('bidang/hapus/{id?}', [BidangController::class, 'hapus'])->name('bidang.hapus');
        Route::post('bidang/simpan', [BidangController::class, 'simpan'])->name('bidang.simpan');

        // PEGAWAI
        Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('pegawai/getdata', [PegawaiController::class, 'getData'])->name('pegawai.getdata');
        Route::post('pegawai/detail', [PegawaiController::class, 'detail_data'])->name('pegawai.detail_data');
        Route::get('pegawai/tambah', [PegawaiController::class, 'tambah'])->name('pegawai.tambah');
        Route::get('pegawai/detail/{id}', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/ubah/{id}', [PegawaiController::class, 'ubah'])->name('pegawai.ubah');
        Route::delete('pegawai/hapus/{id?}', [PegawaiController::class, 'hapus'])->name('pegawai.hapus');
        Route::post('pegawai/simpan', [PegawaiController::class, 'simpan'])->name('pegawai.simpan');
        Route::post('pegawai/cetak/{data?}', [PegawaiController::class, 'cetak'])->name('pegawai.cetak');
        Route::get('pegawai/cetak/nakes', [PegawaiController::class, 'cetakNakes'])->name('pegawai.cetaknakes');
        Route::post('pegawai/ubah_status', [PegawaiController::class, 'ubah_status'])->name('pegawai.ubah_status');

        // Diagnosa Penyakit
        Route::get('diagnosa_penyakit', [DiagnosaPenyakitController::class, 'index'])->name('diagnosa_penyakit.index');
        Route::post('diagnosa_penyakit/getdata', [DiagnosaPenyakitController::class, 'getData'])->name('diagnosa_penyakit.getdata');
        Route::get('diagnosa_penyakit/tambah', [DiagnosaPenyakitController::class, 'tambah'])->name('diagnosa_penyakit.tambah');
        Route::get('diagnosa_penyakit/detail/{id}', [DiagnosaPenyakitController::class, 'detail'])->name('diagnosa_penyakit.detail');
        Route::get('diagnosa_penyakit/ubah/{id}', [DiagnosaPenyakitController::class, 'ubah'])->name('diagnosa_penyakit.ubah');
        Route::delete('diagnosa_penyakit/hapus/{id?}', [DiagnosaPenyakitController::class, 'hapus'])->name('diagnosa_penyakit.hapus');
        Route::post('diagnosa_penyakit/simpan', [DiagnosaPenyakitController::class, 'simpan'])->name('diagnosa_penyakit.simpan');

        // OBAT
        Route::get('obat', [ObatController::class, 'index'])->name('obat.index');
        Route::post('obat/getdata', [ObatController::class, 'getData'])->name('obat.getdata');
        Route::get('obat/tambah', [ObatController::class, 'tambah'])->name('obat.tambah');
        Route::get('obat/detail/{id}', [ObatController::class, 'detail'])->name('obat.detail');
        Route::get('obat/ubah/{id}', [ObatController::class, 'ubah'])->name('obat.ubah');
        Route::delete('obat/hapus/{id?}', [ObatController::class, 'hapus'])->name('obat.hapus');
        Route::post('obat/simpan', [ObatController::class, 'simpan'])->name('obat.simpan');
        Route::get('obat/autocomplete', [ObatController::class, 'autocomplete'])->name('obat.autocomplete');
        Route::get('obat/autofill', [ObatController::class, 'autofill'])->name('obat.autofill');

        //POLI
        Route::get('poli', [PoliController::class, 'index'])->name('poli.index');
        Route::post('poli/getdata', [PoliController::class, 'getData'])->name('poli.getdata');
        Route::get('poli/tambah', [PoliController::class, 'tambah'])->name('poli.tambah');
        Route::get('poli/ubah/{id}', [PoliController::class, 'ubah'])->name('poli.ubah');
        Route::delete('poli/hapus/{id?}', [PoliController::class, 'hapus'])->name('poli.hapus');
        Route::post('poli/simpan', [PoliController::class, 'simpan'])->name('poli.simpan');
        Route::post('poli/status_ubah', [PoliController::class, 'status_ubah'])->name('poli.status_ubah');


        //SUPPLIER
        Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('supplier/getdata', [SupplierController::class, 'getData'])->name('supplier.getdata');
        Route::get('supplier/tambah', [SupplierController::class, 'tambah'])->name('supplier.tambah');
        Route::get('supplier/ubah/{id}', [SupplierController::class, 'ubah'])->name('supplier.ubah');
        Route::delete('supplier/hapus/{id?}', [SupplierController::class, 'hapus'])->name('supplier.hapus');
        Route::post('supplier/simpan', [SupplierController::class, 'simpan'])->name('supplier.simpan');
        Route::get('supplier/autocomplete', [SupplierController::class, 'autocomplete'])->name('supplier.autocomplete');
        Route::get('supplier/cetak', [SupplierController::class, 'cetak'])->name('supplier.cetak');
        Route::get('supplier/excel', [SupplierController::class, 'laporanExcel'])->name('supplier.excel');




        //STOK OBAT
        Route::get('stok_obat', [StokObatController::class, 'index'])->name('stok_obat.index');
        Route::post('stok_obat/getdata', [StokObatController::class, 'getData'])->name('stok_obat.getdata');
        Route::get('stok_obat/tambah', [StokObatController::class, 'tambah'])->name('stok_obat.tambah');
        Route::get('stok_obat/ubah/{id}', [StokObatController::class, 'ubah'])->name('stok_obat.ubah');
        Route::delete('stok_obat/hapus/{id?}', [StokObatController::class, 'hapus'])->name('stok_obat.hapus');
        Route::post('stok_obat/simpan', [StokObatController::class, 'simpan'])->name('stok_obat.simpan');
        Route::post('stok_obat/cetak', [StokObatController::class, 'cetak'])->name('stok_obat.cetak');
        Route::post('stok_obat/excel', [StokObatController::class, 'laporanExcel'])->name('stok_obat.excel');
        Route::post('stok_obat/batch_obat', [StokObatController::class, 'batch_obat'])->name('stok_obat.batch_obat');
        Route::post('stok_obat/stok_obat', [StokObatController::class, 'get_stok'])->name('stok_obat.get_stok');
        Route::post('stok_obat/tgl', [StokObatController::class, 'get_tgl'])->name('stok_obat.get_tgl');
        Route::post('stok_obat/detail/', [StokObatController::class, 'detail'])->name('stok_obat.detail');
        Route::post('stok_obat/modal_obat/', [StokObatController::class, 'modal_obat'])->name('stok_obat.modal_obat');



        //PENGADAAN OBAT
        Route::get('pengadaan_obat', [PengadaanObatController::class, 'index'])->name('pengadaan_obat.index');
        Route::post('pengadaan_obat/getdata', [PengadaanObatController::class, 'getData'])->name('pengadaan_obat.getdata');
        Route::get('pengadaan_obat/tambah', [PengadaanObatController::class, 'tambah'])->name('pengadaan_obat.tambah');
        Route::get('pengadaan_obat/detail/{id}', [PengadaanObatController::class, 'detail'])->name('pengadaan_obat.detail');
        Route::delete('pengadaan_obat/hapus/{id?}', [PengadaanObatController::class, 'hapus'])->name('pengadaan_obat.hapus');
        Route::post('pengadaan_obat/simpan', [PengadaanObatController::class, 'simpan'])->name('pengadaan_obat.simpan');
        Route::get('pengadaan_obat/cetak', [PengadaanObatController::class, 'cetak'])->name('pengadaan_obat.cetak');
        Route::get('pengadaan_obat/excel', [PengadaanObatController::class, 'laporanExcel'])->name('pengadaan_obat.excel');
        Route::get('pelayanan_poli/search_suplier', [PengadaanObatController::class, 'searchSuplier'])->name('pengadaan_obat.searchSuplier');


        //PENGELUARAN OBAT
        Route::get('pengeluaran_obat', [PengeluaranObatController::class, 'index'])->name('pengeluaran_obat.index');
        Route::post('pengeluaran_obat/getdata', [PengeluaranObatController::class, 'getData'])->name('pengeluaran_obat.getdata');
        Route::post('pengeluaran_obat/getdata_pendaftaran', [PengeluaranObatController::class, 'getDataPendaftaran'])->name('pengeluaran_obat.getdata_pendaftaran');
        Route::get('pengeluaran_obat/tambah/{id}', [PengeluaranObatController::class, 'tambah'])->name('pengeluaran_obat.tambah');
        Route::get('pengeluaran_obat/proses_resep', [PengeluaranObatController::class, 'proses_resep'])->name('pengeluaran_obat.proses_resep');
        Route::get('pengeluaran_obat/detail/{id}', [PengeluaranObatController::class, 'detail'])->name('pengeluaran_obat.detail');
        Route::get('pengeluaran_obat/ubah/{id}', [PengeluaranObatController::class, 'ubah'])->name('pengeluaran_obat.ubah');
        Route::delete('pengeluaran_obat/hapus/{id?}', [PengeluaranObatController::class, 'hapus'])->name('pengeluaran_obat.hapus');
        Route::post('pengeluaran_obat/simpan', [PengeluaranObatController::class, 'simpan'])->name('pengeluaran_obat.simpan');
        Route::post('pengeluaran_obat/cetak/beri', [PengeluaranObatController::class, 'cetakBeriObat'])->name('pengeluaran_obat.cetakberiobat');
        Route::post('pengeluaran_obat/addObat', [PengeluaranObatController::class, 'addObat'])->name('pengeluaran_obat.addObat');
        Route::post('pengeluaran_obat/batch_obat', [PengeluaranObatController::class, 'batch_obat'])->name('pengeluaran_obat.batch_obat');

        //JENIS OPERASI
        Route::get('jenisoperasi', [JenisOperasiController::class, 'index'])->name('jenisoperasi.index');
        Route::post('jenisoperasi/getdata', [JenisOperasiController::class, 'getData'])->name('jenisoperasi.getdata');
        Route::get('jenisoperasi/tambah', [JenisOperasiController::class, 'tambah'])->name('jenisoperasi.tambah');
        Route::get('jenisoperasi/ubah/{id}', [JenisOperasiController::class, 'ubah'])->name('jenisoperasi.ubah');
        Route::delete('jenisoperasi/hapus/{id?}', [JenisOperasiController::class, 'hapus'])->name('jenisoperasi.hapus');
        Route::post('jenisoperasi/simpan', [JenisOperasiController::class, 'simpan'])->name('jenisoperasi.simpan');

        //PASIEN
        Route::get('pasien', [PasienController::class, 'index'])->name('pasien.index');
        Route::post('pasien/getdata', [PasienController::class, 'getData'])->name('pasien.getdata');
        Route::post('/manage/pasien/detail', [PasienController::class, 'detail_data'])->name('pasien.detail_data');
        Route::post('/manage/pasien/riwayat', [PasienController::class, 'riwayat_kunjungan'])->name('pasien.riwayat_kunjungan');

        Route::get('pasien/tambah', [PasienController::class, 'tambah'])->name('pasien.tambah');
        Route::post('pasien/validate/', [PasienController::class, 'validatePasien'])->name('pasien.validate');
        Route::get('pasien/ubah/{id}', [PasienController::class, 'ubah'])->name('pasien.ubah');
        Route::delete('pasien/hapus/{id?}', [PasienController::class, 'hapus'])->name('pasien.hapus');
        Route::post('pasien/simpan', [PasienController::class, 'simpan'])->name('pasien.simpan');
        Route::get('pasien/autocomplete', [PasienController::class, 'autocomplete'])->name('pasien.autocomplete');
        Route::get('pasien/cetak/kunjungan', [PasienController::class, 'cetakPasienKunjungan'])->name('pasien.cetakpasienkunjungan');

        //PENYAKIT
        Route::get('penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');
        Route::post('penyakit/getdata', [PenyakitController::class, 'getData'])->name('penyakit.getdata');
        Route::get('penyakit/tambah', [PenyakitController::class, 'tambah'])->name('penyakit.tambah');
        Route::get('penyakit/ubah/{id}', [PenyakitController::class, 'ubah'])->name('penyakit.ubah');
        Route::delete('penyakit/hapus/{id?}', [PenyakitController::class, 'hapus'])->name('penyakit.hapus');
        Route::post('penyakit/simpan', [PenyakitController::class, 'simpan'])->name('penyakit.simpan');

        //TINDAKAN
        Route::get('tindakan', [TindakanController::class, 'index'])->name('tindakan.index');
        Route::post('tindakan/getdata', [TindakanController::class, 'getData'])->name('tindakan.getdata');
        Route::get('tindakan/tambah', [TindakanController::class, 'tambah'])->name('tindakan.tambah');
        Route::get('tindakan/ubah/{id}', [TindakanController::class, 'ubah'])->name('tindakan.ubah');
        Route::delete('tindakan/hapus/{id?}', [TindakanController::class, 'hapus'])->name('tindakan.hapus');
        Route::post('tindakan/simpan', [TindakanController::class, 'simpan'])->name('tindakan.simpan');


        //PENDAFTARAN
        Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::post('pendaftaran/getdata', [PendaftaranController::class, 'getData'])->name('pendaftaran.getdata');
        Route::get('pendaftaran/tambah',[PendaftaranController::class, 'tambah'])->name('pendaftaran.tambah');
        Route::get('pendaftaran/ubah/{id}',[PendaftaranController::class, 'ubah'])->name('pendaftaran.ubah');
        Route::get('pendaftaran/cetak/{id}',[PendaftaranController::class, 'cetak'])->name('pendaftaran.cetak');
        Route::delete('pendaftaran/hapus/{id?}',[PendaftaranController::class, 'hapus'])->name('pendaftaran.hapus');
        Route::post('pendaftaran/simpan',[PendaftaranController::class, 'simpan'])->name('pendaftaran.simpan');
        Route::get('pendaftaran/getNoRekam',[PendaftaranController::class, 'getNoRekam'])->name('pendaftaran.getNoRekam');
        Route::get('pendaftaran/getDokter',[PendaftaranController::class, 'getDokter'])->name('pendaftaran.getDokter');
        Route::get('pendaftaran/getsubpoli/{id?}',[PendaftaranController::class, 'getSubPoli'])->name('pendaftaran.getsubpoli');
        Route::post('pendaftaran/getbpjs', [PendaftaranController::class, 'pasienbpjs'])->name('pendaftaran.getdatabpjs');
        Route::post('pendaftaran/daftarbpjs', [PendaftaranController::class, 'pendaftaranBpjs'])->name('pendaftaran.daftarbpjs');
        Route::post('pendaftaran/savenoantrian', [PendaftaranController::class, 'simpanNoAntrian'])->name('pendaftaran.simpanantrian');
        Route::get('pendaftaran/search_rekam', [PendaftaranController::class, 'searchRekam'])->name('pendaftaran.searchRekam');
        // Route::get('/manage/ambil_antrian', [AntrianController::class, 'ambil_antrian'])->name('pendaftaran.ambil_antrian');

        //ANTRIAN
        Route::get('antrian', [AntrianController::class, 'index'])->name('antrian.index');
        Route::get('antriannow', [AntrianController::class, 'antriannow'])->name('antrian.antriannow');
        Route::post('antrian/getantrian', [AntrianController::class, 'getData'])->name('antrian.getdata');
        Route::post('antrian/antrianselesai', [AntrianController::class, 'antrianselesai'])->name('antrian.antrianselesai');

        Route::post('antrian/audio_panggil', [AntrianController::class, 'audio_panggil'])->name('antrian.audio_panggil');

        //KK
        Route::get('kk', [KkController::class, 'index'])->name('kk.index');
        Route::post('kk/getdata', [KkController::class, 'getData'])->name('kk.getdata');
        Route::get('kk/tambah', [KkController::class, 'tambah'])->name('kk.tambah');
        Route::get('kk/ubah/{id}', [KkController::class, 'ubah'])->name('kk.ubah');
        Route::delete('kk/hapus/{id?}', [KkController::class, 'hapus'])->name('kk.hapus');Route::get('laporan/pasienDiagnosa', [LaporanController::class, 'pasienDiagnosa'])->name('report.pasienDiagnosa');
        Route::post('laporan/getdatapasienDiagnosa', [LaporanController::class, 'getdatapasienDiagnosa'])->name('report.getdatapasienDiagnosa');
        Route::get('laporan/laporan_diagnosis/{id?}', [LaporanController::class, 'laporan_diagnosis'])->name('report.detailDiagnosis');
        Route::get('laporan/pasienTindakan', [LaporanController::class, 'pasienTindakan'])->name('report.pasienTindakan');
        Route::post('laporan/getdatapasienTindakan', [LaporanController::class, 'getdatapasienTindakan'])->name('report.getdatapasienTindakan');
        Route::get('laporan/laporan_tindakan/{id?}', [LaporanController::class, 'laporan_tindakan'])->name('report.detailTindakan');


        Route::get('laporan/tindakanPasien/', [LaporanController::class, 'tindakanPasien'])->name('report.tindakanPasien');
        Route::post('laporan/gettindakanpasien', [LaporanController::class, 'gettindakanpasien'])->name('report.getdatatindakanpasien');
        Route::get('laporan/cetakDiagnosa/{id?}', [LaporanController::class, 'cetakDiagnosa'])->name('report.cetakDiagnosa');
        Route::get('laporan/cetakTindakan/{id?}', [LaporanController::class, 'cetakTindakan'])->name('report.cetakTindakan');
        Route::get('laporan/cetakTindakanPasien', [LaporanController::class, 'cetakTindakanPasien'])->name('report.cetakTindakanPasien');
        Route::get('laporan/pasienBPJS', [LaporanController::class, 'pasienBPJS'])->name('report.pasienBPJS');
        Route::post('laporan/getdatapasienBPJS', [LaporanController::class, 'getdatapasienBPJS'])->name('report.getdatapasienBPJS');
        Route::get('laporan/laporan_bpjs/{id?}', [LaporanController::class, 'laporan_bpjs'])->name('report.detailBPJS');
        Route::get('laporan/rujukanBPJS', [LaporanController::class, 'rujukanBPJS'])->name('report.rujukanBPJS');
        // Route::post('laporan/getdatarujukanBPJS', [LaporanController::class, 'getdatarujukanBPJS'])->name('report.getdatarujukanBPJS');
        Route::get('laporan/cetakRujukan/{id?}', [LaporanController::class, 'cetakRujukan'])->name('report.cetakRujukan');
        Route::get('laporan/pegawai', [LaporanController::class, 'tenagakesehatan_index'])->name('tenagakesehatan.index');
        Route::post('laporan/getdata', [PegawaiController::class, 'getData'])->name('tenagakesehatan.getdata');
        Route::get('laporan/jabatan_nakes', [LaporanController::class, 'jabatannakes_index'])->name('jabatannakes.index');
        Route::get('laporan/jabatan_nakes/detail/{id}', [LaporanController::class, 'jabatan_detail'])->name('jabatannakes.detail');
        Route::post('laporan/jabatan_nakes_getdata', [LaporanController::class, 'jabatan_nakes_getdata'])->name('jabatannakes.getdata');
        Route::get('laporan/cetakjabatan/{id}', [LaporanController::class, 'cetakjabatan'])->name('jabatannakes.cetak');

        Route::post('kk/simpan', [KkController::class, 'simpan'])->name('kk.simpan');
        Route::post('kk/pilihKabkot/{id?}', [KkController::class, 'pilihKabkot'])->name('kk.pilihKabkot');
        Route::post('kk/pilihKec/{id?}', [KkController::class, 'pilihKec'])->name('kk.pilihKec');
        Route::post('kk/getKelurahan', [KkController::class, 'getKelurahan'])->name('kk.getKelurahan');
        Route::post('kk/addAnggota', [KkController::class, 'addAnggota'])->name('kk.addAnggota');
        Route::post('kk/detail_data', [KkController::class, 'detail_data'])->name('kk.detail_data');


        Route::get('tindakan/tambah', [TindakanController::class, 'tambah'])->name('tindakan.tambah');
        Route::get('tindakan/ubah/{id}', [TindakanController::class, 'ubah'])->name('tindakan.ubah');
        Route::delete('tindakan/hapus/{id?}', [TindakanController::class, 'hapus'])->name('tindakan.hapus');
        Route::post('tindakan/simpan', [TindakanController::class, 'simpan'])->name('tindakan.simpan');

        //PELAYANAN POLI
        Route::get('pelayanan_poli', [PelayananpoliController::class, 'index'])->name('pelayanan_poli.index');
        Route::post('pelayanan_poli/getdata', [PelayananpoliController::class, 'getData'])->name('pelayanan_poli.getdata');
        Route::get('pelayanan_poli/tambah', [PelayananpoliController::class, 'tambah'])->name('pelayanan_poli.tambah');
        Route::post('pelayanan_poli/addDiagnosis', [PelayananpoliController::class, 'addDiagnosis'])->name('pelayanan_poli.addDiagnosis');
        Route::post('pelayanan_poli/addObat', [PelayananpoliController::class, 'addObat'])->name('pelayanan_poli.addObat');
        Route::post('pelayanan_poli/deleteDiagnosis', [PelayananpoliController::class, 'deleteDiagnosis'])->name('pelayanan_poli.deleteDiagnosis');
        Route::get('pelayanan_poli/tindakan_dokter/{id}',[PelayananpoliController::class, 'tindakan_dokter'])->name('pelayanan_poli.tindakan_dokter');
        Route::get('pelayanan_poli/cetak/{id}',[PelayananpoliController::class, 'cetak'])->name('pelayanan_poli.cetak');
        Route::delete('pelayanan_poli/hapus/{id?}',[PelayananpoliController::class, 'hapus'])->name('pelayanan_poli.hapus');
        // Route::post('pelayanan_poli/simpan',[PelayananpoliController::class, 'simpanPelayananPoli'])->name('pelayanan_poli.simpan');
        Route::post('pelayanan_poli/simpan',[PelayananpoliController::class, 'simpan'])->name('pelayanan_poli.simpan');
        Route::get('pelayanan_poli/getNoRekam',[PelayananpoliController::class, 'getNoRekam'])->name('pelayanan_poli.getNoRekam');
        Route::post('pelayanan_poli/getkesadaran',[PelayananpoliController::class, 'getKesadaran'])->name('pelayanan_poli.getkesadaran');
        Route::get('pelayanan_poli/getdokter',[PelayananpoliController::class, 'getDokter'])->name('pelayanan_poli.getdokter');
        Route::post('pelayanan_poli/getkesadaranbpjs', [PelayananpoliController::class, 'getKesadaran'])->name('pelayanan_poli.kesadaranbpjs');
        Route::post('pelayanan_poli/getdiagnosabpjs', [PelayananpoliController::class, 'getDiagnosa'])->name('pelayanan_poli.diagnosabpjs');
        Route::post('pelayanan_poli/getdokterbpjs', [PelayananpoliController::class, 'getDokterBpjs'])->name('pelayanan_poli.dokterbpjs');
        Route::post('pelayanan_poli/getspesialisbpjs', [PelayananpoliController::class, 'getSpesialis'])->name('pelayanan_poli.spesialisbpjs');
        Route::post('pelayanan_poli/getsubspesialisbpjs/', [PelayananpoliController::class, 'getSubSpesialis'])->name('pelayanan_poli.subspesialisbpjs');
        Route::post('pelayanan_poli/getkhususbpjs', [PelayananpoliController::class, 'getKhusus'])->name('pelayanan_poli.khususbpjs');
        Route::post('pelayanan_poli/getsaranabpjs', [PelayananpoliController::class, 'getSarana'])->name('pelayanan_poli.saranabpjs');
        Route::post('pelayanan_poli/getfaskesrujukspesialis/', [PelayananpoliController::class, 'getFaskesRujukSpesialis'])->name('pelayanan_poli.rujukspesialisbpjs');
        Route::post('pelayanan_poli/getfaskesrujukkhusus/', [PelayananpoliController::class, 'getFaskesRujukKhusus'])->name('pelayanan_poli.rujukkhususbpjs');
        Route::post('pelayanan_poli/getfaskesrujuksubkhusus/', [PelayananpoliController::class, 'getFaskesRujukSubKhusus'])->name('pelayanan_poli.rujuksubkhususbpjs');
        Route::post('pelayanan_poli/daftarkunjungan', [PelayananpoliController::class, 'daftarKunjungan'])->name('pelayanan_poli.daftarkunjungan');
        Route::post('pelayanan_poli/simpanbpjsdata', [PelayananpoliController::class, 'insertlaporanbpjs'])->name('pelayanan_poli.simpanbpjsdata');
        Route::get('pelayanan_poli/search_diagnosa', [PelayananpoliController::class, 'searchDiagnosa'])->name('pelayanan_poli.searchDiagnosa');
        Route::get('pelayanan_poli/search_tindakan', [PelayananpoliController::class, 'searchTindakan'])->name('pelayanan_poli.searchTindakan');
        Route::get('pelayanan_poli/search_obat', [PelayananpoliController::class, 'searchObat'])->name('pelayanan_poli.searchObat');
        Route::post('pelayanan_poli/getstatuspulang', [PelayananpoliController::class, 'getStatusPulang'])->name('pelayanan_poli.statuspulang');

        // RUJUKAN INTEGRASI BPJS
        Route::get('pelayanan_poli/rujukan/bpjs', [IntegrasiBPJSController::class, 'index'])->name('rujukan.index');
        Route::get('pelayanan_poli/rujukan/bpjs/ubah/{id?}', [IntegrasiBPJSController::class, 'ubah'])->name('rujukan.ubah');
        Route::post('pelayanan_poli/rujukan/bpjs/getdata', [IntegrasiBPJSController::class, 'getDataRujukan'])->name('rujukan.getdataRujukan');
        Route::post('pelayanan_poli/rujukan/bpjs/simpan', [IntegrasiBPJSController::class, 'daftarkunjungan'])->name('rujukan.simpan');
        Route::get('laporan/pasienBPJS', [IntegrasiBPJSController::class, 'pasienBPJS'])->name('report.pasienBPJS');
        Route::post('laporan/getdatapasienBPJS', [IntegrasiBPJSController::class, 'getdatapasienBPJS'])->name('report.getdatapasienBPJS');
        Route::get('laporan/rujukanBPJS', [IntegrasiBPJSController::class, 'rujukanBPJS'])->name('report.rujukanBPJS');
        Route::post('laporan/getdatarujukanBPJS', [IntegrasiBPJSController::class, 'getdatarujukanBPJS'])->name('report.getdatarujukanBPJS');
        Route::get('kunjungan/pasien/bpjs', [IntegrasiBPJSController::class, 'KunjunganPasienBPJS'])->name('kunjungan.pasienBPJS');
        Route::post('kunjungan/getdatakunjunganpasienBPJS', [IntegrasiBPJSController::class, 'getdatakunjunganpasienBPJS'])->name('report.getdatakunjunganpasienBPJS');
        Route::get('kunjungan/detail/kunjunganpasienbpjs/{id?}', [IntegrasiBPJSController::class, 'DetailKunjunganPasienBPJS'])->name('kunjungan.detailkunjunganpasienbpjs');
        Route::get('kunjungan/print_rujukan/{id?}', [IntegrasiBPJSController::class, 'print_rujukan'])->name('report.printRujukan');
        Route::get('kunjungan/print_rujukanumum/{id?}', [IntegrasiBPJSController::class, 'print_rujukanumum'])->name('report.printRujukanUmum');
        Route::post('kunjungan/edit', [IntegrasiBPJSController::class, 'kunjungan_simpan'])->name('kunjungan.simpan');

        //LABORATORIUM
        Route::get('laboratorium', [LaboratoriumController::class, 'index'])->name('laboratorium.index');
        Route::get('laboratorium/periksa_laboratorium/{id}', [LaboratoriumController::class, 'periksa_laboratorium'])->name('laboratorium.periksa');
        Route::get('laboratorium/lihat_periksa_laboratorium/{id}', [LaboratoriumController::class, 'lihat_periksa_laboratorium'])->name('laboratorium.lihatPeriksa');
        Route::post('laboratorium/getdata', [LaboratoriumController::class, 'getData'])->name('laboratorium.getdata');
        Route::post('laboratorium/simpan', [LaboratoriumController::class, 'simpan'])->name('laboratorium.simpan');
        Route::post('laboratorium/simpanResepLab', [LaboratoriumController::class, 'simpanResepLab'])->name('laboratorium.simpanResepLab');


        //REPORT
        Route::get('laporan/pasienDiagnosa',[LaporanController::class, 'pasienDiagnosa'])->name('report.pasienDiagnosa');
        Route::post('laporan/getdatapasienDiagnosa', [LaporanController::class, 'getdatapasienDiagnosa'])->name('report.getdatapasienDiagnosa');
        Route::get('laporan/laporan_diagnosis/{id?}', [LaporanController::class, 'laporan_diagnosis'])->name('report.detailDiagnosis');
        Route::get('laporan/pasienTindakan', [LaporanController::class, 'pasienTindakan'])->name('report.pasienTindakan');
        Route::post('laporan/getdatapasienTindakan', [LaporanController::class, 'getdatapasienTindakan'])->name('report.getdatapasienTindakan');
        Route::get('laporan/laporan_tindakan/{id?}', [LaporanController::class, 'laporan_tindakan'])->name('report.detailTindakan');
        Route::get('laporan/laporan_rujukan/{id?}', [LaporanController::class, 'laporan_rujukan'])->name('report.detailRujukan');

        Route::get('laporan/tindakanPasienindex', [LaporanController::class, 'tindakanpasien_index'])->name('report.tindakanpasien_index');
        Route::get('laporan/tindakanPasien_detail/{id}', [LaporanController::class, 'tindakanPasien_detail'])->name('report.tindakanPasien_detail');
        Route::get('laporan/cetakDiagnosa/{id?}', [LaporanController::class, 'cetakDiagnosa'])->name('report.cetakDiagnosa');
        Route::get('laporan/cetakTindakan/{id?}', [LaporanController::class, 'cetakTindakan'])->name('report.cetakTindakan');
        Route::get('laporan/cetakTindakanPasien', [LaporanController::class, 'cetakTindakanPasien'])->name('report.cetakTindakanPasien');
        Route::get('laporan/cetakTindakanPasien_detail/{id}', [LaporanController::class, 'cetakTindakanPasien_detail'])->name('report.cetakTindakanPasien_detail');


        Route::get('laporan/laporan_bpjs', [LaporanController::class, 'laporan_bpjs'])->name('report.detailBPJS');


        Route::post('laporan/detailrujukanBPJS', [LaporanController::class, 'detailrujukanBPJS'])->name('report.getdetailrujukanBPJS');
        Route::post('laporan/riwayatrujukanBPJS', [LaporanController::class, 'detailriwayatBPJS'])->name('report.riwayatrujukanBPJS');
        Route::get('laporan/cetakRujukan/{id?}', [LaporanController::class, 'cetakRujukan'])->name('report.cetakRujukan');
        Route::get('lapoan/pemberionobat', [LaporanController::class, 'pemberianobat_index'])->name('report.pemberianobat.index');
        Route::post('laporan/getdatapemberianobat', [LaporanController::class, 'getdatapemberianobat'])->name('pemberianobat.getdata');
        Route::post('laporan/cetakpemberianobat',[LaporanController::class, 'cetakberiobat'])->name('report.pemberianobat.cetak');
        Route::post('laporan/tenagakesehatan/cetak',[LaporanController::class, 'cetaktenagakesehatan'])->name('report.tenagakesehatan.cetak');


        Route::post('laporan/kunjunganpasien/cetak',[LaporanController::class, 'cetakdatakunjunganpasien'])->name('report.kunjunganpasien.cetak');
        Route::post('laporan/getkunjunganpasien', [LaporanController::class, 'getdatakunjunganpasien'])->name('report.kunjunganpasien.getdata');
        Route::get('laporan/kunjunganpasien', [LaporanController::class, 'indexdatakunjunganpasien'])->name('report.kunjunganpasien.index');

    });

    //PTM KESWA (Penyakit Tidak Menular & Kesehatan Jiwa)
    Route::group(['prefix' => 'manage/ptm'], function(){
        Route::get('/', [BerandaPtmController::class, 'index'])->name('manage.beranda.ptm');
        //Kasus ptm
        Route::group(['prefix' => 'kasus_ptm', 'as' => 'kasus_ptm.'], function () {
            // Route::get('/', function () {
            //     return view('ptm/kasus/ptm/index');
            // })->name('index');
            Route::get('/', [KasusPtmController::class, 'index'])->name('index');
            Route::get('/tambah', [KasusPtmController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id}', [KasusPtmController::class, 'ubah'])->name('ubah');
            Route::get('/filter_puskesmas', [KasusPtmController::class, 'filter_puskesmas'])->name('filter_puskesmas');
            Route::post('/getdata', [KasusPtmController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [KasusPtmController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [KasusPtmController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [KasusPtmController::class, 'cetak_pdf'])->name('cetak_pdf');
            Route::post('/getsum', [KasusPtmController::class, 'getsumdata'])->name('getsum');
        });
        //Kasus indera
        Route::group(['prefix' => 'kasus_indera', 'as' => 'kasus_indera.'], function () {
            // Route::get('/', function () {
            //     return view('ptm/kasus/indera/index');
            // })->name('index');
            Route::get('/', [KasusInderaController::class, 'index'])->name('index');
            Route::post('/getdata_penglihatan', [KasusInderaController::class, 'getDataPengelihatan'])->name('getdata_penglihatan');
            Route::post('/getdata_pendengaran', [KasusInderaController::class, 'getDataPendengaran'])->name('getdata_pendengaran');
            Route::post('/simpan', [KasusInderaController::class, 'simpan'])->name('simpan');
            Route::post('/cetak_pdf', [KasusInderaController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Kasus jiwa
        Route::group(['prefix' => 'kasus_jiwa', 'as' => 'kasus_jiwa.'], function () {
            // Route::get('/', function () {
            //     return view('ptm/kasus/jiwa/index');
            // })->name('index');
            Route::get('/form', function () {
                return view('ptm/kasus/jiwa/form');
            })->name('form');
            Route::get('/', [KasusJiwaController::class, 'index'])->name('index');
            Route::get('/tambah', [KasusJiwaController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id}', [KasusJiwaController::class, 'ubah'])->name('ubah');
            Route::get('/filter_puskesmas', [KasusJiwaController::class, 'filter_puskesmas'])->name('filter_puskesmas');
            Route::post('/getdata', [KasusJiwaController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [KasusJiwaController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [KasusJiwaController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [KasusJiwaController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Deteksi Dini Faktro Risiko PTM KESWA
        Route::group(['prefix' => 'dd_fr_ptm_keswa', 'as' => 'dd_fr_ptm_keswa.'], function () {
            //

            // Route::get('/form', function () {
            //     return view('ptm/deteksi_dini/faktor_risiko_ptm_keswa/form');
            // })->name('form');
            Route::get('/', [FrPtmKeswaController::class, 'index'])->name('index');
            Route::post('getdata', [FrPtmKeswaController::class, 'getData'])->name('getdata');
            Route::get('/tambah', [FrPtmKeswaController::class, 'tambah'])->name('tambah');
            Route::post('/simpan', [FrPtmKeswaController::class, 'simpan'])->name('simpan');
            Route::get('/ubah/{id?}', [FrPtmKeswaController::class, 'ubah'])->name('ubah');
            Route::delete('/delete/{id?}', [FrPtmKeswaController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [FrPtmKeswaController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Deteksi Dini SDQ
        Route::group(['prefix' => 'dd_sdq', 'as' => 'dd_sdq.'], function () {
            // Route::get('/', function () {
            //     return view('ptm/deteksi_dini/sdq/index');
            // })->name('index');
            // Route::get('/form', function () {
            //     return view('ptm/deteksi_dini/sdq/form');
            // })->name('form');
            Route::get('/', [SdqController::class, 'index'])->name('index');
            Route::post('getdata', [SdqController::class, 'getData'])->name('getdata');
            Route::get('/tambah', [SdqController::class, 'tambah'])->name('tambah');
            Route::post('/simpan', [SdqController::class, 'simpan'])->name('simpan');
            Route::get('/ubah/{id?}', [SdqController::class, 'ubah'])->name('ubah');
            Route::delete('/delete/{id?}', [SdqController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [SdqController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Deteksi Dini ASSIST
        Route::group(['prefix' => 'dd_assist', 'as' => 'dd_assist.'], function () {
            Route::get('/', function () {
                return view('ptm/deteksi_dini/assist/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/deteksi_dini/assist/form');
            })->name('form');
            Route::get('/', [AsistController::class, 'index'])->name('index');
            Route::get('/tambah', [AsistController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [AsistController::class, 'ubah'])->name('ubah');
            Route::post('/getdata', [AsistController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [AsistController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [AsistController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [AsistController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Deteksi Dini PANDU
        Route::group(['prefix' => 'dd_pandu', 'as' => 'dd_pandu.'], function () {
            Route::get('/', function () {
                return view('ptm/deteksi_dini/pandu/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/deteksi_dini/pandu/form');
            })->name('form');
            Route::get('/', [PanduController::class, 'index'])->name('index');
            Route::get('/tambah', [PanduController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [PanduController::class, 'ubah'])->name('ubah');
            Route::post('/getdata', [PanduController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [PanduController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [PanduController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [PanduController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Deteksi Dini Form D
        Route::group(['prefix' => 'form_d', 'as' => 'form_d.'], function () {
            Route::get('/', function () {
                return view('ptm/deteksi_dini/form_d/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/deteksi_dini/form_d/form');
            })->name('form');
            Route::get('/', [FormDController::class, 'index'])->name('index');
            Route::get('/tambah', [FormDController::class, 'tambah'])->name('tambah');
            Route::get('/ubah/{id?}', [FormDController::class, 'ubah'])->name('ubah');
            Route::post('/getdata', [FormDController::class, 'getData'])->name('getdata');
            Route::post('/simpan', [FormDController::class, 'simpan'])->name('simpan');
            Route::delete('/delete/{id?}', [FormDController::class, 'hapus'])->name('hapus');
            Route::post('/cetak_pdf', [FormDController::class, 'cetak_pdf'])->name('cetak_pdf');
        });
        //Deteksi Dini Form E
        Route::group(['prefix' => 'form_e', 'as' => 'form_e.'], function () {
            Route::get('/', function () {
                return view('ptm/deteksi_dini/form_e/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/deteksi_dini/form_e/form');
            })->name('form');
        });
        //Deteksi Dini UBM
        Route::group(['prefix' => 'dd_ubm', 'as' => 'dd_ubm.'], function () {
            Route::get('/', function () {
                return view('ptm/deteksi_dini/ubm/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/deteksi_dini/ubm/form');
            })->name('form');
        });
        //Indikator SPM
        Route::group(['prefix' => 'indikator_spm', 'as' => 'indikator_spm.'], function () {
            Route::get('/', function () {
                return view('ptm/indikator/spm/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/indikator/spm/form');
            })->name('form');
        });
        //Profil SDM Terlatih
        Route::group(['prefix' => 'profil_sdm', 'as' => 'profil_sdm.'], function () {
            Route::get('/', function () {
                return view('ptm/profil/sdm/index');
            })->name('index');
            Route::get('/form', function () {
                return view('ptm/profil/sdm/form');
            })->name('form');
        });
        //Analisa Kasus PTM
        Route::group(['prefix' => 'analisa_kasus_ptm', 'as' => 'analisa_kasus_ptm.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/kasus_ptm/index');
            })->name('index');
        });
        //Analisa Kasus PTM Berdasarkan Usia
        Route::group(['prefix' => 'analisa_kasus_ptm_usia', 'as' => 'analisa_kasus_ptm_usia.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/kasus_ptm_usia/index');
            })->name('index');
        });
        //Analisa Kasus PTM Berdasarkan Jenis Kelamin
        Route::group(['prefix' => 'analisa_kasus_ptm_jenis_kelamin', 'as' => 'analisa_kasus_ptm_jenis_kelamin.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/kasus_ptm_jenis_kelamin/index');
            })->name('index');
        });
        //Analisa Kasus Jiwa
        Route::group(['prefix' => 'analisa_kasus_jiwa', 'as' => 'analisa_kasus_jiwa.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/kasus_jiwa/index');
            })->name('index');
        });
        //Analisa Kasus Jiwa Berdasarkan Usia
        Route::group(['prefix' => 'analisa_kasus_jiwa_usia', 'as' => 'analisa_kasus_jiwa_usia.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/kasus_jiwa_usia/index');
            })->name('index');
        });
        //Analisa Kasus Jiwa Berdasarkan Jenis Kelamin
        Route::group(['prefix' => 'analisa_kasus_jiwa_jenis_kelamin', 'as' => 'analisa_kasus_jiwa_jenis_kelamin.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/kasus_jiwa_jenis_kelamin/index');
            })->name('index');
        });
        //Analisa Penglihatan Pendenganran
        Route::group(['prefix' => 'analisa_penglihatan_pendengaran', 'as' => 'analisa_penglihatan_pendengaran.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/penglihatan_pendengaran/index');
            })->name('index');
        });
        //Analisa Hasil Prediksi Charta
        Route::group(['prefix' => 'analisa_hasil_charta', 'as' => 'analisa_hasil_charta.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/hasil_charta/index');
            })->name('index');
        });
        //Analisa Hasil Prediksi Charta
        Route::group(['prefix' => 'analisa_faktor_risiko', 'as' => 'analisa_faktor_risiko.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/faktor_risiko/index');
            })->name('index');
        });
        //Analisa Temuan IVA
        Route::group(['prefix' => 'analisa_temuan_iva', 'as' => 'analisa_temuan_iva.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/temuan_iva/index');
            })->name('index');
        });
        //AnalisaTemunan Sadanis
        Route::group(['prefix' => 'analisa_temuan_sadanis', 'as' => 'analisa_temuan_sadanis.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/temuan_sadanis/index');
            })->name('index');
        });
        //Analisa Temuan IVA dan KRIO
        Route::group(['prefix' => 'analisa_temuan_ivakrio', 'as' => 'analisa_temuan_ivakrio.'], function () {
            Route::get('/', function () {
                return view('ptm/analisa/temuan_ivakrio/index');
            })->name('index');
        });
    });
    //KIA (Kesehatan Ibu dan Anak)
    Route::group(['prefix' => 'manage/kia'], function(){

        Route::get('/manage/kia', [BerandaKiaController::class, 'index'])->name('manage.beranda.kia');

        //Data Dasar
        Route::group(['prefix' => 'datadasar', 'as' => 'datadasar.'], function () {
            Route::get('/', function () {
                return view('kia/datadasar/index');
            })->name('index');
            Route::get('/form', function () {
                return view('kia/datadasar/form');
            })->name('form');
        });

        //Kesehatan Ibu
        //ANC terintergrasi
        Route::group(['prefix' => 'anc', 'as' => 'anc.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_ibu/anc/index');
            })->name('index');
        });

        //Kematian Ibu
        Route::group(['prefix' => 'kematian_ibu', 'as' => 'kematian_ibu.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_ibu/kematian_ibu/index');
            })->name('index');
            Route::get('/form', function () {
                return view('kia/kesehatan_ibu/kematian_ibu/form');
            })->name('form');
        });

        //Komplikasi Ibu
        Route::group(['prefix' => 'komplikasi_ibu', 'as' => 'komplikasi_ibu.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_ibu/komplikasi_ibu/index');
            })->name('index');
            Route::get('/form', function () {
                return view('kia/kesehatan_ibu/komplikasi_ibu/form');
            })->name('form');
        });

        //PWS
        Route::group(['prefix' => 'pws', 'as' => 'pws.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_ibu/pws/index');
            })->name('index');
            Route::get('/form', function () {
                return view('kia/kesehatan_ibu/pws/form');
            })->name('form');
        });

        //Kesehatan Anak
        //Cakupan Program 1
        Route::group(['prefix' => 'cakupan_program_a', 'as' => 'cakupan_program_a.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_anak/cakupan_program_a/index');
            })->name('index');
        });

        //Cakupan Program 2
        Route::group(['prefix' => 'cakupan_program_b', 'as' => 'cakupan_program_b.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_anak/cakupan_program_b/index');
            })->name('index');
        });

        //Cakupan Program 3
        Route::group(['prefix' => 'cakupan_program_c', 'as' => 'cakupan_program_c.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_anak/cakupan_program_c/index');
            })->name('index');
        });

        //Data Sarana Program
        Route::group(['prefix' => 'data_sarana_program', 'as' => 'data_sarana_program.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_anak/data_sarana_program/index');
            })->name('index');
        });

        //Kematian Dan Kelahiran Bayi
        Route::group(['prefix' => 'kematian_bayi_lh', 'as' => 'kematian_bayi_lh.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_anak/kematian_bayi_lahir_hidup/index');
            })->name('index');
        });

        //SDM Program Anak
        Route::group(['prefix' => 'sdm_program_anak', 'as' => 'sdm_program_anak.'], function () {
            Route::get('/', function () {
                return view('kia/kesehatan_anak/sdm_program_anak/index');
            })->name('index');
        });

        //Menu Lainnya
        //bufas Vitamin A
        Route::group(['prefix' => 'bufas_vitamin_a', 'as' => 'bufas_vitamin_a.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/bufas_vitamin_a/index');
            })->name('index');
        });

        //Bumil Fe 1
        Route::group(['prefix' => 'bumil_fe_1', 'as' => 'bumil_fe_1.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/bumil_fe_1/index');
            })->name('index');
        });

        //Bumil Fe 3
        Route::group(['prefix' => 'bumil_fe_3', 'as' => 'bumil_fe_3.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/bumil_fe_3/index');
            })->name('index');
        });

        //Dikun Bayi
        Route::group(['prefix' => 'dukun_bayi', 'as' => 'dukun_bayi.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/dukun_bayi/index');
            })->name('index');
        });

        //Ibu Bersalin
        Route::group(['prefix' => 'ibu_bersalin', 'as' => 'ibu_bersalin.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/ibu_bersalin/index');
            })->name('index');
        });

        //Kehamilan yang tidak diinginkan
        Route::group(['prefix' => 'kehamilan_tidak_diinginkan', 'as' => 'kehamilan_tidak_diinginkan.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/kehamilan_tidak_diinginkan/index');
            })->name('index');
        });

        //Kunjungan Nifas
        Route::group(['prefix' => 'kunjungan_nifas', 'as' => 'kunjungan_nifas.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/kunjungan_nifas/index');
            })->name('index');
        });

        //Persalinan Nakes
        Route::group(['prefix' => 'persalinan_nakes', 'as' => 'persalinan_nakes.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/persalinan_nakes/index');
            })->name('index');
        });

        //Status TT Bumil
        Route::group(['prefix' => 'status_tt_bumil', 'as' => 'status_tt_bumil.'], function () {
            Route::get('/', function () {
                return view('kia/lainnya/status_tt_bumil/index');
            })->name('index');
        });

    });
});
