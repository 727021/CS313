function addToCart(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var i = Number($("#itemCount").text());
            $("#itemCount").text(i + Number(this.responseText));
        }
    }
}