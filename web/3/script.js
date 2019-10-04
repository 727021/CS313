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
    xhttp.open("GET", `action.php?id=${id}`, true);
    xhttp.send();
}