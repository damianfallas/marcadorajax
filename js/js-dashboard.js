$( document ).ready(function() {

    //SCORE UPDATE
    $("#btn-score-update").click(function(){
        $.post("php/score-update.php",
        {
            'update-mode' : 'score-update',
            'score-red':  $('#score-red').val(),
            'fouls-red':  $('#fouls-red').val(),
            'score-blue': $('#score-blue').val(),
            'fouls-blue': $('#fouls-blue').val(),
            'games': $('#games').val()
        },
        function(data, status){
            if(status != "success") {
                alert("Data: " + data + "\nStatus: " + status);
            }
        });
    });

    //L3D msg
    $("#btn-led-message-update").click(function(){
        $.post("php/score-update.php",
        {
            'update-mode' : 'led-message-update',
            'led-message': $('#led-message').val(),
        },
        function(data, status){
            if(status != "success") {
                alert("Data: " + data + "\nStatus: " + status);
            }
        });
    });


    //L3D watch
    $("#btn-led-time-update").click(function(){
        $.post("php/score-update.php",
        {
            'update-mode' : 'led-time-update',
            'led-time': getTime(),
        },
        function(data, status){
            if(status != "success") {
                alert("Data: " + data + "\nStatus: " + status);
            }
        });
    });


    $("#btn-score-pend").click(function(){
        $.post("php/score-update.php",
        {
            'update-mode' : 'score-update',
            'lights':  $('#lights').is(':checked'),
            'score-red':  $('#score-red').val(),
            'fouls-red':  $('#fouls-red').val(),
            'score-blue': $('#score-blue').val(),
            'fouls-blue': $('#fouls-blue').val(),
            'led-mode': $('input[name=led-mode]:checked').val(),
            'led-message': $('#led-message').val(),
            'led-time': (parseInt($('#led-minutes').val()) * 60000) + (parseInt($('#led-seconds').val()) * 1000) + parseInt($('#led-millisecond').val()),
            'games': $('#games').val()
        },
        function(data, status){
            if(status != "success") {
                alert("Data: " + data + "\nStatus: " + status);
            }
        });
    });

    function sendState(data, value) {
        $.post("php/score-update.php",
        {
            'update-mode' : 'state',
            data:  data,
            value:  value
        },
        function(data, status){
            if(status != "success") {
                alert("Data: " + data + "\nStatus: " + status);
            }
        });
    }

    $("#lights").click(function() {
        if($('#lights i').hasClass('glyphicon-eye-close')) {
            sendState('lights', true);
            $('#lights i').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
        } else {
            sendState('lights', false);
            $('#lights i').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
        }
    });

    $("#lights-logo").click(function() {
        if($('#lights-logo i').hasClass('glyphicon-record')) {
            sendState('lights-logo', true);
            $('#lights-logo i').removeClass('glyphicon-record').addClass('glyphicon-asterisk');
        } else {
            sendState('lights-logo', false);
            $('#lights-logo i').removeClass('glyphicon-asterisk').addClass('glyphicon-record');
        }
    });

    $("#btn-watch-start").click(function() {
        sendState('swatch-action', 'start');
    });

    $("#btn-watch-reset").click(function() {
        sendState('swatch-action', 'reset');
    });

    $("#btn-watch-pause").click(function() {
        sendState('swatch-action', 'pause');
    });

    $(".plus.btn").click(function() {
        steps = $(this).data('forsteps');
        steps = (steps)?steps:1;
        elem = $( '#' + $(this).data('for') );
        elem.val(parseInt(elem.val()) + steps);
    });
    $(".minus.btn").click(function() {
        steps = $(this).data('forsteps');
        steps = (steps)?steps:1;
        elem = $( '#' + $(this).data('for') );
        n = parseInt(elem.val()) - steps
        elem.val( (n<0)?0:n );
    });
    $(".plus-slider.btn").click(function() {
        steps = $(this).data('forsteps');
        steps = (steps)?steps:1;
        elem = $( '#' + $(this).data('for') );
        elem.slider('setValue',(parseInt(elem.val()) + steps));
        resetWatchTime();
    });
    $(".minus-slider.btn").click(function() {
        steps = $(this).data('forsteps');
        steps = (steps)?steps:1;
        elem = $( '#' + $(this).data('for') );
        n = parseInt(elem.slider('getValue')) - steps
        elem.slider('setValue', (n<0)?0:n ) ;
        resetWatchTime();
    });
    $("#range-minutes, #range-milliseconds, #range-seconds").on("change", function() {
        resetWatchTime();
    });

    function resetWatchTime() {
        min = $('#range-minutes').val();
        mil = $('#range-milliseconds').val();
        sec = $('#range-seconds').val();

        $('#time').val(pad2(min) + ':' + pad2(sec) + '.' + pad2(mil));
    }

    $('*[data-watchbtn]').click(function() {
        n = $(this).data('watchbtn');
        time = $('#time').val().replace(':', '').replace('.', '').substring(1,6);
        $('#time').val(time[0] + time[1] + ":" + time[2] + time[3] + "." + time[4] + n)
    });

    function getTime() {
        time =$('#time').val();
        min = time[0] + time[1];
        sen = time[3] + time[4];
        mis = time[6] + time[7];
        return (parseInt(min) * 60 * 1000) + (parseInt(sen) * 1000) + parseInt(mis);
    }

    function pad2(number) { 
        return (number < 10 ? '0' : '') + number; 
    }
});