@extends('layouts.admin')

@section('title')
    Game Categories
@endsection

@section('commands')
    <a href="#" id="createNew" class="has-tooltip"><i class="fas fa-plus"></i><span class="tooltip">Create new</span></a>
    <a href="#" id="deleteSelected" class="has-tooltip"><i class="fas fa-trash-alt"></i><span class="tooltip">Delete selected</span></a>
@endsection

@section('content')
    @if(count($tableData))
        @include('admin.ajax.gameCategories')
    @else
        <i>No data found.</i>
    @endif
@endsection

@section('dataForm')
<form action="" method="POST" id="dataForm">
    <div class="form-group">
        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
    </div>
    <input type="hidden" name="hiddenId" id="hiddenId"/>
    {{ csrf_field() }}
</form>
@endsection

@section('jsfiles')
<script>
    $(document).ready(function () {

        // clear form before insert or update
        function clearForm(title, operation, btn) {
            $("#form-title").html(title);
            $("#modal-confirm-yes").attr("data-operation", operation);
            $("#modal-confirm-yes").html(btn);

            $("#form-errors span").html("");
            $("#form-errors").hide();

            $("#dataForm input").not("#dataForm input[name='_token']").val("");
            $("input[type='checkbox']").prop("checked", false);
        }

        // create new
        $("#createNew").on("click", function (e) {
            e.preventDefault();

            clearForm("Create new category", "insert", "Create");

            $(".modal-box").css("display", "block");
            $(".modal-box").animate({
                opacity: 1
            }, 150);

            return false;
        });

        // get by id for update => fill form
        $("#content").on("click", ".main-table .data-edit a", function (e) {
            e.preventDefault();

            clearForm("Edit category", "update", "Save");

            var id = $(this).attr("data-id");
            var table = "{{ $tableName }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $("#hiddenId").val(id);

            $.ajax({
                url: "{{ asset('/admin/get-by-id') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: csrfToken,
                    id: id,
                    tableName: table,
                },
                success: function(data) {
                    var item = JSON.parse(data);

                    $(".modal-box").css("display", "block");
                    $(".modal-box").animate({
                        opacity: 1
                    }, 150);

                    $("#name").val(item.name);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })

            return false;
        });

        // update or insert
        
        var url = "";

        $("#modal-confirm-yes").on("click", function (e) {
            e.preventDefault();

            var op = $(this).attr("data-operation");
            
            if(op == "update") {
                url = "{{ asset('/admin/update/game-categories') }}";
            }
            else {
                url = "{{ asset('/admin/insert/game-categories') }}";
            }

            $('#dataForm').submit();
        });

        $('#dataForm').submit(function (e) {
            e.preventDefault();

            var tableName = "{{ !empty($tableName) ? $tableName : null }}";
            var viewName = "{{ $viewName }}";

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize() + "&" + $.param({ tableName: tableName, viewName: viewName }),
                beforeSend: function(data) {
                    $("#loading-overlay").css("display", "block");
                },
                success: function (data) {
                    $("#content").html(data);

                    $(".modal-box").animate({
                        opacity: 0
                    }, 150, function () {
                        $(".modal-box").css("display", "none");
                    });
                },
                complete: function() {
                    $("#loading-overlay").css("display", "none");
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    $("#form-errors span").html(err.message);
                    $("#form-errors").show();
                },
            });
        });
    });
</script>
@endsection