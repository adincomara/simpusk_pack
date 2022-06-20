@extends('layouts.table')
@section('title', 'Tentang')
@section('menu1', 'Pengaturan')
@section('menu2', 'Tentang')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <h3>Tentang</h3>
    </div>
    <div class="row m-t-lg">
        <div class="col-lg-12">
            <div class="tabs-container">

                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li style="min-width: 200px"><a class="nav-link active" data-toggle="tab" href="#tab-umum"> Umum</a></li>
                        <li style="min-width: 200px"><a class="nav-link" data-toggle="tab" href="#tab-info">Info</a></li>
                        <li style="min-width: 200px"><a class="nav-link" data-toggle="tab" href="#tab-medsos">Media Sosial</a></li>
                    </ul>
                    <div class="tab-content ">
                        <div id="tab-umum" class="tab-pane active">
                            <div class="panel-body">
                                <form action="#" id="submitData">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="card-body media align-items-center">
                                        <img src="{{isset($about)? $fav : 'https://ui-avatars.com/api/?name=R-T-I&background=ed4626&color=ffffff&rounded=true&length=3'}}"  id="Favicon" alt="" class="d-block ui-w-80">
                                        <div class="media-body ml-4">
                                            <label class="btn bg-background btn-sm">
                                                Upload Favicon Baru
                                                <input type="file" class="account-settings-fileinput" id="ubahfav" name="ubahfav">
                                            </label> &nbsp;
                                            <input type="hidden" name="inifav" value="" id="inifav">
                                        </div>
                                    </div>
                                    <hr class="border-light m-0">
                                    <div class="card-body media align-items-center">
                                        <img src="{{isset($about)? $logo : 'https://ui-avatars.com/api/?name=R-T-I&background=ed4626&color=ffffff&rounded=true&length=3'}}" id="Logo" alt="" class="d-block ui-w-80">
                                        <div class="media-body ml-4">
                                        <label class="btn bg-background btn-sm">
                                            Upload Logo Baru
                                            <input type="file" class="account-settings-fileinput" id="ubahlogo" name="ubahlogo">
                                        </label> &nbsp;

                                        <input type="hidden" name="inilogo" value="" id="inilogo">

                                        </div>
                                    </div>
                                    <hr class="border-light m-0">

                                    <div class="card-body">
                                        <div class="form-group">
                                        <label class="form-label">Nama <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="nama" id="nama" value="{{isset($about)? $about->nama : ''}}">
                                        </div>
                                        <div class="form-group ">
                                        <label class="form-label">Slogan <span>*</span></label>
                                        <textarea class="form-control" rows="3" name="slogan" id="slogan">{{isset($about)? $about->slogan : ''}}</textarea>
                                        </div>
                                        <div class="form-group">
                                        <label class="form-label">E-mail <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="email" id="email" value="{{isset($about)? $about->email : ''}}">
                                        </div>

                                        <div class="text-right mt-3">

                                        @can('about.simpan')
                                        <button type="submit" class="btn btn-primary" id="simpan">Simpan Data Umum</button>&nbsp;
                                        @endcan
                                        <button type="button" class="btn btn-default">Batal</button>
                                        </div>

                                    </div>
                                    </form>
                            </div>
                        </div>
                        <div id="tab-info" class="tab-pane">
                            <div class="panel-body">

                                <form action="#" id="submitDataInfo">
                                    <div class="card-body pb-2">

                                    <div class="form-group">
                                        <label class="form-label">Tentang <span>*</span></label>
                                        <textarea class="form-control textarea editor" rows="5" name="tentang" id="tentang" required="">{{isset($about)? ($about->description==null?'Ini tentang perusahaan':$about->description) : 'ini tentang perusahaan'}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Alamat</label>
                                    <textarea class="form-control" rows="2" name="office" id="office">{{isset($about)? $about->office : ''}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Google Maps</label>
                                    <textarea class="form-control" rows="2" name="googlemap" id="googlemap">{{isset($about)? $about->googlemap : ''}}</textarea>
                                    </div>



                                    </div>
                                    <hr class="border-light m-0">
                                    <div class="card-body pb-2">

                                    <h6 class="mb-4">Kontak</h6>
                                    <div class="form-group">
                                        <label class="form-label">No HP <span>*</span></label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{isset($about)? $about->no_hp : ''}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Website <span>*</span></label>
                                        <input type="text" class="form-control" id="website" name="website" value="{{isset($about)? $about->website : ''}}">
                                    </div>

                                    </div>
                                    <hr class="border-light m-0">
                                    <div class="card-body pb-2">

                                    <h6 class="mb-4">Meta</h6>
                                    <div class="form-group">
                                        <label class="form-label">Meta Title </label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{isset($about)? $about->meta_title : ''}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Meta Dekripsi</label>
                                    <textarea class="form-control" rows="3" name="meta_description" id="meta_description">{{isset($about)? $about->meta_description : ''}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keyword</label>
                                        <input type="text" class="form-control" id="keywords" name="keywords" value="{{isset($about)? $about->keywords : ''}}" placeholder="pisahkan dengan koma(,)">
                                    </div>

                                    </div>
                                    <div class="text-right mt-3">
                                    @can('about.simpan')
                                        <button type="submit" id="simpaninfo" class="btn btn-primary">Simpan Data Info</button>&nbsp;
                                    @endcan
                                    <button type="button" class="btn btn-default">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="tab-medsos" class="tab-pane">
                            <div class="panel-body">

                                <div class="card-body pb-2">
                                    <form action="#" id="submitDataMedia">
                                    <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="url" class="form-control" value="{{isset($about)? $about->twitter : ''}}" id="twitter" name="twitter">
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label">Facebook</label>
                                    <input type="url" class="form-control" value="{{isset($about)? $about->facebook : ''}}" id="facebook" name="facebook">
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="url" class="form-control" value="{{isset($about)? $about->linkedln : ''}}" id="linkedln" name="linkedln">
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <input type="url" class="form-control" value="{{isset($about)? $about->meta_title : ''}}" name="instagram" id="instagram">
                                    </div>
                                    <div class="text-right mt-3">
                                    @can('about.simpan')
                                    <button type="submit" id="simpanmedia" class="btn btn-primary">Simpan</button>&nbsp;
                                    @endcan

                                    <button type="button" class="btn btn-default">Batal</button>
                                    </div>
                                </form>
                                </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

@endsection
@push('scripts')
<script type="text/javascript">

    $('#submitData').validate({
      rules: {
        nama:{
          required: true
        },
        slogan:{
          required: true
        },
        email:{
          required: true,
          email:true
        }
      },
      messages: {
        nama: {
          required: "Nama Perusahaan tidak boleh kosong"
        },
        slogan: {
          required: "Slogan Perusahaan tidak boleh kosong"
        },
        email: {
          required: "Email tidak boleh kosong",
          email :"Hanya menerima email contoh demo@gmail.com",
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        // console.log(error.);
        element.closest('.form-group').append(error);
        console.log(element.closest('.form-group').append(error));
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        $('#modals-fill-in').modal('show');
        SimpanData();
      }
    });

    $('#submitDataInfo').validate({
        ignore: ":hidden:not(.editor)",
      rules: {
        tentang:{
          required: true
        },
        no_hp: {
          required: true,
          number: true,
          minlength:10
        },
        website:{
          required: true,
          url: true
        }
      },
      messages: {
        tentang: {
          required: "Tentang Perusahaan tidak boleh kosong"
        },
        no_hp: {
          required: "No HP tidak boleh kosong",
          number :"Hanya menerima inputan angka",
          minlength:"Minimal 10 angka"
        },
        website: {
          required: "Website tidak boleh kosong",
          url :"Hanya menerima inputan contoh https://example.com",
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        console.log(element.closest('.form-group').append(error));
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        $('#modals-fill-in').modal('show');
        SimpanDataInfo();
      }
    });
     $('#submitDataMedia').validate({
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        console.log(element.closest('.form-group').append(error));
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        $('#modals-fill-in').modal('show');
        SimpanDataMedia();
      }
    });

     function SimpanData(){
          $('#simpan').addClass("disabled");
           var nama           =$('#nama').val();
           var inilogo        =$('#inilogo').val();
           var inifav         =$('#inifav').val();
           var slogan         =$('#slogan').val();
           var email          =$('#email').val();


           var dataFile = new FormData()

           dataFile.append('inilogo', inilogo);
           dataFile.append('inifav', inifav);
           dataFile.append('nama', nama);

           dataFile.append('slogan', slogan);
           dataFile.append('email', email);

          $.ajax({
            type: 'POST',
            url : "{{route('about.simpanumum')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#modals-fill-in').modal('show');
            },
            success: function(data){
              if (data.success) {
                 Swal.fire('Yes',data.message,'info');
                 window.location.reload();
              } else {
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
              $('#modals-fill-in').modal('hide');
              $('#simpan').removeClass("disabled");

            },
            error: function(data){
                 $('#simpan').removeClass("disabled");
                 $('#modals-fill-in').modal('hide');
                console.log(data);
            }
          });
      }


       function SimpanDataInfo(){
          $('#simpaninfo').addClass("disabled");
           var tentang          =$('.textarea').summernote('code');
           var googlemap        =$('#googlemap').val();
           var office           =$('#office').val();
           var no_hp            =$('#no_hp').val();
           var website          =$('#website').val();
           var meta_title       =$('#meta_title').val();
           var meta_description =$('#meta_description').val();
           var keywords         =$('#keywords').val();


           var dataFile = new FormData()

           dataFile.append('tentang', tentang);
           dataFile.append('googlemap', googlemap);
           dataFile.append('office', office);
           dataFile.append('no_hp', no_hp);
           dataFile.append('website', website);
           dataFile.append('meta_title', meta_title);
           dataFile.append('meta_description', meta_description);
           dataFile.append('keywords', keywords);

          $.ajax({
            type: 'POST',
            url : "{{route('about.simpaninfo')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#modals-fill-in').modal('show');
            },
            success: function(data){
              if (data.success) {
                 Swal.fire('Yes',data.message,'info');
                 window.location.reload();
              } else {
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
              $('#modals-fill-in').modal('hide');
              $('#simpaninfo').removeClass("disabled");

            },
            error: function(data){
                 $('#simpaninfo').removeClass("disabled");
                 $('#modals-fill-in').modal('hide');
                console.log(data);
            }
          });
      }
      function SimpanDataMedia(){
          $('#simpanmedia').addClass("disabled");

           var twitter        =$('#twitter').val();
           var facebook       =$('#facebook').val();
           var instagram      =$('#instagram').val();
           var linkedln       =$('#linkedln').val();


           var dataFile = new FormData()
           dataFile.append('twitter', twitter);
           dataFile.append('facebook', facebook);
           dataFile.append('instagram', instagram);
           dataFile.append('linkedln', linkedln);
          $.ajax({
            type: 'POST',
            url : "{{route('about.simpanmedia')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#modals-fill-in').modal('show');
            },
            success: function(data){
              if (data.success) {
                 Swal.fire('Yes',data.message,'info');
                 window.location.reload();
              } else {
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
              $('#modals-fill-in').modal('hide');
              $('#simpanmedia').removeClass("disabled");

            },
            error: function(data){
                 $('#simpanmedia').removeClass("disabled");
                 $('#modals-fill-in').modal('hide');
                console.log(data);
            }
          });
      }

     $(document).ready(function(){
      $('.textarea').summernote({
          height: 200,
          disableDragAndDrop: true,
          defaultFontName: 'Nunito',
          fontNamesIgnoreCheck: ["Nunito"],
          fontNames: ["Nunito"],
          fontSizeUnits: ['px'],
          fontSizes: ['8', '9', '10', '11', '12', '13','14','15','18', '24', '36', '48' , '64', '82', '150'],
          toolbar: [
                      ['style', ['style']],
                      ['style', ['bold', 'italic', 'underline', 'clear']],
                      ['font', ['strikethrough', 'superscript', 'subscript']],
                      ["fontname", ["fontname"]],
                      ['fontsize', ['fontsize']],
                      ['color', ['color']],
                      ["para", ["ul", "ol", "paragraph"]],
                      ["table", ["table"]],
                      ['insert', ['link', 'picture','video','hr']],
                      ['height', ['height']],
                      ['view', ['fullscreen', 'codeview', 'help']],
                    ]
          });

         $('.textarea').summernote('fontSize', 15);
         $('.textarea').summernote('fontName', 'Nunito');


     $('#tgl_lahir').bootstrapMaterialDatePicker({
      weekStart: 0,
      time: false,
      format : 'DD-MM-YYYY',
      clearButton: true
    });
     $image_crop = $('#image_demo').croppie({
        enableExif: true,
        mouseWheelZoom: true,
        viewport: {
          width:200,
          height:200,
          type:'circle'
        },
        boundary:{
          width:300,
          height:300
        }
      });
     $image_crop_fav = $('#image_favicon').croppie({
        enableExif: true,
        mouseWheelZoom: true,
        viewport: {
          width:200,
          height:200,
          type:'circle'
        },
        boundary:{
          width:300,
          height:300
        }
      });

      $('.crop_logo').click(function(event){
        $image_crop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
           $('#modalUploadLogo').modal('hide');
            $('#Logo').attr('src', response);
            document.getElementById("inilogo").value = response;
        })
      });

      $('.crop_fav').click(function(event){
        $image_crop_fav.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
           $('#modalUploadFav').modal('hide');
            $('#Favicon').attr('src', response);
            document.getElementById("inifav").value = response;
        })
      });

     $('#ubahlogo').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
          $image_crop.croppie('bind', {
            url: event.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
        console.log(this.files[0]);
        $('#modalUploadLogo').modal('show');
      });

      $('#ubahfav').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
          $image_crop_fav.croppie('bind', {
            url: event.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
        console.log(this.files[0]);
        $('#modalUploadFav').modal('show');
      });

   });
  </script>
@endpush


