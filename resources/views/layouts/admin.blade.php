<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Favicon-->
        <link rel="icon" href="{{asset('/images/admin-favicon.png')}}" type="image/png">

        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Anton|Roboto" rel="stylesheet"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}" type="text/css"/>
        <title>Slam Jam - @yield('title') - Admin panel</title>
    </head>
    <body>
        <div class="modal-box modal-update-box" id="modal-update-box">
            <div class="modal-box-inner">
                <div class="modal-box-header">
                    <div class="modal-close">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="modal-box-content">
                    <div class="data-form">
                        <h3 id="form-title"></h3>
                        <div class="alert alert-danger" id="form-errors">
                            <a href="#" class="close" data-hide="alert" id="hide-form-errors" aria-label="close">&times;</a>
                            <span></span>
                        </div>
                        @yield('dataForm')
                    </div>
                </div>
                <div class="modal-confirm" id="modal-confirm">
                    <a id="modal-confirm-yes" href="#" data-operation="" class="btn btn-primary">Save</a>
                    <a id="modal-confirm-no" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
        <!-- LOADER -->
        <div class="loading-overlay" id="loading-overlay"><img src="{{ asset('/images/loading.svg') }}" /></div>
        <!-- /LOADER -->
        <div class="main-container">
            <div class="menu-container">
                <div class="menu">
                    <h2 class="title"><a href="{{ asset('/') }}" target="_blank">SLAM JAM</a></h2>
                    <h3 class="sub-title">ADMIN PANEL</h3>
                    <p class="dashboards-title">DASHBOARDS</p>
                    <ul class="admin-menu-list">
                        @foreach($adminNav as $item)
                            <li @if($item['status'] == 'unfinished') class='strike-through' @endif @if(url('/admin/' . $item['url']) == $currentUrl) class="active" @endif><a href="{{ asset('/admin/' . $item['url']) }}">{{ $item['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="menu-open">
                    <span></span>
                    <a href="{{ asset('/logout') }}" class="admin-log-out">
                        <i class="fas fa-sign-out-alt has-tooltip"><i class="tooltip">Log out</i></i>
                    </a>
                </div>
            </div>
            <div class="main-content">
                <h2>@yield('title')</h2>
                <div class="main-commands">
                    @yield('commands')
                </div>
                <div class="content" id="content">
                    @yield('content')
                </div>
            </div>
        </div>
        @yield('jsfiles')
        <script>
            $(document).ready(function () {
                $(".modal-close, #modal-confirm-no").on("click", function() {
                    $(".modal-box").animate({
                        opacity: 0
                    }, 150, function() {
                        $(".modal-box").css("display", "none");
                    });
                });

                $(".modal-box").on("click", function (e) {
                    if($(e.target).attr("class") !== "modal-box modal-update-box") return;

                    $(".modal-box").animate({
                        opacity: 0
                    }, 150, function() {
                        $(".modal-box").css("display", "none");
                    });
                });

                $("#hide-form-errors").on("click", function () {
                    $(this).parent().hide();
                });

                $(".menu-open span").on("click", function () {
                    $(this).toggleClass("click");
                    if($(".menu").css("opacity") == "1") {
                        $(".menu-container").animate({ "left" : -237}, 300, function () {
                            $(".menu").css("opacity", "0");
                        });
                        $(".menu-open").css("width", "50px");
                        $(".menu-open span").css("left", "10px");
                        $(".main-content").animate({ "margin-left" : "50px"}, 450);
                    }
                    else {
                        $(".menu").css("opacity", "1");
                        $(".menu-container").animate({ "left" : 0}, 400);
                        $(".menu-open").css("width", "36px");
                        $(".menu-open span").css("left", "7px");
                        $(".main-content").animate({ "margin-left" : "283px"}, 400);
                    }
                });

                // delete
                $("#content").on("click", ".main-table .data-delete a", function (e) {
                    e.preventDefault();

                    var resetElements = [];

                    if($(this).attr("data-poll-type") === "question") {
                        var pollQuestionId = $(this).attr("data-id");
                        $(".inner-table-wrap:visible").each(function () {
                            if($(this).attr("data-poll-question-id") !== pollQuestionId) {
                                resetElements.push([".inner-table-wrap", $(".inner-table-wrap").index($(this)), $(this).attr("data-poll-question-id")]);
                            }
                        });
                        deleteData(pollQuestionId, "pollquestions", resetElements);
                    }
                    else if($(this).attr("data-poll-type") === "answer") {
                        $(".inner-table-wrap:visible").each(function () {
                            resetElements.push([".inner-table-wrap", $(".inner-table-wrap").index($(this)), $(this).attr("data-poll-question-id")]); 
                        });
                        deleteData($(this).attr("data-id"), "pollanswers", resetElements);
                    }
                    else{
                        deleteData($(this).attr("data-id"));
                    }

                    return false;
                });

                // delete selected
                $("#deleteSelected").on("click", function (e) {
                    e.preventDefault();

                    var ids = [];

                    $("input.chb-select-row").filter(function (i) {
                        this.checked ? ids.push($(this).attr("data-id")) : null;
                    });

                    if(ids.length > 0){
                        deleteData(ids);
                    }

                    return false;
                });

                // select all checkboxes
                $("#content").on("change", ".main-table #chbSelectAll", function () {
                    $("input.chb-select-row").prop("checked", this.checked);
                });

                var deleteData = function (ids, table = null, resetElements = null) {
                    var _ids = Array.isArray(ids) ? ids : [ids];

                    var url = "{{ asset('admin/delete/') }}";
                    var tableName = table === null ? "{{ !empty($tableName) ? $tableName : null }}" : table;
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var viewName = "{{ $viewName }}";

                    $.ajax({
                        url: url,
                        method: "DELETE",
                        data: {
                            _token: csrfToken,
                            viewName: viewName,
                            ids: _ids,
                            tableName: tableName
                        },
                        beforeSend: function(data) {
                            $("#loading-overlay").css("display", "block");
                        },
                        success: function (data) {
                            $("#content").html(data);

                            if(resetElements !== null) {
                                for(var i = 0; i < resetElements.length; i++){
                                    var $element = $(resetElements[i][0] + ":eq(" + resetElements[i][1] + ")");
                                    $element.show();
                                    $(".table-poll-question-row[data-id='" + resetElements[i][2] + "']").find(".expand-poll-question").addClass("click");
                                }
                                
                            }
                        },
                        complete: function() {
                            $("#loading-overlay").css("display", "none");
                        },
                        error: function (error) {
                            console.log(error.message);
                        }
                    });
                };
            });
        </script>
    </body>
</html>