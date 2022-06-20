<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\DetailPengadaanObat;
use App\Models\Simpusk\PengadaanObat;
use App\Models\Simpusk\StokObat;
use App\Models\Simpusk\Obat;
use App\Models\Simpusk\Supplier;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;
use Excel;
use App\Exports\PengadaanObatExport;

class PengadaanObatController extends Controller
{
    protected $original_column = array(
        1 => "id_pengadaan",
        2 => "no_trans",
        3 => "keterangan",
        4 => "total",
        5 => "tgl_transaksi"
    );


    public function index()
    {
        return view('apotik/pengadaan_obat');
    }


    public static function noPengadaOtomatis(){
        $today = date('d-m-Y');
       // return $today;
        // mencari kode barang dengan nilai paling besar
        $maxPengadaann = PengadaanObat::where('tgl_transaksi', $today)->get();
        $maxPengadaan = count($maxPengadaann);
        $kode = $maxPengadaan;
        $noUrut = (int) substr($kode, 0, 4);
        $noUrut++;
        $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                              //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
        return $kodeBaru;
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = PengadaanObat::select('*');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }

        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('no_trans', 'LIKE', "%{$search}%");
                $query->orWhere('keterangan', 'LIKE', "%{$search}%");
                $query->orWhere('total', 'LIKE', "%{$search}%");
                $query->orWhere('tgl_transaksi', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();
        $records->orderBy('id_pengadaan', 'DESC');
        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id_pengadaan));
            $action = "";

            if ($request->user()->can('pengadaan_obat.detail')) {
                $action .= '<a href="' . route('pengadaan_obat.detail', $enc_id) . '" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Detail"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
            }
            if ($request->user()->can('pengadaan_obat.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            }




            $record->no             = $key + $page;
            $record->no_trans  = $record->no_trans;
            $record->keterangan      = $record->keterangan;
            $record->total_jumlah      = $record->total_jumlah;
            $record->total_harga      = $record->total_harga;
            $record->tgl_transaksi      = $record->tgl_transaksi;

            $record->action         = $action;
        }
        if ($request->user()->can('pengadaan_obat.index')) {
            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );
        } else {
            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => 0,
                "recordsFiltered" => 0,
                "data"            => []
            );
        }
        return json_encode($json_data);
    }
    public function searchSuplier(Request $request){
        $query = Supplier::orWhere('kode_supplier', 'LIKE', "%{$request->search}%");
        $query->orWhere('nama_supplier', 'LIKE', "%{$request->search}%")
                ->limit(15);
        $suppliers = $query->get();

        return json_encode($suppliers);
    }
    function safe_encode($string)
    {
        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }
    function safe_decode($string, $mode = null)
    {
        $data = str_replace(array('_'), array('/'), $string);
        return $data;
    }
    public function tambah()
    {
        //return $this->noPengadaOtomatis();
        $noTrans = "B-".date("ymd")."-".$this->noPengadaOtomatis();
        //return $noTrans;
        $noPengadaan = $this->noPengadaOtomatis();
        $obats = Obat::all();
        $suppliers = Supplier::all();
        return view('apotik_form/pengadaan_obat_form')->with('noPengadaan',$noPengadaan)->with('noTrans',$noTrans)->with('obats',$obats)->with('suppliers',$suppliers);
    }
    // ubah : Form ubah data
    public function detail($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $pengadaan_obat = PengadaanObat::find($dec_id);
            $detailPengadaan = DetailPengadaanObat::where('id_pengadaan_obat',$dec_id)->get();
            foreach ($detailPengadaan as $key => $value) {
                $value->obat = Obat::where('id', $value->id_obat)->first();
                $value->supplier = Supplier::where('kode_supplier', $value->id_supplier)->first();
                $value->batch_obat = StokObat::where('id', $value->id_batch_obat)->first();
            }
            //return $detailPengadaan;
            $pengadaan_obat->detailPengadaan = $detailPengadaan;

            $obats = Obat::all();
            $suppliers = Supplier::all();

            return view('apotik_dll/pengadaan_obat_detail', compact('enc_id', 'pengadaan_obat'))->with('obats',$obats)->with('suppliers',$suppliers);
        } else {
            return view('errors/noaccess');
        }
    }

    public function simpan(Request $req)
    {
        // var_dump($req->id_pengadaan);
        // return $req->all();
        date_default_timezone_set("Asia/Bangkok");
        $checkdata = PengadaanObat::find($req->no_trans);

        if ($checkdata) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'No transaksi sudah terdaftar.'
            );
        } else {
            $pengadaan_obat = new PengadaanObat;

            // $pengadaan_obat->id_pengadaan  = $req->id_pengadaan;
            $pengadaan_obat->no_trans  = $req->no_trans;
            $pengadaan_obat->keterangan      = $req->keterangan;
            $pengadaan_obat->total_jumlah      = $req->total_jumlah;
            $pengadaan_obat->total_harga      = $req->total_harga;
            $pengadaan_obat->tgl_transaksi      = date('d-m-Y');
            $pengadaan_obat->save();

            if ($pengadaan_obat) {


                for ($i=0; $i < $req->count; $i++) {
                    if (isset($req['obat_'.$i])) {
                        if($req['obat_'.$i] != null) {
                            $stok_obat = StokObat::where('id',$req['batch_obat_'.$i])->first();
                            if($stok_obat){
                                $stok_obat->stok_obat = $stok_obat->stok_obat + $req['jumlah_'.$i];
                                $stok_obat->save();
                            }else{
                                $stok_obat = new StokObat;
                                $stok_obat->id_obat = $req['obat_'.$i];
                                $stok_obat->batch_obat = $req['batch_obat_'.$i];
                                $stok_obat->tgl_expired_obat = $req['tgl_expired_obat_'.$i];
                                $stok_obat->stok_obat = $req['jumlah_'.$i];
                                $stok_obat->save();
                            }
                           // return $stok_obat;
                            $detail = new DetailPengadaanObat;
                            $detail->id_pengadaan_obat = $pengadaan_obat->id_pengadaan;
                            $detail->id_obat = $req['obat_'.$i];
                            $detail->id_supplier = $req['supplier_'.$i];
                            $detail->jumlah = $req['jumlah_'.$i];
                            $detail->harga_beli = $req['harga_'.$i];
                            $detail->id_batch_obat = $stok_obat->id;
                            $detail->total_harga = $req['total_'.$i];
                            $detail->save();
                        }
                    }
                }
                $json_data = array(
                    "success"         => TRUE,
                    "message"         => 'Data berhasil ditambahkan.'
                );

            } else {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => 'Data gagal ditambahkan.'
                );
            }
        }
        return json_encode($json_data);
    }

    public function hapus(Request $req, $enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $pengadaan_obat = PengadaanObat::find($dec_id);

        if ($pengadaan_obat) {
            $detail_pengadaan_obat = DetailPengadaanObat::where('id_pengadaan_obat', $pengadaan_obat->id_pengadaan)->get();
            foreach ($detail_pengadaan_obat as $key => $value) {
                $stok_obat = StokObat::where('id_obat',$value->id_obat)->first();
                if($stok_obat){
                    $stok_obat->jumlah = $stok_obat->jumlah - $value->jumlah;
                    $stok_obat->save();
                }
            }
            $pengadaan_obat->delete();
            return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
        }
    }

    public function cetak(Request $request)
    {
       $pengadaan_obat = PengadaanObat::all();
       $config = [
        'mode'                  => '',
        'format'                => 'A4',
        'default_font_size'     => '9',
        'default_font'          => 'sans-serif',
        'margin_left'           => 8,
        'margin_right'          => 8,
        'margin_top'            => 30,
        'margin_bottom'         => 10,
        'margin_header'         => 0,
        'margin_footer'         => 0,
        'orientation'           => 'L',
        'title'                 => 'DATA SUPPLIER',
        'author'                => '',
        'watermark'             => '',
        'show_watermark'        => true,
        'show_watermark_image'  => true,
        'watermark_font'        => 'sans-serif',
        'display_mode'          => 'fullpage',
        'watermark_text_alpha'  => 0.2,
    ];


    foreach($pengadaan_obat as $key=> $item){
        $item->no = $key+1;
        $detailPengadaan = DetailPengadaanObat::where('id_pengadaan_obat',$item->id_pengadaan)->get();
        foreach ($detailPengadaan as $key => $value) {
            $value->obat = Obat::where('id', $value->id_obat)->first();
            $value->supplier = Supplier::where('kode_supplier', $value->id_supplier)->first();
        }
        $item->detailPengadaan = $detailPengadaan;
        $item->length_detail = sizeof($detailPengadaan);
    }
    //return $pengadaan_obat;
    $pdf = PDF::loadView('apotik_dll/pengadaan_obat_cetak', ['pengadaan_obat'=>$pengadaan_obat],[],$config);
    ob_get_clean();
    return $pdf->download('Data Pengadaan Obat_'.date('d_m_Y H_i_s').'.pdf');
    //download : langsung download
    //stream : open preview
    // return view('backend.pengadaan_obat.cetak')->with(['pengadaan_obat'=>$pengadaan_obat]);
    }
    public function laporanExcel(Request $request)
    {

      return Excel::download(new PengadaanObatExport(),'Data Pengadaan Obat"'.date('d_m_Y H_i_s').'".xlsx');
    }
}
