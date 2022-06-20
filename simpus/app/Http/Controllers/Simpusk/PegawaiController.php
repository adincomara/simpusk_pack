<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Pegawai;
use App\Models\Simpusk\Bidang;
use App\Models\Simpusk\Jabatan;


use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;

class PegawaiController extends Controller
{
    public function url_pegawai()
    {
        $x = env('APP_URL') . '/pegawai';
        return $x;
    }
    protected $original_column = array(
        1 => "title",
        2 => "status",
    );
    public function status()
    {
        $value = array('1' => 'Aktif', '0' => 'Tidak Aktif');
        return $value;
    }


    public function index()
    {
        return view('master/data_pegawai');
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = Pegawai::select('*');

        //   if(array_key_exists($request->order[0]['column'], $this->original_column)){
        //      $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        //   }
        //   else{
        //     $records->orderBy('created_at','DESC');
        //   }
        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('nama_pegawai', 'LIKE', "%{$search}%")
                ->orWhere('nip', 'LIKE', "%{$search}%")
                ->orWhere('nik', 'LIKE', "%{$search}%")
                ->orWhere('npwp', 'LIKE', "%{$search}%")
                ->orWhere('tempat_lahir', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id_pegawai));
            $action = "";

            $action .= "";
            $nama = "".json_encode($record->nama_pegawai);
            $action.='<a href="#" onclick="detail_data('.$record->id_pegawai.',\'' .$record->nama_pegawai.'\' )" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
            if($request->user()->can('pegawai.ubah')){
                $action.='<a href="'.route('pegawai.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            }
            if($request->user()->can('pegawai.hapus')){
                $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            }


            $record->no             = $key + $page;
            $record->nama_jabatan = Jabatan::select('nama_jabatan')->where('id_jabatan',$record->id_jabatan)->first()->nama_jabatan;
            $record->nama_bidang = Bidang::select('nama_bidang')->where('id_bidang',$record->id_bidang)->first()->nama_bidang;
            $record->action         = $action;
            $record->nipnik = "NIP : ".$record->nip."<br>NIK : ".$record->nik;
            if($record->jenis_kelamin == "Laki-Laki"){
                $record->jenis_kelamin = "L";
            }
            else{
                $record->jenis_kelamin = "P";
            }
            if($record->status == '1'){
                $record->status = "<label class='switch'>
                <input type='checkbox' value='".$record->id_pegawai."' id='data_".$record->id_pegawai."' checked>
                <span class='slider round'></span>
              </label>
              <script>
              $('#data_".$record->id_pegawai."').click(function(){
                var id = this.value;
                var cek = $('#data_".$record->pegawai."').prop('checked');
                if(cek == true){
                    var val = 1;
                }
                else{
                    var val = 0;
                }
                  Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Status pegawai akan diubah!',

                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Ya',
                    cancelButtonText:'Batal',
                    confirmButtonColor: '#ec6c62',
                    closeOnConfirm: false
                  }).then(function(result){
                      if(result.value){
                        $.ajax({
                            type: 'POST',
                            url: '".route('pegawai.ubah_status')."',
                            headers: {'X-CSRF-TOKEN': $('[name=\"_token\"]').val()},
                            data: {id_pegawai : id, value: val},
                            success: function(data){

                                if(data == 'success'){
                                    Swal.fire('Yes',data.message,'success');
                                }
                                else{
                                    Swal.fire('Peringatan',data.message,'info');
                                }
                            }
                        });
                      }else{
                        var check = $('#data_".$record->id_pegawai."');
                        if(check.prop('checked') == false){
                            check.prop('checked', true);
                        }
                        else{
                            check.prop('checked', false);
                        }

                      }
                  });
              });
              </script>";
            }
            else{
                $record->status = "<label class='switch'>
                <input type='checkbox' value='".$record->id_pegawai."' id='data_".$record->id_pegawai."'>
                <span class='slider round'></span>
              </label>
              <script>
              $('#data_".$record->id_pegawai."').click(function(){
                var id = this.value;
                var cek = $('#data_".$record->pegawai."').prop('checked');
                if(cek == true){
                    var val = 0;
                }
                else{
                    var val = 1;
                }
                  Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Status pegawai akan diubah!',

                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Ya',
                    cancelButtonText:'Batal',
                    confirmButtonColor: '#ec6c62',
                    closeOnConfirm: false
                  }).then(function(result){
                      if(result.value){
                        $.ajax({
                            type: 'POST',
                            url: '".route('pegawai.ubah_status')."',
                            headers: {'X-CSRF-TOKEN': $('[name=\"_token\"]').val()},
                            data: {id_pegawai : id, value: val},
                            success: function(data){

                                if(data == 'success'){
                                    Swal.fire('Yes',data.message,'success');
                                }
                                else{
                                    Swal.fire('Peringatan',data.message,'info');
                                }
                            }
                        });
                      }else{
                        var check = $('#data_".$record->id_pegawai."');
                        if(check.prop('checked') == false){
                            check.prop('checked', true);
                        }
                        else{
                            check.prop('checked', false);
                        }

                      }
                  });
              });
              </script>";
            }
        }
        if ($request->user()->can('pegawai.index')) {
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
    public function ubah_status(Request $request){
        //return $request->all();
        $pegawai = Pegawai::where('id_pegawai', $request->id_pegawai)->first();
        $pegawai->status = $request->value;
        if($pegawai->save()){
            return "success";
        }
        return "gagal ditambahkan";
    }
    public function detail_data(Request $req){
        $id = $req->id;
        echo $id;
        $data = Pegawai::where('id_pegawai',$id)->first();
        $jabatan = Jabatan::select('nama_jabatan')->where('id_jabatan',$data->id_jabatan)->first()->nama_jabatan;
        $bidang = Bidang::select('nama_bidang')->where('id_bidang',$data->id_bidang)->first()->nama_bidang;
        if($data->jenis_kelamin == "Laki-Laki"){
            $jenis_kelamin = "L";
        }
        else{
            $jenis_kelamin = "P";
        }
        echo"
            <tr>
              <td class='text-left no-sort'>Nama Pegawai</td>
              <td>:</td>
              <td>".$data->nama_pegawai."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>NIK/NIP</td>
              <td>:</td>
              <td>".$data->nik." / ".$data->nip."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>Gender</td>
              <td>:</td>
              <td>".$data->jenis_kelamin."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>NPWP</td>
              <td>:</td>
              <td>".$data->npwp."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>Tempat & Tanggal Lahir</td>
              <td>:</td>
              <td>".$data->tempat_lahir.", ".$data->tanggal_lahir."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>Alamat</td>
              <td>:</td>
              <td>".$data->alamat."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>Jabatan</td>
              <td>:</td>
              <td>".$jabatan."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>Bidang</td>
              <td>:</td>
              <td>".$bidang."</td>
            </tr>
            <tr>
              <td class='text-left no-sort'>Status</td>
              <td>:</td>
              <td>".$data->status."</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td></td>

            </tr>
              <!-- <th class='text-left no-sort'></th> -->

          ";
        //   $no = 0;
        //   foreach($getDatas as $data){
        //     $no++;
        //     $jabatan = Jabatan::select('nama_jabatan')->where('id_jabatan',$data->id_jabatan)->first()->nama_jabatan;
        //     $bidang = Bidang::select('nama_bidang')->where('id_bidang',$data->id_bidang)->first()->nama_bidang;
        //     if($data->jenis_kelamin == "Laki-Laki"){
        //         $jenis_kelamin = "L";
        //     }
        //     else{
        //         $jenis_kelamin = "P";
        //     }
        //     echo"
        //     <tr>
        //       <td>".$no."</td>
        //       <td>".$data->nama_pegawai."</td>
        //       <td style='width:20%'>NIK : ".$data->nik."<br>NIP : ".$data->nip."</td>
        //       <td>".$jenis_kelamin."</td>
        //       <td>".$data->npwp."</td>
        //       <td>".$data->tempat_lahir.", ".$data->tanggal_lahir."</td>
        //       <td>".$data->alamat."</td>
        //       <td>".$jabatan."</td>
        //       <td>".$bidang."</td>
        //       <td>".$data->status."</td>

        //     ";
        //     }echo"
        //   </tbody>
        // ";
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

        $status = $this->status();
        $selectedstatus = "1";
        $jabatan = Jabatan::get();
        $bidang = Bidang::get();
        return view('master_form/pegawai_form', compact('status', 'selectedstatus'))->with('arr_jabatan',$jabatan)->with('arr_bidang',$bidang);
    }


    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $pegawai = Pegawai::find($dec_id);
            $status = $this->status();
            $selectedstatus = $pegawai->status;


            $jabatan = Jabatan::get();
            $bidang = Bidang::get();
            return view('master_form/pegawai_form', compact('enc_id', 'pegawai'))->with('arr_jabatan',$jabatan)->with('arr_bidang',$bidang);
        } else {
            return view('errors/noaccess');
        }
    }


    private function cekSlug($column, $var, $id)
    {
        $cek = Pegawai::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function simpan(Request $req)
    {
        // return $req->all();
        //tambah nik dan alamat
        $enc_id     = $req->enc_id;

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }

        if ($enc_id) {
            $data = Pegawai::find($dec_id);

            $data->nama_pegawai       = $req->nama_pegawai;
            $data->nip       = $req->nip;
            $data->jenis_kelamin       = $req->jenis_kelamin;
            $data->npwp       = $req->npwp;
            $data->nik       = $req->nik;
            $data->alamat       = $req->alamat;
            $data->tempat_lahir       = $req->tempat_lahir;
            $data->tanggal_lahir       = date('d-m-Y', strtotime($req->tanggal_lahir));;
            $data->id_jabatan       = $req->id_jabatan;
            $data->id_bidang       = $req->id_bidang;
            $data->save();

            if ($data) {
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
        } else {
            $data = new Pegawai;

            $data->nama_pegawai       = $req->nama_pegawai;
            $data->nip       = $req->nip;
            $data->jenis_kelamin       = $req->jenis_kelamin;
            $data->npwp       = $req->npwp;
            $data->tempat_lahir       = $req->tempat_lahir;
            $data->tanggal_lahir       = $req->tanggal_lahir;
            $data->id_jabatan       = $req->id_jabatan;
            $data->id_bidang       = $req->id_bidang;
            $data->nik       = $req->nik;
            $data->alamat       = $req->alamat;
            $data->save();
            if ($data) {
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
        $pegawai = Pegawai::find($dec_id);

        if ($pegawai) {
            $pegawai->delete();
            return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
        }
    }

    public function cetak(Request $request)
    {

       $data =   json_decode($request->data, true);

    //    }
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
        'title'                 => 'DATA PEGAWAI',
        'author'                => '',
        'watermark'             => '',
        'show_watermark'        => true,
        'show_watermark_image'  => true,
        'watermark_font'        => 'sans-serif',
        'display_mode'          => 'fullpage',
        'watermark_text_alpha'  => 0.2,
    ];

     //return $data;
    $pdf = PDF::loadView('laporan_dll/cetak_tenaga_puskesmas', ['pegawai'=>$data],[],$config);
    ob_get_clean();
    //return $data;
    //return $pdf->download();
    return $pdf->download('Data Pegawai_'.date('d_m_Y H_i_s').'.pdf');

    //download : langsung download
    //stream : open preview
    }

    public function cetakNakes(Request $request)
    {
       $pegawai = Pegawai::where('id_bidang','1')->get();
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
        'title'                 => 'DATA JABATAN NAKES PUSKESMAS',
        'author'                => '',
        'watermark'             => '',
        'show_watermark'        => true,
        'show_watermark_image'  => true,
        'watermark_font'        => 'sans-serif',
        'display_mode'          => 'fullpage',
        'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetak_jabatan_nakes', ['pegawai'=>$pegawai],[],$config);
    ob_get_clean();
    return $pdf->download('Data Pegawai_'.date('d_m_Y H_i_s').'.pdf');
    //download : langsung download
    //stream : open preview
    }
}
