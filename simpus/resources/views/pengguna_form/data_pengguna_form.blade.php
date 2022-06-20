@extends('layouts.table')
@section('title', 'Form Tambah Pengguna')
@section('menu1', 'Pengguna')
@section('menu2', 'Staff')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>{{ isset($staff)?'Ubah Pengguna':'Tambah Pengguna' }}</h3>
                    {{-- <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div> --}}
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($staff)? $enc_id : ''}}">
                        <div class="media align-items-center">
                            <img src="{{isset($staff)? $profile : 'https://ui-avatars.com/api/?name=Dwi-Prasetyo&background=ed4626&color=ffffff&rounded=true'}}" alt="" id="ShowAvatar" class="d-block ui-w-80">
                          <div class="media-body ml-3">
                            <label class="form-label d-block mb-2">Photo Profil</label>
                            <label class="btn btn-tambah btn-sm">
                              Ubah
                              <input type="file" class="user-edit-fileinput" id="avatar" name="avatar">
                            </label>
                              <input type="hidden" name="image" value="" id="image">
                          </div>
                        </div>

                        <br/>
                        <hr class="border-light m-0">
                        <br/>

                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Nama Lengkap <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="name" id="name" value="{{isset($staff)? $staff->name : ''}}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="form-label">Jenis Kelamin <span>*</span></label>
                          <div class="custom-controls-stacked">
                             <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" id="jk" value="L" {{isset($staff)? $staff->jk=='L' ? 'checked':'' : 'checked'}}>
                                <span class="form-check-label">
                                  Laki-Laki
                                </span>
                              </label>

                              <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" id="jk" value="P" {{isset($staff)? $staff->jk=='P' ? 'checked':'' : ''}}>
                                <span class="form-check-label">
                                  Perempuan
                                </span>
                              </label>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Email <span>*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{isset($staff)? $staff->email : ''}}">
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-12" style="{{isset($staff)? '':''}}">
                            <label class="form-label">{{isset($staff)?'Password Baru':'Password' }} <span>*</span></label>
                             <input type="password" class="form-control" id="password" name="password">
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">No HP <span>*</span></label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{isset($staff)? $staff->no_hp : ''}}">
                          </div>
                        </div>

                        <div class="form-row">
                        <div class="form-group col-md-12">
                          <label class="form-label">Status </label>
                          <select name="status" class="custom-select" id="status">
                            @foreach($status as $key => $row)
                            <option value="{{$key}}"{{ $selectedstatus == $key ? 'selected=""' : '' }}>{{ucfirst($row)}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label class="form-label">User Poli (Opsional)</label>
                          <select name="poli" class="custom-select" id="poli">
                              <option value="-">-</option>
                            @foreach($poli as $row)
                            @if(isset($staff))
                                @if($staff->poli == $row->id)
                                    <option value="{{$row->id}}" selected>{{ucfirst($row->nama_poli)}}</option>
                                @else
                                    <option value="{{$row->id}}">{{ucfirst($row->nama_poli)}}</option>
                                @endif
                            @else
                                <option value="{{$row->id}}">{{ucfirst($row->nama_poli)}}</option>

                            @endif

                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <div class="text-right mt-3">
                            <button type="submit" class="btn btn-simpan" id="simpan">Simpan</button>&nbsp;
                            <a href="{{route('staff.index')}}"  class="btn btn-default">Kembali</a>
                          </div>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
@push('scripts')
<script type="text/javascript">

    $('#submitData').validate({
      rules: {
        name:{
          required: true
        },
        email:{
          required: true,
          email:true
        },
        password: {
          required: true,
          minlength: 5
        },
        no_hp: {
          required: true,
          number: true,
          minlength:10
        }
      },
      messages: {
        name: {
          required: "Nama Lengkap tidak boleh kosong"
        },
        email: {
          required: "Email tidak boleh kosong",
          email :"Hanya menerima email contoh demo@gmail.com",
        },
        password: {
          required: "Password wajib diisi.",
          minlength: "Password minimal 5 karakter"
        },
        no_hp: {
          required: "No HP tidak boleh kosong",
          number :"Hanya menerima inputan angka",
          minlength:"Minimal 10 angka"
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
     function SimpanData(){
          $('#simpan').addClass("disabled");
           var enc_id         =$('#enc_id').val();
           var name           =$('#name').val();
           var image          =$('#image').val();
           var jk             =$('.form-check-input:checked').val();

           var email          =$('#email').val();
           var poli          =$('#poli').val();
           var password       =$('#password').val();
           var no_hp          =$('#no_hp').val();
           var status         =$('#status').val();

           var dataFile = new FormData()

           dataFile.append('image', image);
           dataFile.append('enc_id', enc_id);
           dataFile.append('name', name);
           dataFile.append('poli', poli);

           dataFile.append('jk', jk);
           dataFile.append('email', email);
           dataFile.append('password', password);
           dataFile.append('no_hp', no_hp);
           dataFile.append('status', status);

          $.ajax({
            type: 'POST',
            url : "{{route('staff.simpan')}}",
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
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#ShowAvatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
     }
     $(document).ready(function(){
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
      $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
          $('#modalUploadProfil').modal('hide');
          $('#ShowAvatar').attr('src', response);
          document.getElementById("image").value = response;
        })
      });

     $('#avatar').on('change', function(){
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
        $('#modalUploadProfil').modal('show');
      });

   });
</script>
@endpush


