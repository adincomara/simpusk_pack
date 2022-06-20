<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\DetailPengeluaranObat;
use App\Models\Simpusk\Obat;
use Illuminate\Http\Request;
use App\Models\Simpusk\PengeluaranObat;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Pegawai;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\User;
use App\Models\Simpusk\Pelayananpoli;
use App\Models\Simpusk\Pelayananpolidiagnosa;
use App\Models\Simpusk\Pelayananpoliresep;
use App\Models\Simpusk\StokObat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;

class PengeluaranObatController extends Controller
{
    protected $original_column = array(
        1 => "id_pengeluaran",
        2 => "no_terima_obat",
        3 => "nama_pasien",
        4 => "keterangan",
        5 => "tgl_serah_obat",
        6 => "id_pendaftaran"
    );


    public function index()
    {

        return view('apotik/pengeluaran_obat');
    }


    public static function noPengeluaranOtomatis(){
        $today = date('Y-m-d');
        // mencari kode barang dengan nilai paling besar
       // $maxPengeluaran = PengeluaranObat::selectRaw('max(id_pengeluaran) AS maxPengeluaran')->where('tgl_serah_obat',$today)->first();
        $maxPengeluaran = PengeluaranObat::max('id_pengeluaran');

        $kode = $maxPengeluaran;

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

        $records = PengeluaranObat::select('*')->orderBy('id_pengeluaran','DESC');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }

        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('no_terima_obat', 'LIKE', "%{$search}%");
                $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
                $query->orWhere('keterangan', 'LIKE', "%{$search}%");
                $query->orWhere('tgl_serah_obat', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id_pengeluaran));
            $action = "";


            // if ($request->user()->can('pengeluaran_obat.ubah')) {
                $action .= '<a href="' . route('pengeluaran_obat.detail', $enc_id) . '" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Detail"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
            // }
            // if ($request->user()->can('pengeluaran_obat.hapus')) {
            //     $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            // }

            $record->no             = $key + $page;
            $record->no_terima_obat  = $record->no_terima_obat;
            $record->nama_pasien  = $record->nama_pasien;
            $record->keterangan      = $record->keterangan;
            $record->tgl_serah_obat      = $record->tgl_serah_obat;
            $record->id_pendaftaran      = $record->id_pendaftaran;
            $record->action         = $action;
        }
        if ($request->user()->can('pengeluaran_obat.index')) {
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
    public function getDataPendaftaran(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];
        $records = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pendaftaran.status_pasien', 'tbl_poli.nama_poli')
                                ->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')
                                ->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')
                                ->leftJoin('tbl_pengeluaran_obat','tbl_pendaftaran.id','tbl_pengeluaran_obat.id_pendaftaran')
                                ->whereNull('tbl_pengeluaran_obat.id_pengeluaran')
                                ->where('tbl_pendaftaran.flag_periksa', 1)
                                ->orderBy('tbl_pendaftaran.no_rawat', 'DESC');

        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }else{
            $records->orderBy('id','DESC');
          }

         if($search) {
          $records->where(function ($query) use ($search) {
                  $query->orWhere('tbl_pendaftaran.no_rawat','LIKE',"%{$search}%");
                  $query->orWhere('tbl_pendaftaran.no_rekamedis','LIKE',"%{$search}%");
                  $query->orWhere('tbl_pasien.nama_pasien','LIKE',"%{$search}%");
                  $query->orWhere('tbl_pasien.status_pasien','LIKE',"%{$search}%");
                  $query->orWhere('tbl_poli.nama_poli','LIKE',"%{$search}%");
          });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);

        $data = $records->get();
        foreach ($data as $key=> $record)
        {
          $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
          $action = "";

          $action .= '<a href="' . route('pengeluaran_obat.tambah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Pilih/Proses"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';

          $record->no             = $key+$page;
          $record->DT_RowId       = $record->id;
          $record->no_rawat       = $record->no_rawat;
          $record->no_rekamedis   = $record->no_rekamedis;
          $record->nama_pasien    = $record->nama_pasien;
          $record->status_pasien  = $record->status_pasien;
        //   $pelayanan_poli = Pelayananpoli::where('pendaftaran_id',$record->id)->first();
        //   $pegawai = Pegawai::where('id_pegawai',$pelayanan_poli->dokter_id)->first();
        //   $record->nama_pegawai   = $pegawai->nama_pegawai;
          $record->nama_poli      = $record->nama_poli;
          $record->action         = $action;
        }

        if ($request->user()->can('pengeluaran_obat.proses_resep')) {
          $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );
        }else{
           $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => []
                    );
        }
        return json_encode($json_data);
    }
    public function getDataPendaftaran_(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];
        $records = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pendaftaran.status_pasien',
        'tbl_poli.nama_poli')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')->leftJoin('tbl_pengeluaran_obat','tbl_pendaftaran.id','tbl_pengeluaran_obat.id_pendaftaran')->where('tbl_pendaftaran.flag_periksa',1)->whereNull('tbl_pengeluaran_obat.id_pengeluaran');

        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }

         if($search) {
          $records->where(function ($query) use ($search) {
                  $query->orWhere('no_rawat','LIKE',"%{$search}%");
                  $query->orWhere('no_rekamedis','LIKE',"%{$search}%");
                  $query->orWhere('nama_pasien','LIKE',"%{$search}%");
                  $query->orWhere('status_pasien','LIKE',"%{$search}%");
                  $query->orWhere('tbl_pegawai.nama_pegawai','LIKE',"%{$search}%");
                  $query->orWhere('poli.nama_poli','LIKE',"%{$search}%");
          });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key=> $record)
        {
          $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
          $action = "";

          if($request->user()->can('pengeluaran_obat.proses_resep')){
            $action .= '<a href="' . route('pengeluaran_obat.tambah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Pilih/Proses"><i class="fa fa-pencil"></i></a>&nbsp;';
          }

          $record->no             = $key+$page;
          $record->DT_RowId       = $record->id;
          $record->no_rawat       = $record->no_rawat;
          $record->no_rekamedis   = $record->no_rekamedis;
          $record->nama_pasien    = $record->nama_pasien;
          $record->status_pasien  = $record->status_pasien;
        //   $pelayanan_poli = Pelayananpoli::where('pendaftaran_id',$record->id)->first();
        //   $pegawai = Pegawai::where('id_pegawai',$pelayanan_poli->dokter_id)->first();
        //   $record->nama_pegawai   = $pegawai->nama_pegawai;
          $record->nama_poli      = $record->nama_poli;
          $record->action         = $action;
        }

        if ($request->user()->can('pengeluaran_obat.proses_resep')) {
          $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );
        }else{
           $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => []
                    );
        }
        return json_encode($json_data);
    }

    public function proses_resep()
    {
        return view('apotik_dll/proses_resep_obat');
    }

    public function tambah($enc_id)
    {

        // return $enc_id;
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

        if ($dec_id) {
            $obat = Obat::all();


             $pendaftaran = $this->getPendaftaran($dec_id);
            $pendaftaran = Pendaftaran::where('id', $dec_id)->first();
            // return $pendaftaran->pelayanan_poli->poli_diagnosa;
            // return $pendaftaran->pelayanan_poli->poli_diagnosa[0]->nama_diagnosa;
            $batch = array();
            foreach($pendaftaran->pelayanan_poli->poli_resep as $p){
               // return $p->obat->id;
                $batch[] = StokObat::where('id_obat',$p->id)->get();
            }
            //return $batch[];

            $noTrans = "S-".date("ymd")."-".$this->noPengeluaranOtomatis();
            $noPengeluaran = $this->noPengeluaranOtomatis();

            // return $pendaftaran->pelayanan_poli->poli_resep[0]->obat;
            return view('apotik_form/pengeluaran_obat_form',[
                'noPengeluaran' => $noPengeluaran,
                'noTrans' => $noTrans,
                'pendaftaran' => $pendaftaran,
                'obat' => $obat,
                'batch_obat' => $batch
            ]);
        } else {
            return view('errors/noaccess');
        }

    }

    public function detail($enc_id)
    {
        // return $enc_id;
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $pengeluaran_obat = PengeluaranObat::find($dec_id);
            $pendaftaran = Pendaftaran::find($pengeluaran_obat->id_pendaftaran);
            // return $pendaftaran;
            // $pendaftaran = $this->getPendaftaran($pengeluaran_obat->id_pendaftaran);
            $id_pengeluaran_obat = PengeluaranObat::select('id_pengeluaran')->where('id_pendaftaran',$pendaftaran->id)->first();
            // return $id_pengeluaran_obat;
            $detailPengeluaranObat = DetailPengeluaranObat::where('id_pengeluaran_obat',$id_pengeluaran_obat->id_pengeluaran)->get();
            $pendaftaran->detailpengeluaranobat = $detailPengeluaranObat;
            // return response()->json([
            //     'data' => $pendaftaran,
            //     'obat' => $id_pengeluaran_obat,
            //     'detail_pengeluaran' => $detailPengeluaranObat
            // ]);
            return view('apotik_dll/pengeluaran_obat_detail', compact('enc_id', 'pengeluaran_obat'))->with('pendaftaran',$pendaftaran);
        } else {
            return view('errors/noaccess');
        }

    }

    public static function getPendaftaran($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::where('id',$id_pendaftaran)->first();

        if($pendaftaran!=null){

            $pendaftaran->pasien = Pasien::where('no_rekamedis',$pendaftaran->no_rekamedis)->first();
            $pendaftaran->poli = Poli::where('id',$pendaftaran->id_poli)->first();
            $pelayanan_poli = Pelayananpoli::where('pendaftaran_id', $id_pendaftaran)->first();
            if($pelayanan_poli!=null){

                $pendaftaran->dokter = Pegawai::where('id_pegawai',$pelayanan_poli->dokter_id)->first();
                $pelayanan_poli->diagnosa = Pelayananpolidiagnosa::where('pelayanan_poli_id',$pelayanan_poli->id)->get();
                $resep = Pelayananpoliresep::where('pelayanan_poli_id',$pelayanan_poli->id)->get();
                // return $resep;


                foreach ($resep as $value) {
                    $value->obat = Obat::where('id',$value->obat_id)->first();
                }
                $pelayanan_poli->resep = $resep;
                $pendaftaran->pelayanan_poli = $pelayanan_poli;

            }

            return $pendaftaran ;
        }
    }
    // ubah : Form ubah data
    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $pengeluaran_obat = PengeluaranObat::find($dec_id);

            return view('backend/pengeluaran_obat/form', compact('enc_id', 'pengeluaran_obat'));
        } else {
            return view('errors/noaccess');
        }
    }

    public function simpan(Request $req)
    {
        // return $req->all();
        date_default_timezone_set("Asia/Bangkok");
        // $enc_id     = $req->enc_id;

        // $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

        $checkdata = PengeluaranObat::where('id_pendaftaran', $req->id_pendaftaran)->first();
        if ($checkdata) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data resep sudah diproses, obat sudah diberikan.'
            );
        } else {

            // for($v=1;$v<=$req->total_obat;$v++){
            //     $cekstokobat = StokObat::where('id', $req->input('batch_obat_'.$v))->first();
            //     if($cekstokobat->stok_obat < $req->input('jumlah_'.$v)){
            //         $json_data = array(
            //             "success"         => FALSE,
            //             "message"         => 'Stok gagal di update.'
            //         );
            //         return json_encode($json_data);
            //     }
            // }

            $pendaftaran = Pendaftaran::find($req->id_pendaftaran);
            // return $pendaftaran;
            // $pendaftaran = $this->getPendaftaran($req->id_pendaftaran);
            $pengeluaran_obat = new PengeluaranObat;
            // $pengeluaran_obat->no_rawat = $req->no_rawat;
            $pengeluaran_obat->no_terima_obat  = $req->no_terima_obat;
            $pengeluaran_obat->nama_pasien  = $pendaftaran->pasien->nama_pasien;
            $pengeluaran_obat->keterangan      = $req->keterangan;
            $pengeluaran_obat->tgl_serah_obat      = date('d-m-Y');
            $pengeluaran_obat->id_pendaftaran      = $req->id_pendaftaran;
            $pengeluaran_obat->save();


            if ($pengeluaran_obat) {

                if($req->total_obat > 0){
                    for($i=1;$i<=$req->total_obat;$i++){
                       // return $req->input('aturan_pakai_obat_'.$i);


                        if($req->input('obat_'.$i) > 0){
                            $obt = $req->input('obat_'.$i);
                            if(isset($obt)){

                                $obat = Obat::where('id',$obt)->first();
                                //return "tes";
                                $detailPengeluaranObat = new DetailPengeluaranObat();
                                $detailPengeluaranObat->id_pengeluaran_obat = $pengeluaran_obat->id_pengeluaran;
                                $detailPengeluaranObat->id_obat = $req->input('obat_'.$i);
                                $detailPengeluaranObat->kode_obat = $obat->kode_obat;
                                $detailPengeluaranObat->nama_obat = $obat->nama_obat;
                                $detailPengeluaranObat->jenis_obat = $obat->jenis_obat;
                                $detailPengeluaranObat->dosis_aturan_obat = $req->input('aturan_pakai_obat_'.$i);
                                $detailPengeluaranObat->jumlah = $req->input('jumlah_'.$i);
                                $detailPengeluaranObat->satuan = $obat->satuan;
                                $detailPengeluaranObat->save();
                                if(!$detailPengeluaranObat){
                                    $json_data = array(
                                        "success"         => FALSE,
                                        "message"         => 'Salah satu data gagal ditambahkan.'
                                    );
                                    return json_encode($json_data);
                                }

                                $allstokObat = StokObat::where('id_obat',$req->input('obat_'.$i))->orderBy('tgl_expired_obat','ASC')->get();
                                $input_jumlah_obat = $req->input('jumlah_'.$i);


                                if($allstokObat){

                                    foreach($allstokObat as $stkobat){
                                        $stokObat = StokObat::where('id', $stkobat->id)->first();
                                        $jumlah_real_stok = $stkobat->stok_obat;
                                        if($jumlah_real_stok >= $input_jumlah_obat){
                                            $stokObat->stok_obat = $jumlah_real_stok - $input_jumlah_obat;
                                            $stokObat->save();
                                            break;
                                        }
                                        else{

                                            $input_jumlah_obat = $input_jumlah_obat - $jumlah_real_stok;
                                            $stokObat->delete();
                                        }

                                    }
                                    if(!$stokObat){
                                        $json_data = array(
                                            "success"         => FALSE,
                                            "message"         => 'Stok gagal di update.'
                                        );
                                        return json_encode($json_data);
                                    }
                                }

                            }
                        }

                    }
                }
                // foreach ($pendaftaran->pelayanan_poli->resep as $item) {
                //     $detailPengeluaranObat = new DetailPengeluaranObat();
                //     $detailPengeluaranObat->id_pengeluaran_obat = $pengeluaran_obat->id_pengeluaran;
                //     $detailPengeluaranObat->id_obat = $item->obat_id;
                //     $detailPengeluaranObat->kode_obat = $item->obat->kode_obat;
                //     $detailPengeluaranObat->nama_obat = $item->obat->nama_obat;
                //     $detailPengeluaranObat->jenis_obat = $item->obat->jenis_obat;
                //     $detailPengeluaranObat->dosis_aturan_obat = $item->aturan_pakai;
                //     $detailPengeluaranObat->jumlah = $item->jumlah;
                //     $detailPengeluaranObat->satuan = $item->obat->satuan;
                //     $detailPengeluaranObat->save();

                //     $stokObat = StokObat::where('id_obat',$item->obat_id)->first();
                //     if($stokObat){
                //         $jumlah_real_stok = $stokObat->jumlah;
                //         $stokObat->jumlah = $jumlah_real_stok - $item->jumlah;
                //         $stokObat->save();
                //     }else{
                //         $stokObat = new StokObat;
                //         $stokObat->id_obat = $item->obat_id;
                //         $stokObat->jumlah = $item->jumlah;
                //         $stokObat->satuan = $item->obat->satuan;
                //         $stokObat->save();
                //     }
                // }

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
        $pengeluaran_obat = PengeluaranObat::find($dec_id);


        if ($pengeluaran_obat) {
            $detailPengeluaranObat = DetailPengeluaranObat::where('id_pengeluaran_obat',$dec_id)->get();
            return $detailPengeluaranObat;
            foreach ($detailPengeluaranObat as $value) {
                $stokObat = StokObat::where('id_obat',$value->id_obat)->get();
                return $stokObat;
                $jumlah_real_stok = $stokObat->jumlah;
                $update_jumlah = (int) $jumlah_real_stok - (int) $value->jumlah;
                $stokObat->jumlah = $update_jumlah;
                $stokObat->save();
            }
            $pengeluaran_obat->delete();
            return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
        }
    }

    public function cetakBeriObat(Request $request)
    {
       $pengeluaran_obat = PengeluaranObat::all();
       //dd($pengeluaran_obat);
       $config = [
          'mode'                  => '',
          'format'                => 'A4',
          'default_font_size'     => '11',
          'default_font'          => 'sans-serif',
          'margin_left'           => 8,
          'margin_right'          => 8,
          'margin_top'            => 30,
          'margin_bottom'         => 10,
          'margin_header'         => 0,
          'margin_footer'         => 0,
          'orientation'           => 'L',
          'title'                 => 'DATA PEMBERIAN OBAT PUSKESMAS',
          'author'                => '',
          'watermark'             => '',
          'show_watermark'        => true,
          'show_watermark_image'  => true,
          'watermark_font'        => 'sans-serif',
          'display_mode'          => 'fullpage',
          'watermark_text_alpha'  => 0.2,
      ];

      $pdf = PDF::loadView('laporan_dll/cetak_pemberian_obat', ['pengeluaran_obat'=>$pengeluaran_obat],[],$config);
      ob_get_clean();
      return $pdf->download('Data Pemberian Obat_'.date('d_m_Y H_i_s').'.pdf');
      //download : langsung download
      //stream : open preview
    }
    public function addObat(Request $req){
        $total = $req->total;
        $Obats = Obat::all();

        echo"
        <tr id='dataAjaxObat_".$total."'>
          <td width='30%'><select id='obat_".$total."' name='obat_".$total."' class='select2_obat_".$total." form-control mb-1' required>
          <option value='0' selected disabled>Pilih Obat</option> ";
        // foreach($Obats as $obat){
        //     $stk = StokObat::where('id_obat',$obat->id)->sum('stok_obat');
        //     if($stk > 0){
        //         echo"
        //         <option value=".$obat->id.">".$obat->kode_obat." - ".$obat->nama_obat."</option>";
        //     }

        //       }
              echo"
      </select></td>

          <td><input type='number' min='1' value='1' class='form-control form-control-sm mb-1' name='jumlah_".$total."' id='jumlah_".$total."' required></td>
          <td><input type='text' class='form-control form-control-sm mb-1' name='aturan_pakai_obat_".$total."' id='aturan_pakai_obat_".$total."' value='3x1, Setelah Makan'></td>
          <td><a href='#!' onclick='javascript:deleteObat(".$total.")' class='btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip' title='Hapus'><i class='fa fa-close'></i></a></td>

        </tr>


          <script>
            $(function () {
                $('.select2_batch_obat').select2();
                $('.select2_obat_".$total."').select2({

                    placeholder: 'Pilih Obat',
                    ajax: {
                        url: '".route('pelayanan_poli.searchObat')."',
                        dataType: 'JSON',
                        data: function(params) {
                        return {
                            search: params.term
                        }
                        },
                        processResults: function (data) {
                        var results = [];
                        $.each(data, function(index, item){
                            results.push({
                                id: item.id,
                                text : item.kode_obat+' - '+item.nama_obat,
                            });
                        });
                        return{
                            results: results
                        };
                        }
                    }
                })
            })
        </script>

          <script>
            function deleteObat(id){

              Swal.fire({
                  title: 'Apakah Anda yakin?',
                  text: 'Data akan terhapus!',

                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Ya',
                  cancelButtonText:'Batal',
                  confirmButtonColor: '#ec6c62',
                  closeOnConfirm: false
                }).then(function(result){
                  if(result.value){
                      $('#dataAjaxObat_'+id).remove();

                  }


              });



            }
            </script>
            <script>
                $('#obat_".$total."').on('change', function(){
                    $.ajax({
                        type: 'POST',
                        url: '".route('pengeluaran_obat.batch_obat')."',
                        headers: {'X-CSRF-TOKEN': $('[name=\"_token\"]').val()},
                        data: {id_obat : this.value},
                        success: function(data){
                            $('#batch_obat_".$total."').attr('disabled', false);
                            $('#batch_obat_".$total."').html(data);
                        }
                    });
                });
            </script>


        ";

      }
      public function batch_obat(Request $request){
          //return $request->all();
          $stok_obat = StokObat::where('id_obat', $request->id_obat)->orderBy('tgl_expired_obat', 'ASC')->get();
          $obat = Obat::where('id', $request->id_obat)->first();
          echo"
            <select id='batch_obat' name='name_obat' class='select2 form-control mb-1'>
          ";foreach($stok_obat as $stok){
              if($stok->stok_obat > 0 || strtotime($stok->tgl_expired_obat) < strtotime(Carbon::today()) ){
                  echo"<option value='".$stok->id."'>".$stok->batch_obat." | ".$stok->tgl_expired_obat." | ".$stok->stok_obat." </option>";
              }
          }echo"</select>";
      }
}
