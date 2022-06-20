<?php

namespace App\Http\Controllers\PTM;

use App\Exports\ExportExcel;
use App\Http\Controllers\Simpusk\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\PTM\Puskesmas;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\PTM\Form_d;

use DB;
use Auth;
use Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class FormDController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {

        $date_now = date('M-Y');
        $data    = Puskesmas::select('id', 'name', 'kecamatan', 'kabupaten', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

        return view('ptm/deteksi_dini/form_d/index', compact('date_now', 'data'));
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

    private function cekExist($column, $var, $id)
    {
        $cek = Form_d::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    private function get_data_record($puskesmas, $periode)
    {
        // $puskesmas  = Puskesmas::where();
        $dataquery = Form_d::select('*')->where('puskesmas_id', $puskesmas)->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->first();

        return $dataquery;
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        if ($request->periode != '') {
            $periode = date('Y-m-d', strtotime('01-' . $request->periode));
        } else {
            $periode = date('Y-m-d');
        }


        $dataquery = Form_d::select('ptm_form_d.*', 'ptm_puskesmas.name as puskname');
        $dataquery->leftJoin('ptm_puskesmas', 'ptm_puskesmas.id', 'ptm_form_d.puskesmas_id');
        $dataquery->where('ptm_form_d.puskesmas_id', auth()->user()->puskesmas_id);
        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('ptm_form_d.id', 'ASC');
        }
        if ($search) {
            $dataquery->where(function ($query) use ($search) {
                $query->orWhere('ptm_puskesmas.name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->periode != NULL) {
            $dataquery->whereMonth('ptm_form_d.periode', date('m', strtotime($periode)))->whereYear('ptm_form_d.periode', date('Y', strtotime($periode)));
        }

        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            if ($request->user()->can('form_d.ubah')) {
                $action .= '<a href="' . route('form_d.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            }
            if ($request->user()->can('form_d.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }
            $action .= "</div>";


            if ($result->lr_hasil_iva == 0) {
                $negatif    = "<i class='fa fa-check' style='color: #1ab394;'></i>";
                $positif    = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $raguragu   = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            } else if ($result->lr_hasil_iva == 1) {
                $negatif    = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $positif    = "<i class='fa fa-check' style='color: #1ab394;'></i>";
                $raguragu   = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            } else if ($result->lr_hasil_iva == 2) {
                $negatif    = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $positif    = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $raguragu   = "<i class='fa fa-check' style='color: #1ab394;'></i>";
            } else {
                $negatif    = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $positif    = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $raguragu   = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            }

            if ($result->lr_dirujuk == 0) {
                $lesu       = "<i class='fa fa-check' style='color: #1ab394;'></i>";
                $curiga     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $kelgyn     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            } else if ($result->lr_dirujuk == 1) {
                $lesu       = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $curiga     = "<i class='fa fa-check' style='color: #1ab394;'></i>";
                $kelgyn     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            } else if ($result->lr_dirujuk == 2) {
                $lesu       = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $curiga     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $kelgyn     = "<i class='fa fa-check' style='color: #1ab394;'></i>";
            } else {
                $lesu       = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $curiga     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $kelgyn     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            }

            if ($result->p_dirujuk == 0) {
                $benjolan       = "<i class='fa fa-check' style='color: #1ab394;'></i>";
                $curigaca     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $lainlain     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            } else if ($result->p_dirujuk == 1) {
                $benjolan       = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $curigaca     = "<i class='fa fa-check' style='color: #1ab394;'></i>";
                $lainlain     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            } else if ($result->p_dirujuk == 2) {
                $benjolan       = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $curigaca     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $lainlain     = "<i class='fa fa-check' style='color: #1ab394;'></i>";
            } else {
                $benjolan       = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $curigaca     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
                $lainlain     = "<i class='fa fa-minus' style='color: #ed5565;'></i>";
            }

            $result->no                   = $key + $page;
            $result->id                   = $result->id;
            $result->puskesmas            = $result->puskname;
            $result->tgl                  = $result->tgl;
            $result->no_registrasi        = $result->no_registrasi;
            $result->nama                 = $result->nama;
            $result->umur                 = $result->umur;
            $result->alamat               = $result->alamat;
            $result->negatif              = $negatif;
            $result->positif              = $positif;
            $result->raguragu             = $raguragu;
            $result->lesu                 = $lesu;
            $result->curiga               = $curiga;
            $result->kelgyn               = $kelgyn;
            $result->p_normal             = $result->p_normal;
            $result->benjolan             = $benjolan;
            $result->curigaca             = $curigaca;
            $result->lainlain             = $lainlain;
            $result->keterangan           = $result->keterangan;
            $result->action               = $action;

        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    public function tambah()
    {
        $query = Puskesmas::select('*');
        $query->where('id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');

        // return response()->json($puskesmas);
        return view('ptm/deteksi_dini/form_d/form', compact('puskesmas', 'date_now'));
    }

    public function simpan(Request $req)
    {
        // return $req->all();
        // return date("Y-m-d",strtotime('01-'.$req->periode));
        $enc_id     = $req->enc_id;
        // return response()->json(['data' => $req->all()]);

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }


        $cek_nama = $this->cekExist('periode', date("Y", strtotime('01-' . $req->periode)), $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        } else {
            try {
                DB::beginTransaction();
                if ($enc_id) {
                    $formd = Form_d::find($dec_id);
                    $formd->tgl                     = date("Y-m-d", strtotime($req->tgl));
                    $formd->no_registrasi           = $req->no_registrasi;
                    $formd->nama                    = $req->nama;
                    $formd->umur                    = $req->umur;
                    $formd->alamat                  = $req->alamat;
                    $formd->pap_smear               = $req->pap_smear;
                    $formd->lr_hasil_iva            = $req->lr_hasil_iva;
                    $formd->lr_dirujuk              = $req->lr_dirujuk;
                    if ($req->p_normal == 1) {
                        $formd->p_normal                = 'normal';
                    } else {
                        $formd->p_normal                = 'tidak normal';
                    }
                    $formd->p_dirujuk               = $req->p_dirujuk;
                    $formd->keterangan              = $req->keterangan;
                    $formd->periode                 = date("Y-m-d", strtotime('01-' . $req->periode));
                    $formd->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $formd                          = new Form_d;
                    $formd->user_id                 = auth()->user()->id;
                    $formd->puskesmas_id            = auth()->user()->puskesmas_id;
                    $formd->tgl                     = date("Y-m-d", strtotime($req->tgl));
                    $formd->no_registrasi           = $req->no_registrasi;
                    $formd->nama                    = $req->nama;
                    $formd->umur                    = $req->umur;
                    $formd->alamat                  = $req->alamat;
                    $formd->pap_smear               = $req->pap_smear;
                    $formd->lr_hasil_iva            = $req->lr_hasil_iva;
                    $formd->lr_dirujuk              = $req->lr_dirujuk;
                    if ($req->p_normal == 1) {
                        $formd->p_normal                = 'normal';
                    } else {
                        $formd->p_normal                = 'tidak normal';
                    }

                    $formd->p_dirujuk               = $req->p_dirujuk;
                    $formd->keterangan              = $req->keterangan;
                    $formd->periode                 = date("Y-m-d", strtotime('01-' . $req->periode));
                    $formd->save();

                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                    );
                }
            } catch (\Throwable $th) {
                DB::rollback();
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => $th->getMessage()
                );
            }
        }
        return json_encode($json_data);
    }

    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $query = Puskesmas::select('*');
            $query->where('puskesmas.id', auth()->user()->puskesmas_id);
            $puskesmas = $query->first();

            $form_d = Form_d::find($dec_id);
            $periode = date('M-Y', strtotime($form_d->periode));
            $form_d->date_periode = $periode;
            $tgl_input = date('d-m-Y', strtotime($form_d->tgl));
            $form_d->tgl_berkunjung = $tgl_input;

            // if ($form_d->p_normal == "normal") {
            //     $selectedPeriksaPayudara = 'checked';
            // } else {
            //     $selectedPeriksaPayudara = '';
            // }

            // return response()->json(['data' => $ptm]);
            // return $form_d;
            return view('ptm/deteksi_dini/form_d/form', compact('enc_id', 'puskesmas', 'form_d'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
            return json_encode($json_data);
        }
        // return response()->json($puskesmas);
    }

    public function hapus(Request $req, $enc_id)
    {
        try {
            $dec_id   = $this->safe_decode(Crypt::decryptString($enc_id));
            $ptm      = Form_d::find($dec_id);
            $ptm->delete();

            $json_data = array(
                "status"         => 'success',
                "message"         => 'Data berhasil dihapus.'
            );
        } catch (\Throwable $th) {
            $json_data = array(
                "success"         => 'gagal',
                "message"         => $th->getMessage()
            );
        }
        return response()->json($json_data);
    }
    public function cetak_pdf(Request $request)
    {

        if ($request->periode != '') {
            $periode = date('Y-m-d', strtotime('01-' . $request->periode));
        } else {
            $periode = date('Y-m-d');
        }

        if ($request->user()->can('puskesmas.index')) {
            $dataquery = Form_d::select('form_d.*', 'puskesmas.name as puskname');
            $dataquery->leftJoin('puskesmas', 'puskesmas.id', 'form_d.puskesmas_id');
            $dataquery->where('form_d.puskesmas_id', auth()->user()->puskesmas_id);

            $dataquery->orderBy('form_d.id', 'ASC');


            if ($request->periode != NULL) {
                $dataquery->whereMonth('form_d.periode', date('m', strtotime($periode)))->whereYear('form_d.periode', date('Y', strtotime($periode)));
            }
        }

        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));


            if ($request->user()->can('puskesmas.index')) {
                if ($result->lr_hasil_iva == 0) {
                    $negatif    = 'V';
                    $positif    = 'X';
                    $raguragu   = 'X';
                } else if ($result->lr_hasil_iva == 1) {
                    $negatif    = 'X';
                    $positif    = 'V';
                    $raguragu   = 'X';
                } else if ($result->lr_hasil_iva == 2) {
                    $negatif    = 'X';
                    $positif    = 'X';
                    $raguragu   = 'V';
                } else {
                    $negatif    = 'X';
                    $positif    = 'X';
                    $raguragu   = 'X';
                }

                if ($result->lr_dirujuk == 0) {
                    $lesu       = 'V';
                    $curiga     = 'X';
                    $kelgyn     = 'X';
                } else if ($result->lr_dirujuk == 1) {
                    $lesu       = 'X';
                    $curiga     = 'V';
                    $kelgyn     = 'X';
                } else if ($result->lr_dirujuk == 2) {
                    $lesu       = 'X';
                    $curiga     = 'X';
                    $kelgyn     = 'V';
                } else {
                    $lesu       = 'X';
                    $curiga     = 'X';
                    $kelgyn     = 'X';
                }

                if ($result->p_dirujuk == 0) {
                    $benjolan       = 'V';
                    $curigaca     = 'X';
                    $lainlain     = 'X';
                } else if ($result->p_dirujuk == 1) {
                    $benjolan       = 'X';
                    $curigaca     = 'V';
                    $lainlain     = 'X';
                } else if ($result->p_dirujuk == 2) {
                    $benjolan       = 'X';
                    $curigaca     = 'X';
                    $lainlain     = 'V';
                } else {
                    $benjolan       = 'X';
                    $curigaca     = 'X';
                    $lainlain     = 'X';
                }

                // $result->no                   = $key + $page;
                $result->id                   = $result->id;
                $result->puskesmas            = $result->puskname;
                $result->tgl                  = $result->tgl;
                $result->no_registrasi        = $result->no_registrasi;
                $result->nama                 = $result->nama;
                $result->umur                 = $result->umur;
                $result->alamat               = $result->alamat;
                $result->negatif              = $negatif;
                $result->positif              = $positif;
                $result->raguragu             = $raguragu;
                $result->lesu                 = $lesu;
                $result->curiga               = $curiga;
                $result->kelgyn               = $kelgyn;
                $result->p_normal             = $result->p_normal;
                $result->benjolan             = $benjolan;
                $result->curigaca             = $curigaca;
                $result->lainlain             = $lainlain;
                $result->keterangan           = $result->keterangan;
            }
        }
        $view = 'template/deteksi/form_d/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, [], $view), 'IvaSadanisFormD.xlsx');
        }
        $config = [
            'mode'                  => '',
            'format'                => 'A4',
            'default_font_size'     => '11',
            'default_font'          => 'sans-serif',
            'margin_left'           => 8,
            'margin_right'          => 8,
            'margin_top'            => 8,
            'margin_bottom'         => 8,
            'margin_header'         => 0,
            'margin_footer'         => 0,
            'orientation'           => 'L',
            'title'                 => 'Data Form D',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/deteksi/form_d/cetak', ['data' => $data], [], $config);
        return $pdf->download('laporan-formD.pdf');
    }
}
