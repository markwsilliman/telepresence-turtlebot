$(document).ready(function() {
    //when they click on any action send it to the server
    $(".action").click(function() {
        //remove all active state classes (reset)
        $(".activestate").removeClass("activestate");
        $(this).addClass("activestate");

        var domain = "http://ec2-52-11-246-12.us-west-2.compute.amazonaws.com"; //change this to your public dns
        var script = "/api.php?save=" + $(this).attr("id");

        //save the action to the server
        $.getJSON( domain + script, function( data ) {

        })
        .error(function() { alert("error communicating with server"); });
    });
    //end when they click on any action...
});