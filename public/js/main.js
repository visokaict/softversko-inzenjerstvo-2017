/*
*   All about game jams
**/
slamjam.common = (function () {

    function _createURL(url, noApi) {
        if (noApi) return base_url + url;
        return base_url_api + url;
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

    function _confirmBox($element) {
        $element.on("click", function () {
            $("#modal-confirm-yes").attr("href", $element.attr("data-url"));
            $(".modal-info").css("display", "block");
            $(".modal-confirm").css({"display": "block"});
            $(".modal-info").animate({
                opacity: 1
            }, 150);
            $(".modal-info-text").html($element.attr("data-text"));
            return false;
        });
    }

    function _getDateComponents(date) {
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        var dayName = days[date.getDay()];
        var monthName = months[date.getMonth()];

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        return {
            time: strTime,
            day: date.getDate(),
            dayName: dayName,
            monthName: monthName
        };
    }

    return {
        //return what others need to use from common
        ajax: _ajax,
        createURL: _createURL,

        startLoader: _startLoader,
        stopLoader: _stopLoader,

        confirmBox: _confirmBox,
        getDateComponents: _getDateComponents
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
            $selector = $(".modal-info-text");
        }
    }

    function _print(message, type) {
        //if (_enumList[type] === undefined) return;
        _initSelector(type);

        var msg = `<div>${ message.replace(/\</g, '&lt;').replace(/\>/g, '&gt;') }</div>`;
        $(".modal-info-text").html("");
        $selector.prepend(msg);

        $('.modal-info').css({"display": "block", "opacity": 1});
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

    function _initGamesPage() {
        $('body').on('click', '#pagination-games li a', function (e) {

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
            slamjam.common.ajax({
                url: url,
                dataType: "html",
                success: function (data) {
                    slamjam.common.stopLoader();
                    $('.games-container').css('opacity', '1');
                    $('.games-container').html(data);
                },
                error: function (error) {
                    var message = "Failed to load games.";
                    try {
                        message = error.responseJSON.error.message;
                    } catch (e) {
                        //todo
                    }
    
                    slamjam.error.print(message, slamjam.error.enumList.ERROR)
                }
            });
        }
    }

    function _initOneGamePage() {
        _initSliders();
        _initGameCover();
    }

    function _initGameCover() {
        var scroll = Math.floor($(window).scrollTop() * 0.2 - 150);

        $(".game-cover-image").css("transform", "translate3d(0, " + scroll + "px, 0");

        $('.nav-tabs-custom ul.nav-tabs li a').click(function (e) {
            $('ul.nav-tabs li.active').removeClass('active');
            $(this).parent('li').addClass('active');
        })

        $(window).scroll(function () {
            scroll = Math.floor($(window).scrollTop() * 0.2 - 150);
            $(".game-cover-image").css("transform", "translate3d(0, " + scroll + "px, 0");
        });
    }

    function _initSliders() {
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            autoplay: true,
            stagePadding: 50,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });

        $('.item a').magnificPopup({
            type: 'image',
            mainClass: 'mfp-fade'
        });
    }

    return {
        initGamesPage: _initGamesPage,
        initOneGamePage: _initOneGamePage,
    }

})();

/*
*   All about badges
**/
slamjam.badges = (function () {

    function _renderBadge(badgeData) {
        var removeHtml = `<a href="javascript:void(0)" class="remove-badge-a" data-id="${badgeData.idGameSubmissionsBadge}">
                             <i class="fa fa-times"></i>
                         </a>`;

        var result = `<div class="col-md-4 col-xs-6 col-sm-4 relative-badge">
                         <img style="width: 100%;" src="${slamjam.common.createURL("/" + badgeData.path, true)}" alt="${badgeData.alt}" title="${badgeData.name}">
                         ${window.__user && badgeData.idUser == __user.idUser ? removeHtml : ''}
                      </div>`;
        return result;
    }

    function _initBadgesOnGamesPage() {

        slamjam.common.ajax({
            url: slamjam.common.createURL(`/games/${idGameSubmission}/badges`),
            success: function (data) {
                if (data && data.length) {
                    var badgesHtml = data.map(function (item) {
                        return _renderBadge(item);
                    });

                    $("#badgesRenderedList").html(badgesHtml.join(''));
                } else {
                    $("#badgesRenderedList").html("<i>There is currently no badges for this game.</i>");
                }
            },
            error: function (error) {
                var message = "Getting game badges has failed.";
                try {
                    message = error.responseJSON.error.message;
                } catch (e) {
                    //todo
                }

                slamjam.error.print(message, slamjam.error.enumList.ERROR)
            }
        });

        //init button
        $("#btnAddBadge").on('click', function () {

            var badgeId = $("#gamesBadgesList").val();
            if (badgeId == null) return;

            slamjam.common.ajax({
                url: slamjam.common.createURL(`/games/${idGameSubmission}/badges/${badgeId}`),
                method: "POST",
                success: function (data) {
                    var badge = _renderBadge(data);
                    var $parent = $("#badgesRenderedList");
                    if ($parent.find("i").length) {
                        $parent.html(badge);
                    } else {
                        $parent.append(badge);
                    }
                },
                error: function (error) {
                    var message = "Posting game badge has failed.";
                    try {
                        message = error.responseJSON.error.message;
                    } catch (e) {
                        //todo
                    }

                    slamjam.error.print(message, slamjam.error.enumList.ERROR)
                }
            });
        });

        $("#badgesRenderedList").on("click", ".remove-badge-a", function () {
            var $this = $(this);
            var badgeId = $this.data('id');
            if (badgeId) {
                slamjam.common.ajax({
                    url: slamjam.common.createURL(`/games/${idGameSubmission}/badges/${badgeId}`),
                    method: "DELETE",
                    success: function (data) {
                        $this.parent().remove();

                        var $parent = $("#badgesRenderedList");
                        if ($parent && $parent.children().length === 0) {
                            $parent.html("<i>There is currently no badges for this game.</i>");
                        }
                    },
                    error: function (error) {
                        var message = "Removing game badge has failed.";
                        try {
                            message = error.responseJSON.error.message;
                        } catch (e) {
                            //todo
                        }

                        slamjam.error.print(message, slamjam.error.enumList.ERROR)
                    }
                });
            }
        });
    }

    return {
        initBadgesOnGamesPage: _initBadgesOnGamesPage,
    };
})();

/*
*   All about game jams
**/
slamjam.gameJam = (function () {
    //todo

    function _initChart() {
        // create a dataset with items
        // note that months are zero-based in the JavaScript Date object, so month 3 is April

        var colorArray = ["#5CB2CC", "#5C7fCC", "#6B5CCC", "#CC5CC8", "#CC5C96", "#CC5C64",
        "#CC875C", "#CCB95C", "#ACCC5C", "#7ACC5C", "#5CCC71", "#5CCCA3", "#5CA1CC", "#7C5CCC",
        "#5C5ECC", "#FA5C5C", "#5CCC92", "#5CCC71", "#5CA1CC", "#5CCC81", "#5CCCB3", "#69CC5C"];

        function _mapChartData(data) {

            var i = 0;

            var parsedData = data.map(function (item) {
                return {
                    id: item.idGameJam,
                    group: item.idGameJam, // so items are in one line
                    content: item.title + "<span class='game-jam-chart-count'>(" + item.countJoined + " joined)</span>",
                    start: new Date(Number(item.startDate) * 1000),
                    end: new Date(Number(item.votingEndDate) * 1000),
                    link: "game-jams/" + item.idGameJam,
                    //style: "background-color: " + colorArray[Math.floor(Math.random() * colorArray.length)],
                    style: "background-color: " + colorArray[i++ % colorArray.length],
                    className: "chart-game-jam-bar"
                };
            });

            return new vis.DataSet(parsedData);
        }

        function _mapChartGroups(data) {
            var parsedData = data.map(function (item) {
                return {
                    id: item.idGameJam,
                    content: "",
                    className: "chart-game-jam-group"
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
                maxHeight: 500,
                editable: false,
                clickToUse: false,
                zoomable: false,
                selectable: false,
                orientation: 'both', // add both up and down labels
                start: date,
                end: (new Date()).setDate(date.getDate() + timelineDuration),
                template: function (data, x, y) {
                    return `<a href='${data.link}'>${data.content}</a>`;
                },
                margin: {
                    item: {
                        horizontal: 0
                    }
                },
                stack: false
            };

            var items = _mapChartData(data);
            var groups = _mapChartGroups(data);

            var timeline = new vis.Timeline(container);
            timeline.setOptions(options);
            timeline.setItems(items);
            timeline.setGroups(groups);
            timeline.moveTo(date);
        }

        slamjam.common.ajax({
            url: slamjam.common.createURL('/game-jams/chart'),
            success: function (data) {
                if (data) {
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
        $('body').on('click', '.pagination-game-jams li a', function (e) {
            e.preventDefault();

            var page = $(this).attr("data-page");
            var gameJamsType = $(this).attr("data-type");
            var gameJamsClass = "";

            if (gameJamsType === "inProgress") {
                gameJamsClass = ".game-jams-in-progress-container";
                $(gameJamsClass).css('opacity', '0.5');
            }
            else {
                gameJamsClass = ".game-jams-upcoming-container";
                $(gameJamsClass).css('opacity', '0.5');
            }

            slamjam.common.startLoader();

            getGameJams(page, gameJamsType, gameJamsClass);
            //window.history.pushState("", "", url);
        });


        function getGameJams(page, gameJamsType, gameJamsClass) {
            slamjam.common.ajax({
                data: {
                    page: page,
                    gameJamsType: gameJamsType
                },
                dataType: "html",
                success: function (data) {
                    slamjam.common.stopLoader();
                    $(gameJamsClass).css('opacity', '1');
                    $(gameJamsClass).html(data);
                },
                error: function (error) {
                    var message = "Failed to load game jams.";
                    try {
                        message = error.responseJSON.error.message;
                    } catch (e) {
                        //todo
                    }
    
                    slamjam.error.print(message, slamjam.error.enumList.ERROR)
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
        $('body').on('click', '.pagination-game-jams-search li a', function (e) {
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
            $.ajax({
                data: {
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
    var timeagoInstance = null;

    function _renderComment(data) {
        var isCreator = window.__user && data.idUser == __user.idUser;

        var removeHtml = `<a href="javascript:void(0)" class="remove-comment-a" data-id="${data.idGameSubmissionComment}">
                             <i class="fa fa-times"></i>
                         </a>`;
        var editHtml = `<a href="javascript:void(0)" class="edit-comment-a" data-id="${data.idGameSubmissionComment}">
                             <i class="fa fa-edit"></i>
                         </a>`;

        var result = `<li>
                            <div class="comment-main-level">
                                <!-- Avatar -->
                                <div class="comment-avatar"><img src="${data.avatarImagePath}" alt="User avatar"></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name ${idGameSubmissionUserCreatorId == data.idUser ? 'by-author' : (isCreator ? 'by-me' : '') }"><a href="${slamjam.common.createURL('/user/' + data.username, true)}">${data.username}</a></h6>
                                        <span>${timeagoInstance.format(data.editedAt + "000")}</span>

                                        ${isCreator ? (removeHtml + editHtml) : ''}
                                    </div>
                                    <div class="comment-content">
                                        ${data.text}
                                    </div>
                                </div>
                            </div>
                        </li>`

        return result;
    }

    function _getCommentsAndRenderView() {
        slamjam.common.ajax({
            url: slamjam.common.createURL(`/games/${idGameSubmission}/comments`),
            success: function (data) {
                if (data && data.length) {
                    data.sort(function(a,b){ return a.createdAt - b.createdAt; });
                    var commentsHtml = data.map(function (item) {
                        return _renderComment(item);
                    });

                    $("#comments-list").html(commentsHtml.join(''));
                } else {
                    $("#comments-list").html("<i>There is currently no comment for this game.</i>");
                }
            },
            error: function (error) {
                var message = "Getting game comments has failed.";
                try {
                    message = error.responseJSON.error.message;
                } catch (e) {
                    //todo
                }

                slamjam.error.print(message, slamjam.error.enumList.ERROR)
            }
        });
    }

    function _initAddCommentBiding() {
        //
        //edit binding
        $("#btnAddComment").on("click", function () {

            var comment = $("#comment").val();

            if (comment) {
                slamjam.common.ajax({
                    url: slamjam.common.createURL(`/games/${idGameSubmission}/comments`),
                    method: "POST",
                    data: {text: comment},
                    success: function (data) {
                        if (data) {
                            var commentsHtml = _renderComment(data);
                            $("#comments-list").append(commentsHtml);
                        }

                        //reset form
                        $("#comment").val("");
                    },
                    error: function (error) {
                        var message = "Posting game comment has failed.";
                        try {
                            message = error.responseJSON.error.message;
                        } catch (e) {
                            //todo
                        }

                        slamjam.error.print(message, slamjam.error.enumList.ERROR)
                    }
                });
            }

        });
    }

    function _initRemoveCommentBiding() {
        $("#comments-list").on("click", ".remove-comment-a", function () {
            var $this = $(this);
            var commentId = $this.data("id");

            if (commentId) {
                slamjam.common.ajax({
                    url: slamjam.common.createURL(`/games/${idGameSubmission}/comments/${commentId}`),
                    method: "DELETE",
                    success: function (data) {
                        // remove comment
                        $this.closest('li').remove();
                    },
                    error: function (error) {
                        var message = "Removing game comment has failed.";
                        try {
                            message = error.responseJSON.error.message;
                        } catch (e) {
                            //todo
                        }

                        slamjam.error.print(message, slamjam.error.enumList.ERROR)
                    }
                });
            }
        });
    }

    function _initUpdateCommentBiding() {
        $("#comments-list").on("click", ".edit-comment-a", function () {
            var commentid = $(this).data("id");
            var $text = $(this).parent().next();

            if (commentid && $text.length) {
                var editHtml = `<div class="input-group">
                    <textarea type="text" class="form-control resize-vertical">${$text.text().trim()}</textarea>
                    <a href="javascript:void(0)" data-id="${commentid}" class="input-group-addon update-comment-a"><i class="fa fa-check"></i></a>
                  </div>`;

                // insert update html
                $text.html(editHtml);
            }
        });

        $("#comments-list").on("click", ".update-comment-a", function () {

            var commentId = $(this).data("id");
            var commentText = $(this).prev().val();
            var $parent = $(this).parent();

            if (commentId && commentText) {

                slamjam.common.ajax({
                    url: slamjam.common.createURL(`/games/${idGameSubmission}/comments/${commentId}`),
                    method: "PATCH",
                    data: {text: commentText},
                    success: function (data) {
                        $parent.html(commentText);
                    },
                    error: function (error) {
                        var message = "Removing game comment has failed.";
                        try {
                            message = error.responseJSON.error.message;
                        } catch (e) {
                            //todo
                        }

                        slamjam.error.print(message, slamjam.error.enumList.ERROR)
                    }
                });

            }
        });
    }

    function _initGameSubmissionComments() {
        //init timeago instance
        timeagoInstance = timeago();

        _getCommentsAndRenderView();

        _initAddCommentBiding();
        _initRemoveCommentBiding();

        _initUpdateCommentBiding();
    }

    return {
        initGameSubmissionComments: _initGameSubmissionComments,
    };
})();

/*
*   Downloads
* */
slamjam.downloads = (function () {
    var $gameNumberOfDownloads = null;

    function _findDownloadElement() {
        if ($gameNumberOfDownloads === null) {
            $gameNumberOfDownloads = $("#gameNumOfDownloads");
        }
        return $gameNumberOfDownloads;
    }

    function _increment() {
        var $el = _findDownloadElement();

        var value = $el.text();
        if (!isNaN(value)) {
            $el.text((Number(value) + 1));
        }
    }

    return {
        increment: _increment,
    }
})();

/*
*   Validation
* */
slamjam.validation = (function () {
    // add validation rules to validator
    $('form[data-toggle="validator"]').validator({
        custom: {

            // make it so it works with multiple files

            //custom file size validation
            filesize: function ($el) {
                var maxKilobytes = $el.data('filesize') * 1024;

                if ($el[0].files[0] && $el[0].files[0].size > maxKilobytes) {
                    return "File must be smaller than " + $el.data('filesize') + " kB."
                }
            },
            //custom file type validation
            filetype: function ($el) {
                var acceptableTypes = $el.data('filetype').split(',');
                var file = $el[0].files[0];

                if (file && acceptableTypes.indexOf(file.type) === -1) {
                    return "Invalid file type"
                }
            },
            "datetime-gt": function ($el) {
                //
                // this is not that robust
                // no time for now
                //
                var datetimeformat = $el.data('datetime-gt');
                var value = $el.val();
                var ONE_DAY = 86400;

                if (value) {
                    var isDef = false;

                    switch (datetimeformat) {
                        case 'now':
                            //check if time is gt then Date.now, if not return false
                            break;
                        case 'one-day':
                            if (new Date(value).getTime() < (Date.now() + ONE_DAY)) {
                                return "Date need to be at least 1 day from now.";
                            }
                            break;
                        default:
                            isDef = true;
                            break;
                    }

                    //
                    //this is default case
                    if (isDef) {
                        var fromEl = $(datetimeformat).val();

                        if(fromEl && new Date(value).getTime() < (new Date(fromEl).getTime() + ONE_DAY)){
                            return "Date need to be at least 1 day from time before.";
                        }
                    }
                }
            },
            //add more if needed
        }
    });

    return {};
})();

