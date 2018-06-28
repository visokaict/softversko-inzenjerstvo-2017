$(document).ready(function () {
    $(".modal-close, #modal-confirm-no").on("click", function () {
        $(".modal-box").animate({
            opacity: 0
        }, 150, function () {
            $(".modal-box").css("display", "none");
        });
    });

    $(".modal-box").on("click", function (e) {
        if ($(e.target).attr("class") !== "modal-box modal-update-box") return;

        $(".modal-box").animate({
            opacity: 0
        }, 150, function () {
            $(".modal-box").css("display", "none");
        });
    });

    $("#hide-form-errors").on("click", function () {
        $(this).parent().hide();
    });

    $(".menu-open span").on("click", function () {
        $(this).toggleClass("click");
        if ($(".menu").css("opacity") == "1") {
            $(".menu-container").animate({"left": -237}, 300, function () {
                $(".menu").css("opacity", "0");
            });
            $(".menu-open").css("width", "50px");
            $(".menu-open span").css("left", "10px");
            $(".main-content").animate({"margin-left": "50px"}, 450);
        }
        else {
            $(".menu").css("opacity", "1");
            $(".menu-container").animate({"left": 0}, 400);
            $(".menu-open").css("width", "36px");
            $(".menu-open span").css("left", "7px");
            $(".main-content").animate({"margin-left": "283px"}, 400);
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

        var url = delete_url;
        var tableName = table === null ? base_table_name : table;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var viewName = base_view_name;

        $.ajax({
            url: url,
            method: "POST",
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

slamjam.dashboard = (function(){

    function formatDate(date) {
        var dd = date.getDate();
        var mm = date.getMonth() + 1;
        var yyyy = date.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        date = yyyy + '-' + mm + '-' + dd;
        return date
    }


    function last7Days() {
        var result = [];
        for (var i = 0; i < 7; i++) {
            var d = new Date();
            d.setDate(d.getDate() - i);
            result.push({
                date: formatDate(d),
                value: 0,
            })
        }

        return result.reverse();
    }

    function combineRealWith7Days(realData) {
        var aLast7Days = last7Days();
//        console.log(aLast7Days);
//        console.log(realData);
//        console.log("");


        return aLast7Days.map(function (item) {
            var index = realData.findIndex(function(row){ return item.date === row.ndate; });
            if(index > -1){
                item.value += realData[index].data_count;
            }

            return item.value;
        });
    }

    function makeChart(selector, realData) {
        $(selector).sparkline(realData, {
            type: 'line',
            height: '20',
            width: '100%',
            lineColor: '#8EB8E5',
            fillColor: '#292c35',
            spotColor: '#DB504A',
        });

        /*var myvalues = [0, 0, 0, 2, 4, 12, 4, 8];
        $('.dynamicsparkline').each(function () {
            var $this = $(this);
            $this.sparkline(myvalues, {
                type: 'line',
                height: '20',
                width: '100%',
                lineColor: '#8EB8E5',
                fillColor: '#292c35',
                spotColor: '#DB504A',
            });
        });*/
    }



    function initChartView(chartData, metadata) {
        chartData.map(function (item) {
            var statPropName = Object.keys(item)[0];
            var chartMeta = metadata[statPropName];

            if(chartMeta){
                makeChart(
                    "#" + chartMeta["chartSelector"], //this is selector: #users
                    combineRealWith7Days(item[statPropName])// this is array data: [0, 2, 3,]
                );
            }
        });
    }

    function initCountView(countData, metadata) {
        countData.map(function (item) {
            var statPropName = Object.keys(item)[0];
            var countMeta = metadata[statPropName];

            if(countMeta){
                $("#" + countMeta["countSelector"]).text(item[statPropName]);
            }
        });
    }




    function initDashboard() {
        var statisticMetaData = {
            "users": { countSelector: "stats_count_users", chartSelector: "stats_chart_users"},
            "gameJams": { countSelector: "stats_count_gamejams", chartSelector: "stats_chart_gamejams"},
            "games": { countSelector: "stats_count_games", chartSelector: "stats_chart_games"},
            "reports": { countSelector: "stats_count_reports", chartSelector: "stats_chart_reports"},
            "comments": { countSelector: "stats_count_comments", chartSelector: "stats_chart_comments"},
            "downloadFiles": { countSelector: "stats_count_downloadfiles", chartSelector: "stats_chart_downloadfiles"},
            "images": { countSelector: "stats_count_images", chartSelector: "stats_chart_images"},
            "polls": { countSelector: "stats_count_polls", chartSelector: "stats_chart_polls"},
        };

        $.ajax({
            url: base_url_api + '/admin/statistics/chart/all',
            dataType: 'json',
            success: function (data) {
                initChartView(data, statisticMetaData);
            },
            error: function (err) {
                console.log(err);
            }
        });

        $.ajax({
            url: base_url_api + '/admin/statistics/count/all',
            dataType: 'json',
            success: function (data) {
                initCountView(data, statisticMetaData);
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    return {
        initDashboard: initDashboard,
    }
})();