$("#button").click(function() {
    alert("Clicked!");
});

$("#colorButton").click(changeColor);

function changeColor() {
    var c = $("#color").val();
    $("#div1").css("background-color", c);
}

$("#fade").click(function() {
    $("#div3").fadeToggle();
});