function addToCart(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(`addToCart(${id}) => ${this.responseText}`);
            var i = Number($("#itemCount").text());
            $("#itemCount").text(i + Number(Boolean(Number(this.responseText))));
            console.log(`addToCart(${id}) => ${this.responseText}`);
        }
    }

    xhttp.open("POST", "action.php?a=add", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`id=${id}`);
}

$(function() {
    $(".removeItem").click(function(e) {
        var id = Number($(this).data("id"));
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState = 4 && this.status == 200) {
                var r = Number(this.responseText);
                if (r > 0) { // Decrease count by one
                    var i = Number($(this).parent().siblings("itemCount").text());
                    $(this).parent().siblings("itemCount").text(i - 1);
                } else { // Remove the whole row
                    $(this).parent().parent().remove();
                }
            }
        }
        xhttp.open("POST", "action.php?a=rem", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`id=${id}`);
    });
});