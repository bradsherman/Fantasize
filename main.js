// function validateText(id) {
//     var div = $('#'+id).closest("div");
//     if($('#'+id).val()==null || $('#'+id).val()=="") {
//         div.addClass("has-error");
//         return false;
//     } else {
//        div.removeClass("has-error");
//        return true;
//     }
// }

function checkInput(pos,name,div) {
    $.ajax({
        url: 'http://dsg1.crc.nd.edu/cse30246/viva/checkInput.php',
        type: 'GET',
        data: { "pos": pos , "name": name },
        contentType: 'application/json; charset=utf-8',
        success: function(response) {
            // alert(response);
            changeBox(div, response);
        },
        error: function() {
            alert("an error occurred");
        }
    });
}

function changeBox(div, response) {
    if(response == 1){
        $("#" + div).removeClass("has-error");
        $("#" + div).addClass("has-success");
    } else {
        $("#" + div).removeClass("has-success");
        $("#" + div).addClass("has-error");
    }
}
$(document).ready(function() {
    $(".signout").on('click', function() {
        window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true'; 
    });

    $("#backtest").on('click', function() {
        alert('in callback');
        document.getElementById("loadingdiv").css("display","block");
    });

    // need to change this to make sure the player is not on the team
    $("#playerInsert").on('change keypress paste input', function(){
        console.log('inside insert callback');
        var name = document.getElementById("playerInsert").value;
        var div = "insertdiv";
        checkInput("BENCH",name,div);
    });

    // need to change this to make sure the player is on the team
    $("#playerDrop").on('change keypress paste input', function() {
        var name = document.getElementById("playerDrop").value;
        var div = "dropdiv";
        checkInput("BENCH",name,div);
    });

    $("#playerSearch").on('change keypress paste input', function() {
        var name = document.getElementById("playerSearch").value;
        var div = "searchdiv";
        checkInput("BENCH",name,div);
    });

    $("#qbtext").on('change keypress paste input', function() {
        var name = document.getElementById("qbtext").value;
        var div = "qbdiv";
        checkInput("QB",name,div);
    });
    $("#wr1text").on('change keypress paste input', function() {
        var name = document.getElementById("wr1text").value;
        var div = "wr1div";
        checkInput("WR1",name,div);
    });
    $("#wr2text").on('change keypress paste input', function() {
        var name = document.getElementById("wr2text").value;
        var div = "wr2div";
        checkInput("WR2",name,div);
    });
    $("#rb1text").on('change keypress paste input', function() {
        var name = document.getElementById("rb1text").value;
        var div = "rb1div";
        checkInput("RB1",name,div);
    });
    $("#rb2text").on('change keypress paste input', function() {
        var name = document.getElementById("rb2text").value;
        var div = "rb2div";
        checkInput("RB2",name,div);
    });
    $("#tetext").on('change keypress paste input', function() {
        var name = document.getElementById("tetext").value;
        var div = "tediv";
        checkInput("TE",name,div);
    });
    $("#flextext").on('change keypress paste input', function() {
        var name = document.getElementById("flextext").value;
        var div = "flexdiv";
        checkInput("FLEX",name,div);
    });
    $("#ktext").on('change keypress paste input', function() {
        var name = document.getElementById("ktext").value;
        var div = "kdiv";
        checkInput("K",name,div);
    });
    $("#dsttext").on('change keypress paste input', function() {
        var name = document.getElementById("dsttext").value;
        var div = "dstdiv";
        checkInput("DST",name,div);
    });
    $("#bench1text").on('change keypress paste input', function() {
        var name = document.getElementById("bench1text").value;
        var div = "bench1div";
        checkInput("BENCH1",name,div);
    });
    $("#bench2text").on('change keypress paste input', function() {
        var name = document.getElementById("bench2text").value;
        var div = "bench2div";
        checkInput("BENCH2",name,div);
    });
    $("#bench3text").on('change keypress paste input', function() {
        var name = document.getElementById("bench3text").value;
        var div = "bench3div";
        checkInput("BENCH3",name,div);
    });
    $("#bench4text").on('change keypress paste input', function() {
        var name = document.getElementById("bench4text").value;
        var div = "bench4div";
        checkInput("BENCH4",name,div);
    });
    $("#bench5text").on('change keypress paste input', function() {
        var name = document.getElementById("bench5text").value;
        var div = "bench5div";
        checkInput("BENCH5",name,div);
    });
    $("#bench6text").on('change keypress paste input', function() {
        var name = document.getElementById("bench6text").value;
        var div = "bench6div";
        checkInput("BENCH6",name,div);
    });
})
