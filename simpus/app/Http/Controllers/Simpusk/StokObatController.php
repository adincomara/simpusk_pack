<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\StokObat;
use App\Models\Simpusk\Obat;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;
use Excel;
use App\Exports\StokObatExport;
use Carbon\Carbon;

class StokObatController extends Controller
{
    protected $original_column = array(
        1 => "id_obat",
        2 => "jumlah",
    );


    public function index()
    {
        return view('apotik/data_stok_obat');
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = StokObat::distinct()->select('id_obat')->whereHas('get_obat');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }

        if ($search) {
            $id = array();
            $key = Obat::where('nama_obat', 'LIKE', "%{$search}%")->orWhere('kode_obat', 'LIKE', "%{$search}%")->get('id');
            foreach($key as $k){
                $id[] = $k->id;
            }


            $records->where(function ($query) use ($search) {
                $query->orWhere('id_obat', 'LIKE', "%{$search}%");
            })->orWhere(function($query) use ($id){
                if($id){
                    $query->orWhereIn('id_obat', $id);
                }

            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {

                $obat = Obat::where('id', $record->id_obat)->first();
            if(isset($obat)){
                $enc_id = $this->safe_encode(Crypt::encryptString($record->id_obat));
                $action = "";

                $action .= '<a href="#!" onclick="detail_data(\''.$enc_id.'\')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Detail"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
                if ($request->user()->can('stok_obat.ubah')) {
                    $action .= '<a href="' . route('stok_obat.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
                }
                if ($request->user()->can('stok_obat.hapus')) {
                    $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
                }





                $record->no             = $key + $page;
                $record->DT_RowId       = $record->id;
                $record->kode_obat  = $obat['kode_obat'];
                $record->nama_obat  = $obat['nama_obat'];
                $stokobat = number_format(StokObat::where('id_obat', $record->id_obat)->sum('stok_obat'), 0, '','.');
                $record->stok_obat  = $stokobat;

                $record->action         = $action;

            }
        }
        if ($request->user()->can('stok_obat.index')) {
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
    public function tambah()
    {

        $obats = Obat::get();
        return view('apotik_form/stok_obat_form')->with('obats',$obats);
    }
    public function batch_obat(Request $req){
        //return $req->all();
        if($req->index){
            $index = $req->index;
            $stok_obat = StokObat::where('id_obat', $req->id_obat)->get();
            //return $stok_obat;
            $input = "<input type='text' name='batch_obat_".$index."' id='batch_obat_".$index."' class='form-control form-control-sm'>";
        //     if(count($stok_obat) > 0){
        //         $data['batch']= "";
        //         $data['batch'] .="
        //         <select name='batch_obat_".$index."' id='batch_obat_".$index."' class='form-control select2' style='width:100%'>";
        //         foreach($stok_obat as $obat){
        //            $data['batch'] .=" <option value='".$obat->id."'>".$obat->batch_obat."</option>";
        //         }
        //        $data['batch'] .=" <option value='tambah'>Tambah Batch </option></select>
        //         <script>

        //         var id_obat = $('#id_obat').val();
        //         var input_batch = $('#batch_obat_".$index."').val();
        //         $('#batch_obat_".$index."').on('change', function(){

        //             ";foreach($stok_obat as $obat){
        //                 $tgl = $obat->tgl_expired_obat;
        //                $data['batch'] .="if(this.value == ".$obat->id."){
        //                     $('#stok_obat').val(".$obat->stok_obat.");
        //                     $('#tgl_expired_obat_".$index."').val(\"$tgl\");
        //                 }";
        //             }$tgl = date('Y-m-d');$data['batch'] .="
        //             if(this.value == 'tambah'){

        //                 $('#input_batch_".$index."').html(\"$input\");
        //                 $('#tgl_expired_obat_".$index."').val(\"$tgl\");
        //                 $('#tgl_expired_obat_".$index."').prop('readonly', false);
        //                 $('#stok_obat').val('');
        //             }
        //         });
        //         </script>";
        //         $data['tgl']= date('Y-m-d', strtotime($stok_obat[0]->tgl_expired_obat));
        //         return $data;
        //     }
        //     else{
        //         $date = date('Y-m-d');
        //         $data['batch'] ="";
        //    $data['batch'] .="<input type='text' name='batch_obat_".$index."' id='batch_obat_".$index."' class='form-control form-control-sm'>";
        //    $data['batch'] .="<script>
        //     $(document).ready(function(){
        //             $('#tgl_expired_obat_".$index."').val(\"$date\");
        //             $('#tgl_expired_obat_".$index."').prop('readonly', false);
        //     }); </script>";
        //     }
            $date = date('Y-m-d');
            $data['batch'] ="";
       $data['batch'] .="<input type='text' name='batch_obat_".$index."' id='batch_obat_".$index."' class='form-control form-control-sm'>";
       $data['batch'] .="<script>
        $(document).ready(function(){
                $('#tgl_expired_obat_".$index."').val(\"$date\");
                $('#tgl_expired_obat_".$index."').prop('readonly', false);
        }); </script>";
            return $data;
        }
        else{
            $stok_obat = StokObat::where('id_obat', $req->id_obat)->get();
            //return $stok_obat;
            $input = "<input type='text' id='batch_obat' name='batch_obat' class='form-control form-control-sm'>";
            if(count($stok_obat) > 0){
                echo "
                <select name='batch_obat' id='batch_obat' class='form-control select2'>";
                foreach($stok_obat as $obat){
                    echo" <option value='".$obat->id."'>".$obat->batch_obat." | expired ".date('d-m-Y',strtotime($obat->tgl_expired_obat))."</option>";
                }
                echo" <option value='tambah'>Tambah Batch </option></select>
                <script>
                $(function () {
                    $('.select2').select2()
                });
                var id_obat = $('#id_obat').val();
                var input_batch = $('#batch_obat').val();
                $('#batch_obat').on('change', function(){

                    ";foreach($stok_obat as $obat){
                        $tgl = $obat->tgl_expired_obat;
                        echo"if(this.value == ".$obat->id."){
                            $('#stok_obat').val(".$obat->stok_obat.");
                            $('#tgl_expired_obat').val(\"$tgl\");
                        }";
                    }$tgl = date('Y-m-d');echo"
                    if(this.value == 'tambah'){

                        $('#input_batch').html(\"$input\");
                        $('#tgl_expired_obat').val(\"$tgl\");
                        $('#tgl_expired_obat').prop('readonly', false);
                        $('#stok_obat').val('');
                    }
                });
                </script>";
            }
            else{
            echo"<input type='text' id='batch_obat' name='batch_obat' class='form-control form-control-sm'>";
            echo"<script>
            $(document).ready(function(){
                    $('#tgl_expired_obat').prop('readonly', false);
            }); </script>";
            }
        }




    }
    public function get_stok(Request $request){
        //return $request->all();
        $stok_obat = StokObat::where('id', $request->batch_obat)->select('stok_obat')->first();
        $tgl = StokObat::where('id', $request->batch_obat)->select('tgl_expired_obat')->first();

        if(isset($stok_obat)){
            $data['stok_obat'] = $stok_obat->stok_obat;
            $data['tgl_expired_obat'] = $tgl->tgl_expired_obat;
        }
        else{
            $data = null;
        }


        return $data;
    }
    public function get_tgl(Request $request){
        //return $request->all();
        $tgl_expired = StokObat::where('id', $request->batch_obat)->select('tgl_expired_obat')->first();
        return $tgl_expired;
    }
    public function detail(Request $request){
        // return $request->all();
        $dec_id = $this->safe_decode(Crypt::decryptString($request->enc_id));
        if($dec_id){

            //$id = StokObat::where('id_obat', $dec_id)->first();
            $stok_obat = StokObat::where('id_obat', $dec_id)->get();
            //return $stok_obat;
            $obats = Obat::where('id', $dec_id)->first();
            //return $obats;
            $row = $obats->count();
            echo "
                <thead>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th>Nama Batch</th>
                    <th>Stok Obat</th>
                    <th>Tanggal Expired Obat</th>
                </thead>
                <tr>
                    <td rowspan='".$row."' style='text-align:center;vertical-align:middle'>".$obats->kode_obat."</td>
                    <td rowspan='".$row."' style='text-align:center;vertical-align:middle'>".$obats->nama_obat."</td>
                    ";foreach($stok_obat as $stok){
                        echo "<td>".$stok->batch_obat."</td>
                        <td>".number_format($stok->stok_obat,0,'','.')."</td>
                        <td>".date('d-m-Y',strtotime($stok->tgl_expired_obat))."</td> </tr> <tr>";
                    }
                    echo"
                </tr>
                <script>


                $(document).ready(function(){
                    $(document).find('#title_modal').text('".$obats->nama_obat."');
                });

                </script>
            ";
        }
        else{
            return view('errors/noaccess');
        }
    }
    // ubah : Form ubah data
    public function ubah($enc_id)
    {

        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        //return $dec_id;
        if ($dec_id) {
            $stok_obat = StokObat::where('id_obat',$dec_id)->get();
            // return $stok_obat;
            // $stokobat = collect([

            // ]);


            $obats = Obat::get();
            return view('apotik_form/stok_obat_form', compact('enc_id', 'stok_obat', 'obats'));
        } else {
            return view('errors/noaccess');
        }
    }
    public function simpan(Request $req)
    {
        //return $req->all();
        $enc_id     = $req->enc_id;



        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }

        if ($enc_id) {

            $id = $req->batch_obat;
            $stok_obat = StokObat::find($id);
            if($stok_obat){

                // $stok_obat->kode_obat  = $req->kode_obat;
                $stok_obat->batch_obat = $stok_obat->batch_obat;
                $stok_obat->tgl_expired_obat = $stok_obat->tgl_expired_obat;
                $stok_obat->id_obat = $stok_obat->id_obat;
                $stok_obat->stok_obat  = $req->stok_obat;
                $stok_obat->save();

                if ($stok_obat) {
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $json_data = array(
                        "success"         => FALSE,
                        "message"         => 'Data gagal diperbarui.'
                    );
                }
            }
            else{
                $stok_obat = new StokObat;

                $stok_obat->id_obat  = $dec_id;
                $stok_obat->batch_obat = $req->batch_obat;
                $stok_obat->tgl_expired_obat = $req->tgl_expired_obat;
                $stok_obat->stok_obat  = $req->stok_obat;
                $stok_obat->save();

                if ($stok_obat) {
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

        } else {
            $checkdata = StokObat::find($req->batch_obat);
            if ($checkdata) {
                //return $req->all();
                $stok_obat = StokObat::find($req->batch_obat);
                $stok_obat->batch_obat = $stok_obat->batch_obat;
                $stok_obat->tgl_expired_obat = $stok_obat->tgl_expired_obat;
                $stok_obat->id_obat = $stok_obat->id_obat;
                $stok_obat->stok_obat  = $req->stok_obat;
                $stok_obat->save();
                if ($stok_obat) {
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $json_data = array(
                        "success"         => FALSE,
                        "message"         => 'Data gagal diperbarui.'
                    );
                }
                // $json_data = array(
                //     "success"         => FALSE,
                //     "message"         => 'Kode StokObat sudah terdaftar.'
                // );
            } else {
                //return "oke";
                //$obat = Obat::find($req->id_obat);
                $stok_obat = new StokObat;

                $stok_obat->id_obat  = $req->id_obat;
                $stok_obat->batch_obat = $req->batch_obat;
                $stok_obat->tgl_expired_obat = $req->tgl_expired_obat;
                $stok_obat->stok_obat  = $req->stok_obat;
                $stok_obat->save();

                if ($stok_obat) {
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
        }
        return json_encode($json_data);
    }
    public function hapus(Request $req, $enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        //return $dec_id;
        $stok_obat = StokObat::where('id_obat', $dec_id)->delete();
       // return $stok_obat;
        if (isset($stok_obat)) {
            //$stok_obat->delete();
            return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
        }
    }
    public function modal_obat(Request $request){
        //return $request->all();
        if($request->barcode_obat != ""){
            $obat = Obat::where('barcode_obat', $request->barcode_obat)->first();
        }


        //return $stok_obat;
        $data = "";
        if(isset($obat)){
            $stok_obat = StokObat::where('id_obat', $obat->id)->get();
            $data .= "<div class='row'>
            <input type='hidden' name='id_obat' value='".$obat->id."'>
            <div class='form-group row col-md-12'>
            <h3 style='width:100%'><center>".$obat->nama_obat."</center></h3>
            </div>
            <div class='form-group row col-md-12'>
                <label for='staticEmail' class='col-sm-4 col-form-label'>Batch Obat <span>*</span></label>
                <div class='col-sm-8' id='input_batch_obat'>
                ";if($stok_obat->count()>0){
                    $data .="<select name='batch_obat' id='batch_obat' class='select2 form-control form-control-sm' style='width:100%'>";
                    foreach($stok_obat as $stok){
                        $data .="
                                    <option value='".$stok->id."'>".$stok->batch_obat." | ".$stok->tgl_expired_obat."
                                    </option>
                                ";

                    }
                    $data .="<option value='tambah'>Tambah Batch</option></select>


                    ";

                }
                else{
                    $data .="<input type='text' name='batch_obat' class='form-control'>";
                }

                $data .="</div>
            </div>
            <div class='form-group row col-md-12'>
                <label for='staticEmail' class='col-md-4 col-form-label'>Tanggal Expired Obat <span>*</span></label>
                <div class='col-sm-8'>
                    <input type='date' class='form-control form-control-sm mb-1' name='tgl_expired_obat' id='tgl_expired_obat' value='{{ date('Y-m-d') }}'>
                </div>
            </div>
            <div class='form-group row col-md-12'>
                <label for='staticEmail' class='col-md-4 col-form-label'>Stok Obat <span>*</span></label>
                <div class='col-sm-8'>
                    <input type='number' class='form-control form-control-sm mb-1' name='stok_obat' id='stok_obat' value='1'>
                </div>
            </div>

        </div>";
        $input = "<input type='text' name='batch_obat' class='form-control'>";
        $now = Carbon::now();
        $data .="
        <script>

                $(document).ready(function(){
                    var id_batch = $('#batch_obat').val();";
                    foreach($stok_obat as $stok){
                        $data .="if(".$stok->id."== id_batch){
                            $('#tgl_expired_obat').val('".date('Y-m-d',strtotime($stok->tgl_expired_obat))."');
                            $('#stok_obat').val('".$stok->stok_obat."');
                            $('#tgl_expired_obat').prop('readonly', true);

                        }";
                    }
            $data .=" if(id_batch == 'tambah' || id_batch == null){
                $('#tgl_expired_obat').val('".date('Y-m-d',strtotime($now))."');
            }
        });

                $('#batch_obat').change(function(){
                    var id_batch = $('#batch_obat').val();";
                    foreach($stok_obat as $stok){
                        $data .="if(".$stok->id."== id_batch){
                            $('#tgl_expired_obat').val('".date('Y-m-d',strtotime($stok->tgl_expired_obat))."');
                            $('#stok_obat').val('".$stok->stok_obat."');
                            $('#tgl_expired_obat').prop('readonly', true);
                        }";
                    }

              $data .= "if(id_batch == 'tambah'){
                $('#tgl_expired_obat').val('".date('Y-m-d', strtotime($now))."');
                $('#input_batch_obat').html(\"$input\");
                $('#tgl_expired_obat').prop('readonly', false);
            }});
        </script>
        ";
        $data .="<script>
        $('.select2').select2({
            dropdownParent: $('#modal_tambah_obat .modal-body #isi_modal'),
        });

        </script>";
        }
        else{
            $data .="null";
        }

    return $data;
    }

    public function cetak(Request $request)
    {
       // return $request->all();
        $search = $request->search;
        //return $search;

        $records = StokObat::distinct()->select('id_obat');


        if ($search) {
            $id = array();
            $key = Obat::where('nama_obat', 'LIKE', "%{$search}%")->orWhere('kode_obat', 'LIKE', "%{$search}%")->get('id');
            foreach($key as $k){
                $id[] = $k->id;
            }


            $records->where(function ($query) use ($search) {
                $query->orWhere('id_obat', 'LIKE', "%{$search}%");
            })->orWhere(function($query) use ($id){
                if($id){
                    $query->orWhereIn('id_obat', $id);
                }

            });
        }



        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id_obat));
            $action = "";

            $action .= '<a href="#!" onclick="detail_data(\''.$enc_id.'\')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Detail"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
            if ($request->user()->can('stok_obat.ubah')) {
                $action .= '<a href="' . route('stok_obat.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            }
            if ($request->user()->can('stok_obat.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            }



            $obat = Obat::where('id', $record->id_obat)->first();


            $record->kode_obat  = $obat->kode_obat;
            $record->nama_obat  = $obat->nama_obat;
            $stokobat = number_format(StokObat::where('id_obat', $record->id_obat)->sum('stok_obat'), 0, '','.');
            $record->stok_obat  = $stokobat;

            $record->action         = $action;
        }

       // return $records->get();
       $stok_obat = array();
        foreach($records->get() as $d){
            $stok_obat[] = StokObat::where('id_obat',$d->id_obat)->get();
        }
        $obats = array();
        foreach($records->get() as $d){
            $obats[] = Obat::where('id',$d->id_obat)->first();
        }
        //return $obats;


    //    $stok_obat = StokObat::whereIn('id_obat', $i)->get();
    //    return $stok_obat;
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


    // foreach($stok_obat as $key=> $item){
    //     $item->no = $key+1;
    //     $obat = Obat::where('id', $item->id_obat)->first();
    //     $item->kode_obat = $obat->kode_obat;
    //     $item->nama_obat = $obat->kode_obat;
    // }
    //return $stok_obat[0];
    $pdf = PDF::loadView('apotik_dll/stok_obat_cetak', ['stok_obat'=>$stok_obat, 'obats'=>$obats],[],$config);
    ob_get_clean();
    return $pdf->download('Data Stok Obat_'.date('d_m_Y H_i_s').'.pdf');
    //download : langsung download
    //stream : open preview
    }

    public function laporanExcel(Request $request)
    {
        //return $request->all();
        if($request->search){
            $search = $request->search;
            return Excel::download(new StokObatExport($search),'Data Stok Obat"'.date('d_m_Y H_i_s').'".xlsx');
        }
        else{
            $search= "";
            //return $search;
            return Excel::download(new StokObatExport($search),'Data Stok Obat"'.date('d_m_Y H_i_s').'".xlsx');
        }

    }
}
