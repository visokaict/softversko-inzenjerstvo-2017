@extends('layouts.admin')

@section('title')
    Game Jams
@endsection

@section('commands')
    
@endsection

@section('content')
    @if(count($tableData))
        @include('admin.ajax.gameJams')
    @else
        <i>No data found.</i>
    @endif
@endsection

@section('dataForm')
@endsection

@section('jsfiles')
<script>
    $(document).ready(function () {

        // get by id for block
        $("#content").on("change", ".main-table .checkbox-block", function (e) {
            e.preventDefault();

            var id = $(this).attr("data-id");
            var table = "{{ !empty($tableName) ? $tableName : null }}";
            var viewName = "{{ $viewName }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var isBlocked = $(this).prop("checked") == true ? 1 : 0;

            $.ajax({
                url: "{{ asset('/admin/block') }}",
                method: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                    isBlocked: isBlocked,
                    tableName: table,
                    viewName: viewName
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