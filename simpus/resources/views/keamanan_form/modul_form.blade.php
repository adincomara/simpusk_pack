@extends('layouts.table')
@section('title', 'Form Modul')
@section('menu1', 'Keamanan')
@section('menu2', 'Modul')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Modul</h3>
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
                    <form class="form-horizontal" id="simpanDataModul" method="POST" action="{{isset($permission)? route('permission.simpan',$enc_id) : route('permission.simpan')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Modul <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="name" id="name" value="{{isset($permission)? $permission->name : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Slug <span>*</span></label>
                              <input type="text" class="form-control" name="slug" id="slug" value="{{isset($permission)? $permission->slug : ''}}" required="">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Urutan <span>*</span></label>
                              <input type="text" class="form-control" name="urutan" id="urutan" value="{{isset($permission)? $permission->nested : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Ikon (Ionicons) <span>*</span></label>
                              <input type="text" class="form-control" name="icon" id="icon" value="{{isset($permission)? $permission->icon : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Tampil di Menu Utama? </label>
                              <select name="asmenu" class="custom-select" id="asmenu">
                                @foreach($status as $key => $row)
                                <option value="{{$key}}"{{ $selectedstatus == $key ? 'selected=""' : '' }}>{{ucfirst($row)}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('permission.index')}}"  class="btn btn-default">Kembali</a>
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
    $('#simpanDataModul').validate({
      focusInvalid: false,
     rules: {
       name:{
         required: true
       },
       slug:{
         required: true
       },
       urutan:{
         required: true
       },
       icon:{
         required: true
       }
     },
     messages: {
       name: {
         required: "Nama Modul tidak boleh kosong"
       },
       slug: {
         required: "Nama slug / route tidak boleh kosong"
       },
       urutan: {
         required: "Urutan tidak boleh kosong"
       },
       icon: {
         required: "Ikon tidak boleh kosong"
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
     }
   });
</script>
@endpush


