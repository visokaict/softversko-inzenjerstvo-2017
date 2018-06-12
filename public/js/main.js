/*
*   All about game jams
**/
slamjam.common = (function () {

    function _createURL(url) {
        return base_url + url;
    }

    function _ajax(options) {
        //
        // add default options for ajax
        var defaultOptions = {
            data: null,
            dataType: 'json',
            url: base_url,
        };

        //
        // ajax call
        $.ajax(Object.assign({}, defaultOptions, options, {
            //
            // default function that can handle things before or after
            //
            beforeSend: function () {
                //
                // start loader
                _startLoader();
            },
            success: function (data, textStatus, jqXHR) {
                if (typeof options.success === 'function') {
                    options.success(data, textStatus, jqXHR);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (typeof options.error === 'function') {
                    options.error(jqXHR, textStatus, errorThrown);
                }
            },
            complete: function () {
                _stopLoader();

                if (typeof options.complete === 'function') {
                    options.complete();
                }
            }
        }));
    }


    /*
    *   This is Loading handler
    * */

    var loaderPosition = 0;
    var $loader = null;

    function _startLoader() {
        if ($loader === null) {
            //init loader selector
            $loader = $("#loading-overlay");
        }

        loaderPosition++;
        if ($loader) {
            $loader.css('display', 'block');
        }
    }

    function _stopLoader() {
        --loaderPosition;

        if (loaderPosition <= 0) {
            loaderPosition = 0;
            if ($loader !== null) {
                $loader.css('display', 'none');
            }
        }
    }


    return {
        //return what others need to use from common
        ajax: _ajax,
        createURL: _createURL,

        startLoader: _startLoader,
        stopLoader: _stopLoader
    };
})();

/*
*
* */
slamjam.error = (function () {

    var $selector = null;
    var _enumList = {};
    ["ERROR", "SUCCESS", "INFO", "WARNING"].map(function (item) {
        _enumList[item] = item;
    });

    var _errorTypes = {
        "ERROR": "danger",
        "SUCCESS": "success",
        "INFO": "info",
        "WARNING": "warning",
    };

    function _initSelector(type) {
        if ($selector === null) {
            // add first,
            $selector = $("#alert-messages");
        }
    }

    function _print(message, type) {
        if (_enumList[type] === undefined) return;
        _initSelector(type);

        var removeButton = `<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>`;
        var msg = `<div>${ message.replace(/\</g, '&lt;').replace(/\>/g, '&gt;') }</div>`
        $selector.prepend(`<div class="alert alert-${_errorTypes[type]}">${removeButton} ${msg}</div>`);
    }

    return {
        print: _print,
        enumList: _enumList,
    }
})();

/*
*   All about games page and games handling
**/
slamjam.games = (function () {
    //todo

    function _initGamesPage (){
        $('body').on('click', '#pagination-games li a', function(e) {

            e.preventDefault();

            $('.games-container').css('opacity', '0.5');
            slamjam.common.startLoader();

            var url = $(this).attr('href');

            getGames(url);
            //window.history.pushState("", "", url);
        });

        $("#gamesSorter").on('change', function () {
            var value = $(this).val();

            $('.games-container').css('opacity', '0.5');

            slamjam.common.startLoader();

            var url = window.location.href;
            var newUrl;

            var regSort = /([?&]sort)=([^#&]*)/g;

            if (!/[?&]page=/.test(window.location.search)) {
                newUrl = url + "?page=1";
            }

            if (/[?&]sort=/.test(window.location.search)) {
                newUrl = url.replace(regSort, "$1=" + value);
            }
            else {
                newUrl += "&sort=" + value;
            }

            getGames(newUrl);
            //window.history.pushState({state:'new'}, "", newUrl);
        });

        function getGames(url) {
            $.ajax({
                url: url
            }).done(function (data) {
                slamjam.common.stopLoader();
                $('.games-container').css('opacity', '1');
                $('.games-container').html(data);
            }).fail(function () {
                alert('Failed to load games.');
            });
        }
    }

    return {
        initGamesPage: _initGamesPage,
    }

})();

/*
*   All about game jams
**/
slamjam.gameJam = (function () {
    //todo

    function _initChart() {
        // create a dataset with items
        // note that months are zero-based in the JavaScript Date object, so month 3 is April

        function _mapChartData(data) {

            var parsedData = data.map(function (item) {
                return {
                    id: item.idGameJam,
                    group: item.idGameJam,// so items are in one line
                    content: item.title,
                    start: new Date(Number(item.startDate) * 1000),
                    end: new Date(Number(item.endDate) * 1000),
                    link: "game-jams/" + item.idGameJam,
                    //className: "", // call some type of generator that will return same css class for some value
                };
            });

            return new vis.DataSet(parsedData);
        }

        //
        // DOCS: http://visjs.org/docs/timeline/
        //
        function _createChart(data) {
            var timelineDuration = 7; // this is presented in days
            var date = new Date();

            var container = document.getElementById('visualization');
            var options = {
                maxHeight: 400,
                editable: false,
                clickToUse: false,
                zoomable: false,
                selectable: false,
                orientation: 'both', // add both up and down labels
                start: date,
                end: (new Date()).setDate(date.getDate() + timelineDuration),
                template: function (data, x, y) {
                    return `<a href='${data.link}'>${data.content}</a>`;
                }
            };

            var items = _mapChartData(data);

            var timeline = new vis.Timeline(container);
            timeline.setOptions(options);
            timeline.setItems(items);
            timeline.moveTo(date);
            //timeline.setGroups(groups);
        }


        slamjam.common.ajax({
            url: slamjam.common.createURL('/game-jams/chart'),
            success: function (data) {
                if(data) {
                    _createChart(data);
                } else {
                    $("#no-chart-game-jam").removeClass("hide");
                }
            },
            error: function (error) {
                slamjam.error.print("Fetching game jams for chart has failed.", slamjam.error.enumList.ERROR)
            }
        });
    }

    function _initGameJamItems() {
        $('body').on('click', '.pagination-game-jams li a', function(e) {
            e.preventDefault();

            var page = $(this).attr("data-page");
            var gameJamsType = $(this).attr("data-type");
            var gameJamsClass = "";

            if(gameJamsType === "inProgress"){
                gameJamsClass = ".game-jams-in-progress-container";
                $(gameJamsClass).css('opacity', '0.5');
            }
            else{
                gameJamsClass = ".game-jams-upcoming-container";
                $(gameJamsClass).css('opacity', '0.5');
            }
           
            slamjam.common.startLoader();

            getGameJams(page, gameJamsType, gameJamsClass);
            //window.history.pushState("", "", url);
        });


        function getGameJams(page, gameJamsType, gameJamsClass) {
            slamjam.common.ajax({
                url: slamjam.common.createURL('/game-jams/chart'),
                success: function (data) {
                    if(data) {
                        _createChart(data);
                    } else {
                        $("#no-chart-game-jam").removeClass("hide");
                    }
                },
                error: function (error) {
                    slamjam.error.print("Fetching game jams for chart has failed.", slamjam.error.enumList.ERROR)
                }
            });
        }
    }

    return {
        initChart: _initChart,
        initGameJamItems: _initGameJamItems,
    }
})();

/*
*   All about game jams
**/
slamjam.search = (function () {

    function _initPage() {
        $('body').on('click', '.pagination-game-jams li a', function(e) {
            e.preventDefault();

            var page = $(this).attr("data-page");
            var gameJamsType = $(this).attr("data-type");

            var gameClass = {
                gameJams: "#load-search-game-jams",
                gameSubmissions: "#load-search-game-submission",
            }
            $(gameClass[gameJamsType]).css('opacity', '0.5');


            slamjam.common.startLoader();

            getGameJams(page, gameJamsType, gameClass[gameJamsType]);
        });

        function getGameJams(page, gameJamsType, gameClass) {
            console.log(gameClass);
            $.ajax({
                data : {
                    page: page,
                    type: gameJamsType
                }
            }).done(function (data) {
                slamjam.common.stopLoader();

                $(gameClass).css('opacity', '1');
                $(gameClass).parent().replaceWith(data);

            }).fail(function () {
                alert('Failed to load game jams.');
            });
        }
    }

    return {
        initPage: _initPage,
    }
})();

/*
*   Comments
**/
slamjam.comments = (function () {
    //todo
})();