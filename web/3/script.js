function addToCart(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var i = Number($(".itemTotal").text());
            $(".itemTotal").text(i + Number(Boolean(Number(this.responseText))));
        }
    }

    xhttp.open("POST", "action.php?a=add", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`id=${id}`);
}

function removeFromCart(id) {
    var btn = $(`[data-id="${id}"]`);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState = 4 && this.status == 200) {
            if (this.responseText != "") {
                var r = Number(this.responseText);
                if (r > 0) { // Decrease count by one
                    var i = Number(btn.parent().siblings(".itemCount").text());
                    btn.parent().siblings(".itemCount").text(i - 1);
                } else { // Remove the whole row
                    btn.parent().parent().remove();
                }
                var i = Number(document.getElementsByClassName("itemTotal")[0].innerHTML);
                $(".itemTotal").each(function() { $(this).text(i - 1); });

                var price = Number(btn.parent().siblings(".itemPrice").text().replace('$', ''));
                var total = Number($("#totalPrice").text().replace('$', ''));

                $("#totalPrice").text(`$${(total - price).toFixed(2)}`);
            }
        }
    }
    xhttp.open("POST", "action.php?a=rem", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`id=${id}`);
}