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
                    <div class="box-body">
                        @if($dataSet)
                        @can('role.ubah')
                        <form class="form-horizontal" method="POST" action="{{route('role.ubah',$dataSet->id)}}">
                          @endcan
                          @elsecan('role.tambah')
                          <form class="form-horizontal" method="POST" action="{{route('role.tambah')}}">
                            @else
                            <form class="form-horizontal" method="POST" action="#">
                              @endcan
                              {{ csrf_field() }}
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="box-body">
                                <div class="form-group">
                                  <div class="col-sm-3">
                                    <label for="inputMC" class="control-label ">Nama Akses <span> *</span></label>
                                    <p class="subtitle">Wajib diisi</p>
                                  </div>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" value="{{ $dataSet ? $dataSet->name : ''}}" required>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-sm-3">
                                    <label for="inputStatus" class="control-label">Permission <span> * </span></label>
                                    <p class="subtitle">Wajib diisi.</p>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="check-box">
                                      <?php echo $checkbox_loop; ?>
                                    </div>
                                  </div>
                                </div>
                                 <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <div class="text-right mt-3">
                                      @if($dataSet)
                                      @can('role.ubah')
                                      <button type="submit" class="btn btn-primary" >Simpan</button>&nbsp;
                                      @endcan
                                      @elsecan('role.tambah')
                                      <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;
                                      @endcan
                                      <a href="{{route('role.index')}}"  class="btn btn-default">Kembali</a>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </form>
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


