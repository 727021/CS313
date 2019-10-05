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

function removeFromCart(id) {
    var btn = $(`[data-id="${id}"]`);
    console.log("Button clicked");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState = 4 && this.status == 200) {
            if (this.responseText != "") {
                console.log(`.removeItem.click(${id}) => ${this.responseText}`);
                var r = Number(this.responseText);
                if (r > 0) { // Decrease count by one
                    var i = Number(btn.parent().siblings(".itemCount").text());
                    btn.parent().siblings(".itemCount").text(i - 1);
                } else { // Remove the whole row
                    btn.parent().parent().remove();
                }
                var i = Number($("#itemCount").text());
                $("#itemCount").text(i - 1);
                // $(".itemCount").text(i - 1);
            }
        }
    }
    xhttp.open("POST", "action.php?a=rem", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`id=${id}`);
}