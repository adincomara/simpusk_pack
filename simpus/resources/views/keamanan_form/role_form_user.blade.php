@extends('layouts.table')
@section('title', 'Form Akses')
@section('menu1', 'Keamanan')
@section('menu2', 'Akses')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Akses</h3>
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
                    {{-- @can('role.user')
                    <form class="form-inline" method="POST" action="{{ route('role.user',$dataSet->id) }}">
                    @else
                    <form class="form-inline" method="POST" action="#">
                    @endcan

                    {{ csrf_field() }}

                    <div class="form-group mb-2 col-sm-2">
                        <label>Pilih User</label>
                    </div>
                    <div class="form-group col-sm-2 mb-2">
                        <select class="form-control" name="tambah_user" required>

                            @foreach($userObj as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    @can('role.user')
                        <button type="submit" class="btn btn-simpan mb-2">Simpan</button>
                    @endcan
                    </form> --}}
                    @can('role.user')
                    <form method="POST" action="{{ route('role.user',$dataSet->id) }}">
                    @else
                    <form method="POST" action="#">
                    @endcan
                    {{ csrf_field() }}
                    <div class="form-group row"><label class="col-sm-1 col-form-label">Pilih User</label>
                        <div class="col-sm-2"><select class="form-control m-b" name="tambah_user">
                            @foreach($userObj as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-sm-2">
                            @can('role.user')
                                <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                            @endcan
                        </div>

                    </div>
                    </form>
                    <div class="table-responsive">


                        <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_jabatan" >
                        <thead>

                        <tr>
                            <th class="text-left" width="5%">No</th>
                            <th class="text-left">Nama</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSet->user as $row)
                                <tr>
                                    <td class="text-left">{{$loop->iteration}}.</td>
                                    <td>{{$row->name}}</td>
                                    <td class="text-left">
                                        @can('role.user')
                                        <form class="formDelete" action="{{ route('role.user', $dataSet->id) }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="hapus_user" value="{{ $row->id }}">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




@endsection
@push('scripts')
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/icheck.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css" rel="stylesheet"/>
<script type="text/javascript">
  $(document).ready(function(){
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
});
    $(function() {


        $('.check_tree').on('ifClicked', function(e){
            var $this     = $(this),
                checked   = $this.prop("checked"),
                container = $this.closest("li"),
                parents   = container.parents("li").first().find('.check_tree').first(),
                all       = true;

            // Centang juga anak2nya
            container.find('.check_tree').each(function() {
                if(checked) {
                    $(this).iCheck('uncheck');
                }else{
                    $(this).iCheck('check');
                }
            });

            // Cek sodaranya
            container.siblings().each(function() {
                return all = ($(this).find('.check_tree').first().prop("checked") === false);
            });

            // Cek bapaknya
            if(checked) {
                parents.iCheck('check');
            }
        });

        $('.check_tree').on('ifChanged', function(e){
                var $this     = $(this),
                    checked   = $this.prop("checked"),
                    parents   = $this.closest("li").parents("li").first().find('.check_tree').first(),
                    all       = true;

                // Cek bapaknya
                if(checked) {
                    parents.iCheck('check');
                }
        });
    });
    </script>
@endpush


