@extends('layouts.admin')

@section('title')
    Polls
@endsection

@section('commands')
    <a href="#" id="createNew" class="has-tooltip"><i class="fas fa-plus"></i><span class="tooltip">Create new</span></a>
@endsection

@section('content')
    @if(count($tableData))
        @include('admin.ajax.polls')
    @else
        <i>No data found.</i>
    @endif
@endsection

@section('dataForm')
<form action="" method="POST" id="dataForm">
    <div class="form-group">
        <input type="text" name="text" id="text" class="form-control" placeholder="Text">
    </div>
    <input type="hidden" name="hiddenId" id="hiddenId"/>
    {{ csrf_field() }}
</form>
@endsection

@section('jsfiles')
<script>
    $(document).ready(function () {

        // expand row on click
        $("#content").on("click", ".main-table .expand-poll-question", function (e) {
            e.stopPropagation();
            var $target = $(this).closest("tr").next().find(".inner-table-wrap");

            $(this).toggleClass("click");

            $target.slideToggle();
        });

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

        // create new question
        $("#createNew").on("click", function (e) {
            e.preventDefault();

            clearForm("Create new question", "insert", "Create");

            $("#modal-confirm-yes").attr("data-poll-type", "question");

            $(".modal-box").css("display", "block");
            $(".modal-box").animate({
                opacity: 1
            }, 150);

            return false;
        });

        // get by id for update => fill form
        $("#content").on("click", ".main-table .data-edit a", function (e) {
            e.preventDefault();

            var type = $(this).attr("data-poll-type");
            var tableName = "";

            if(type === "question") {
                clearForm("Edit question", "update", "Save");
                tableName = "pollquestions";
            }
            else if(type === "answer") {
                clearForm("Edit answer", "update", "Save");
                tableName = "pollanswers";
            }

            var id = $(this).attr("data-id");
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $("#hiddenId").val(id);

            $.ajax({
                url: "{{ asset('/admin/get-by-id') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: csrfToken,
                    id: id,
                    tableName: tableName
                },
                success: function(data) {
                    var item = JSON.parse(data);

                    $(".modal-box").css("display", "block");
                    $(".modal-box").animate({
                        opacity: 1
                    }, 150);

                    $("#text").val(item.text);
                    $("#modal-confirm-yes").attr("data-poll-type", type);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })

            return false;
        });

        // update or insert question
        
        $("#modal-confirm-yes").on("click", function (e) {
            e.preventDefault();
            
            $('#dataForm').submit();
        });

        $('#dataForm').submit(function (e) {
            e.preventDefault();

            var resetElements = [];
            $(".inner-table-wrap:visible").each(function () {
                resetElements.push([".inner-table-wrap", $(".inner-table-wrap").index($(this)), $(this).attr("data-poll-question-id")]); 
            });

            var url = "";
            var tableName = "pollquestions";

            var op = $("#modal-confirm-yes").attr("data-operation");
            var type = $("#modal-confirm-yes").attr("data-poll-type");

            if(type == "question") {
                if(op == "update") {
                    url = "{{ asset('/admin/update/pollquestions') }}";
                }
                else {
                    url = "{{ asset('/admin/insert/pollquestions') }}";
                }
                tableName = "pollquestions";
            }
            else if(type == "answer") {
                url = "{{ asset('/admin/update/pollanswers') }}";
                tableName = "pollanswers";
            }

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

                    for(var i = 0; i < resetElements.length; i++){
                        var $element = $(resetElements[i][0] + ":eq(" + resetElements[i][1] + ")");
                        $element.show();
                        $(".table-poll-question-row[data-id='" + resetElements[i][2] + "']").find(".expand-poll-question").addClass("click");
                    }

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

        // insert answer
        $("#content").on("click", ".main-table .add-new-answer-btn", function (e) {
            e.preventDefault();
            $(this).parent().find('#dataAnswerForm').submit();
        });

        $("#content").on("keypress", ".main-table #dataAnswerForm input", function (e) {
            if(e.which == 13) {
                e.preventDefault();
                $(this).parent().submit();
                return false;
            }
        });

        $("#content").on("submit", ".main-table #dataAnswerForm", function (e) {
            e.preventDefault();

            var resetElements = [];
            $(".inner-table-wrap:visible").each(function () {
                resetElements.push([".inner-table-wrap", $(".inner-table-wrap").index($(this)), $(this).attr("data-poll-question-id")]); 
            });

            var viewName = "{{ $viewName }}";

            $.ajax({
                type: "POST",
                url: "{{ asset('/admin/insert/pollanswers') }}",
                data: $(this).serialize() + "&" + $.param({ tableName: "pollanswers", viewName: viewName }),
                beforeSend: function(data) {
                    $("#loading-overlay").css("display", "block");
                },
                success: function (data) {
                    $("#content").html(data);

                    for(var i = 0; i < resetElements.length; i++){
                        var $element = $(resetElements[i][0] + ":eq(" + resetElements[i][1] + ")");
                        $element.show();
                        $(".table-poll-question-row[data-id='" + resetElements[i][2] + "']").find(".expand-poll-question").addClass("click");
                    }

                    $(".modal-box").animate({
                        opacity: 0
                    }, 150, function () {
                        $(".modal-box").css("display", "none");
                    });

                    $(this).find("input[type='text']").val("");
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

        // select active poll question
        $("#content").on("change", ".main-table .select-active-question", function (e) {
            e.preventDefault();

            var resetElements = [];
            $(".inner-table-wrap:visible").each(function () {
                resetElements.push([".inner-table-wrap", $(".inner-table-wrap").index($(this)), $(this).attr("data-poll-question-id")]); 
            });

            var id = $(this).attr("data-id");
            var table = "pollquestions";
            var viewName = "{{ $viewName }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ asset('/admin/update/pollquestions/active') }}",
                method: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                    tableName: table,
                    viewName: viewName
                },
                beforeSend: function(data) {
                    $("#loading-overlay").css("display", "block");
                },
                success: function (data) {
                    $("#content").html(data);

                    for(var i = 0; i < resetElements.length; i++){
                        var $element = $(resetElements[i][0] + ":eq(" + resetElements[i][1] + ")");
                        $element.show();
                        $(".table-poll-question-row[data-id='" + resetElements[i][2] + "']").find(".expand-poll-question").addClass("click");
                    }
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