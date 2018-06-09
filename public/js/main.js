/*
*   All about game jams
**/
slamjam.common = (function(){

    //add one ajax handler

    //add utilitie stuff here

    //etc


    return{
        //return what others need to use from common
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
            $('.loading-overlay').css('display', 'block');

            var url = $(this).attr('href');

            getGames(url);
            //window.history.pushState("", "", url);
        });

        $("#gamesSorter").on('change', function(){
            var value = $(this).val();

            $('.games-container').css('opacity', '0.5');
            $('.loading-overlay').css('display', 'block');

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

        function getGames(url, sortBy) {
            $.ajax({
                url : url
            }).done(function (data) {
                $('.loading-overlay').css('display', 'none');
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
})();

/*
*   Comments
**/
slamjam.comments = (function(){
    //todo
})();