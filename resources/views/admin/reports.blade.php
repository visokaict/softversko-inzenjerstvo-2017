@extends('layouts.admin')

@section('title')
    Reports
@endsection

@section('commands')
@endsection

@section('content')
    @if(count($tableData))
        @include('admin.ajax.reports')
    @else
        <p class="no-data-found">No data found.</p>
    @endif
@endsection

@section('dataForm')
@endsection

@section('jsfiles')
<script>
    $(document).ready(function () {

        // get by id for close
        $("#content").on("change", ".main-table .checkbox-block", function (e) {
            e.preventDefault();

            var id = $(this).attr("data-id");
            var table = "{{ !empty($tableName) ? $tableName : null }}";
            var viewName = "{{ $viewName }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ asset('/admin/update/reports') }}",
                method: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                    tableName: table,
                    viewName: viewName,
                    solved: 1
                },
                beforeSend: function(data) {
                    $("#loading-overlay").css("display", "block");
                },
                success: function (data) {
                    $("#content").html(data);
                },
                complete: function() {
                    $("#loading-overlay").css("display", "none");
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                }
            })
            return false;

        });

    });
</script>
@endsection