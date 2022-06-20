<?php

namespace App\Http\Controllers\Simpusk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Simpusk\About;

class AboutController extends Controller
{
   public function form()
   {
    $about= About::first();
    if($about){
    	if ($about->logo==null) {
          	$logo=$this->defaultProfilePhotoUrl($about->nama);
      }else{
        	$logo=url($about->logo);
      }
      if ($about->fav==null) {
        	$fav=$this->defaultProfilePhotoUrl($about->nama);
      }else{
        	$fav=url($about->fav);
      }
    }else{
      $logo="";
      $fav="";
    }
    return view('pengaturan_form/pengaturan_form',compact('about','logo','fav'));
  }
  protected function defaultProfilePhotoUrl($name)
  {
	return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=ffffff&background=ed4626&rounded=true&length=3';
  }
  public function simpan(Request $req)
  {

      $datalogo   = $req->inilogo;
      $datafav    = $req->inifav;
      $dir        = 'media/logo/';
      $dir_fav    = 'media/fav/';

      $update = About::first();
      if($update){
         if ($datalogo != null) {
              list($type, $datalogo) = explode(';', $datalogo);
              list(, $datalogo)      = explode(',', $datalogo);
              if(!file_exists($dir)){
                  mkdir($dir, 0777, true);
                   chmod($dir, 0777);
              }

              $datalogo = base64_decode($datalogo);
              $image_name= 'logo_'.time().'.png';
              $path = $dir. $image_name;
              $paths  = url($dir . $image_name);
              file_put_contents($path, $datalogo);
              chmod($path, 0664);
              if ($update->logo != null) {
                $db_path = $update->logo;
                if (file_exists($db_path)) {
                  unlink($db_path);
                }
              }
              $update->logo      = $path;
        }
         if ($datafav != null) {
              list($type, $datafav) = explode(';', $datafav);
              list(, $datafav)      = explode(',', $datafav);
              if(!file_exists($dir_fav)){
                  mkdir($dir_fav, 0777, true);
                   chmod($dir_fav, 0777);
              }

              $datafav = base64_decode($datafav);
              $image_name= 'fav_'.time().'.png';
              $pathfav = $dir_fav. $image_name;
              $pathss  = url($dir_fav . $image_name);
              file_put_contents($pathfav, $datafav);
              chmod($pathfav, 0664);
              if ($update->fav != null) {
                $db_pathfav = $update->fav;
                if (file_exists($db_pathfav)) {
                  unlink($db_pathfav);
                }
              }
              $update->fav      = $pathfav;
        }

        $update->nama               = $req->nama;
        $update->slogan             = $req->slogan;
        $update->email              = $req->email;
        $update->save();
        if ($update) {
	      $json_data = array(
	            "success"         => TRUE,
	            "message"         => 'Data Umum berhasil diperbarui.'
	         );
	    }else{
	       $json_data = array(
	            "success"         => FALSE,
	            "message"         => 'Data Umum gagal diperbarui.'
	         );
	    }

      }else{
        $insert = new About;
        if ($datalogo != null) {

              list($type, $datalogo) = explode(';', $datalogo);
              list(, $datalogo)      = explode(',', $datalogo);
              if(!file_exists($dir)){
                  mkdir($dir, 0777, true);
                   chmod($dir, 0777);
              }
              $datalogo = base64_decode($datalogo);
              $image_name= 'logo_'.time().'.png';
              $path = $dir. $image_name;
              $paths  = url($dir . $image_name);
              file_put_contents($path, $datalogo);
              chmod($path, 0664);

        }else{
           $path="";
        }
        if ($datafav != null) {

              list($type, $datafav) = explode(';', $datafav);
              list(, $datafav)      = explode(',', $datafav);
              if(!file_exists($dir_fav)){
                  mkdir($dir_fav, 0777, true);
                   chmod($dir_fav, 0777);
              }
              $datafav = base64_decode($datafav);
              $image_name= 'fav_'.time().'.png';
              $pathfav = $dir_fav. $image_name;
              $pathfavs  = url($dir_fav . $image_name);
              file_put_contents($pathfav, $datafav);
              chmod($pathfav, 0664);

        }else{
           $pathfav="";
        }
        $insert->logo               = $path;
        $insert->fav                = $pathfav;
        $insert->nama               = $req->nama;
        $insert->slogan             = $req->slogan;
        $insert->email              = $req->email;
        $insert->save();
        if($insert) {
          $json_data = array(
                "success"         => TRUE,
                "message"         => 'Data Umum berhasil ditambahkan.'
          );
        }else{
          $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data Umum gagal ditambahkan.'
          );
        }
      }
      return json_encode($json_data);
  }

  public function simpanInfo(Request $req)
  {

      $update = About::first();
      if($update){
        $update->description        = $req->tentang;
        $update->googlemap          = $req->googlemap;
        $update->no_hp              = $req->no_hp;
        $update->website            = $req->website;
        $update->office             = $req->office;
        $update->meta_title         = $req->meta_title;
        $update->meta_description   = $req->meta_description;
        $update->keywords           = $req->keywords;
        $update->save();
        if ($update) {
        $json_data = array(
              "success"         => TRUE,
              "message"         => 'Data Info berhasil diperbarui.'
           );
      }else{
         $json_data = array(
              "success"         => FALSE,
              "message"         => 'Data Info gagal diperbarui.'
           );
      }

      }else{
        $insert = new About;

        $insert->description        = $req->tentang;
        $insert->googlemap          = $req->googlemap;
        $insert->no_hp              = $req->no_hp;
        $insert->website            = $req->website;
        $insert->office             = $req->office;
        $insert->meta_title         = $req->meta_title;
        $insert->meta_description   = $req->meta_description;
        $insert->keywords           = $req->keywords;
        $insert->save();
        if($insert) {
          $json_data = array(
                "success"         => TRUE,
                "message"         => 'Data Info berhasil ditambahkan.'
          );
        }else{
          $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data Info gagal ditambahkan.'
          );
        }
      }
      return json_encode($json_data);
  }
  public function simpanMedia(Request $req)
  {

      $update = About::first();
      if($update){
        $update->twitter            = $req->twitter;
        $update->facebook           = $req->facebook;
        $update->instagram          = $req->instagram;
        $update->linkedIn           = $req->linkedIn;
        $update->save();
        if ($update) {
        $json_data = array(
              "success"         => TRUE,
              "message"         => 'Data Media Sosial berhasil diperbarui.'
           );
      }else{
         $json_data = array(
              "success"         => FALSE,
              "message"         => 'Data Media Sosial gagal diperbarui.'
           );
      }

      }else{
        $insert = new About;

        $insert->twitter            = $req->twitter;
        $insert->facebook           = $req->facebook;
        $insert->instagram          = $req->instagram;
        $insert->linkedIn           = $req->linkedIn;
        $insert->save();
        if($insert) {
          $json_data = array(
                "success"         => TRUE,
                "message"         => 'Data Media Sosial berhasil ditambahkan.'
          );
        }else{
          $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data Media Sosial gagal ditambahkan.'
          );
        }
      }
      return json_encode($json_data);
  }

}
