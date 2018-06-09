/*
*   All about game jams
**/
slamjam.common = (function(){

    function _createURL (url){
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
            beforeSend: function() {
                //
                // start loader
                _startLoader();
            },
            success: function(data, textStatus, jqXHR) {
                if(typeof options.success === 'function'){
                    options.success(data, textStatus, jqXHR);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(typeof options.error === 'function'){
                    options.error(jqXHR, textStatus, errorThrown);
                }
            },
            complete: function() {
                _stopLoader();

                if(typeof options.complete === 'function'){
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
    function _startLoader(){
        if($loader === null){
            //init loader selector
            $loader = $("#loading-overlay");
        }

        loaderPosition ++;
        if($loader){
            $loader.css('display', 'block');
        }
    }

    function _stopLoader(){
        --loaderPosition;

        if(loaderPosition <= 0){
            loaderPosition = 0;
            if($loader !== null)
            {
                $loader.css('display', 'none');
            }
        }
    }



    return{
        //return what others need to use from common
        ajax: _ajax,
        createURL: _createURL,

        startLoader: _startLoader,
        stopLoader: _stopLoader
    };
})();


/*
*   All about games page and games handling
**/
slamjam.games = (function(){
    //todo

    function _initGamesPage (){
        $('body').on('click', '.pagination li a', function(e) {
            e.preventDefault();

            $('.games-container').css('opacity', '0.5');
            //$('.loading-overlay').css('display', 'block');
            slamjam.common.startLoader();

            var url = $(this).attr('href');

            getGames(url);
            //window.history.pushState("", "", url);
        });

        $("#gamesSorter").on('change', function(){
            var value = $(this).val();

            $('.games-container').css('opacity', '0.5');

            //$('.loading-overlay').css('display', 'block');
            slamjam.common.startLoader();

            var url = window.location.href;
            var newUrl;

            var regSort = /([?&]sort)=([^#&]*)/g;

            if(!/[?&]page=/.test(window.location.search)) {
                newUrl = url + "?page=1";
            }

            if(/[?&]sort=/.test(window.location.search)) {
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
                url : url
            }).done(function (data) {
                //$('.loading-overlay').css('display', 'none');
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
slamjam.gameJam = (function(){
    //todo

    function _initChart() {
    /*
        slamjam.common.ajax({
            url: slamjam.common.createURL('/game-jams/chart'),
            success: function (data) {
                console.log(data);
            },
            error: function (error) {
                //todo
            }
        });
    */

        // create a dataset with items
        // note that months are zero-based in the JavaScript Date object, so month 3 is April
        var items = new vis.DataSet([
            {id: 0, content: 'item 0', start: new Date(2018, 5, 1), end: new Date(2018, 5, 12), link: "as"},
            {id: 1, content: 'item 1', start: new Date(2018, 5, 6), end: new Date(2018, 5, 16), link: "as"},
            {id: 2, content: 'item 2', start: new Date(2018, 5, 18), end: new Date(2018, 5, 22), link: "as"},
            {id: 3, content: 'item 2', start: new Date(2018, 5, 16), end: new Date(2018, 5, 24), link: "as"},
        ]);

        // create visualization
        var container = document.getElementById('visualization');
        var options = {
            maxHeight: 400,
            editable: false,
            clickToUse: false,
            zoomable: false,
            selectable: false,
            start: new Date(2018, 5, 14),
            template: function (data, x, y) {
                return `<a href='${data.link}'>${data.content}</a>`;
            }
        };

        var timeline = new vis.Timeline(container);
        timeline.setOptions(options);
        //timeline.setGroups(groups);
        timeline.setItems(items);


        //
        // DOCS: http://visjs.org/docs/timeline/
        //
        //dodati Start , End
        //dodaj boje neke

    }

    function _initGameJamItems() {

    }

    return {
        initChart: _initChart,
        initGameJamItems: _initGameJamItems,
    }
})();

/*
*   Comments
**/
slamjam.comments = (function(){
    //todo
})();