@extends('layouts.table')
@section('title', 'Data Jabatan')
@section('judultable', 'Data Jabatan')
@section('menu1', 'Master')
@section('menu2', 'Data Jabatan')
@section('table')
<h3>Start Date</h3>
{{ csrf_field() }}
<input type="date" name="start-date" id="start-date" class="form-control">
<h3>End Date</h3>
<input type="date" name="end-date" id="end-date" class="form-control">
<h3>Hasil</h3>
<input type="text" value="0" id="hasil" class="form-control">
@endsection
@push('scripts')
<script>
$('#start-date').change(function(){
    var end_d = $('#end-date').val();
    $.ajax({
      url: "{{ route('jabatan.ngetes') }}",
      headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
      type: "POST",
      data:{start_date: this.value, end_date: end_d},
      success: function(response){
        console.log(response);
        $('#hasil').val(response);

      }
    })
})
</script>
@endpush
