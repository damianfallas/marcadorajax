var timestamp = "0";

$( document ).ready(function() {
    $.ajaxSetup({ cache:false });
    $('#led-message').marquee();

    getData(true);
    setInterval(function(){ getData(false); }, 500);

    function getData(init) {

        $.getJSON( 'php/score.json', {
        })
        .done(function( data ) {
            //console.log(timestamp);

            if(parseInt(data['stamp']) > parseInt(timestamp)) {
                console.log(data['update-mode']);

                timestamp = data['stamp'];

                //SCORE PANELS
                if ((data['update-mode'] == 'score-update' || init)) {
                    $("#flipcounter-score-red").html(pad2(data['score-red']));
                    $("#flipcounter-score-blue").html(pad2(data['score-blue']));
                    $("#flipcounter-fouls-red").html(pad2(data['fouls-red']));
                    $("#flipcounter-fouls-blue").html(pad2(data['fouls-blue']));
                    $("#flipcounter-games").html(data['games']);
                }

                //LED MESSAGE
                if (data['update-mode'] == 'led-message-update' || init) {

                    $("#led-message").html(data['led-message']);
                    $("#led-watch").hide();
                    $("#led-message").show();
                    $("#led-message").marquee();
                }

                //UPDATE TIME
                if (data['update-mode'] == 'led-time-update' || init) {
                    $("#led-watch").remove();
                    $(".ledboard").append('<div id="led-watch"></div>');


                    $("#led-message").html(data['led-message']).hide();
                    $("#led-watch").show();
                    $('#led-watch').removeClass('blink');

                    $('#led-watch').runner({
                        countdown: true,
                        startAt: data['led-time'],
                        autostart: false,
                        stopAt: 30 * 1000,
                        format: function(value) {
                            var ms = value % 1000;
                            value = (value - ms) / 1000;
                            var secs = value % 60;
                            value = (value - secs) / 60;
                            var mins = value % 60;
                            var hrs = (value - mins) / 60;
                            ms = (ms > 99)? parseInt(ms/10) : ms;
                            return pad2(mins) + ':' + pad2(secs) + '.' + pad2(ms);
                        }
                    }).on('runnerFinish', function(eventObject, info) {
                        $('#led-watch').addClass('blink');
                    });
                } 

                //DINAMIC
                if (data['update-mode'] == 'state' || init) {
                    //console.log('data:' + data['data']);
                    //console.log('value:' +data['value']);

                    if (data['data']=='lights') {
                        if(data['value']!='true') {
                            turnon();
                        } else {
                            turnoff();
                        }
                    }

                    if (data['data']=='lights-logo') {
                        if(data['value']!='true') {
                            turnlogoon();
                        } else {
                            turnlogooff();
                        }
                    }

                    if (data['data']=='bgexp') {
                        if(data['value']!='true') {
                            bgexpon();
                            console.log("01");
                        } else {
                            bgexpoff();
                            console.log("02");
                        }
                    }

                    if (data['data']=='swatch-action') {
                        if(data['value']=='start') {
                            $('#led-watch').runner('start');
                        }
                        if(data['value']=='pause') {
                            $('#led-watch').runner('stop');
                        }
                        if(data['value']=='reset') {
                            $('#led-watch').runner('reset');
                        }
                    }
                }
            }
      });
    }

    function turnon() {
        $('.light').fadeIn();
    }

    function turnoff() {
        $('.light').fadeOut();
    }

    function turnlogoon() {
        $('.light-logo').fadeIn();
    }

    function turnlogooff() {
        $('.light-logo').fadeOut();
    }
    
    function bgexpon() {
        $('.bgvid.bgs').fadeIn();
        $('.bgvid.bg').fadeOut();
    }

    function bgexpoff() {
        $('.bgvid.bg').fadeIn();
        $('.bgvid.bgs').fadeOut();
    }
    
    function pad2(number) { 
        return (number < 10 ? '0' : '') + number; 
    }

});