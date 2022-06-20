@extends('layouts.table')
@section('title', 'Data Modul')
@section('judultable', 'Data Modul')
@section('menu1', 'Keamanan')
@section('menu2', 'Modul')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Data Modul</h3>
                <div class="ibox-tools">
                    @can('permission.tambah')
                        <a href="{{ route('permission.tambah') }}"><button class="btn btn-primary">Tambah Modul</button></a>
                    @endcan
                    {{-- <a class="collapse-link">
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
                    </a> --}}
                </div>
            </div>
            <div class="ibox-content">
                <!--<form action="#" method="post">
                    <div class="form-row">
                        {{ csrf_field() }}

                            <label class="col mb-4"><p style="font-size: 20px"> Pencarian </p></label>

                        <div class="col-md-3 mb-4">
                        <select class="form-control" name="typefilter" id="filter" onchange="change_filter()">
                            <option value="search">Kata Kunci</option>
                            {{-- <option value="date">Tanggal Serah Obat</option> --}}
                        </select>

                        </div>
                        <div class="col-md-6 mb-4 ml-4">

                            <div id="input" class="input-group">
                                <input type="search" name="search" class="form-control" id="key">
                            </div>
                        </div>


                        <div class="col mb-4">

                        {{-- <button type="submit" id="btn" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button> --}}
                        </div>
                    </div>
                </form> -->

                <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table1" >
            <thead>

            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Slug</th>
                <th>Ikon</th>
                <th>Menu?</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if(count($dataObj) > 0)
                      @foreach($dataObj as $n=>$data)
                      <tr>
                          <th scope="row">{{ ++$n }}</th>
                          <td>{{ $data->nested }}</td>
                          <td>{{ $data->name }}</td>
                          <td>{{ $data->slug }}</td>
                          <td><i class="fa {{ $data->icon }}"></i>&nbsp;&nbsp;&nbsp;{{ $data->icon }}</td>
                          <td>{{ ($data->asmenu) ? 'Yes' : 'No' }}</td>
                          <td> @can('permission.ubah')<a href="{{route('permission.ubah',Crypt::encrypt($data->id))}}" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;@endcan</td>
                      </tr>
                      @endforeach
                  @else
                      <tr>
                          <td colspan="10" class="text-center">no records</td>
                      </tr>
                  @endif
            </tbody>
            </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
function change_filter(){
    var type = $('#filter').val();
//    console.log(type);
    if(type == "date"){
        $("#input").html("<input type='date' name='min' class='form-control' onchange='change_date()'  id='min'><span class='input-group-addon'>to</span><input type='date' name='max' class='form-control' onchange='change_date()'  id='max'>");
    }
    else{
        $("#input").html("<input type='search' name='search' class='form-control' id='key' onkeyup='text()'>");
    }
    table.search('').draw();

}
function text(){

    var val = $('#key').val();
    table.search(val).draw();
}
    var table,tabledata,table_index;
    $(document).ready(function(){
     table =  $('#table1').DataTable({
              "pagingType": "full_numbers",
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
              responsive: true,
              language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Cari data",
              }
          });
          table.search('').draw();
        $("input[type='search']").on("keyup", function () {

            var val = $(this).val();
            console.log(val);

            table.search(val).draw();
            //console.log(table);
        });
    });
  </script>
@endpush
