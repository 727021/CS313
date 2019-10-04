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
    xhttp.open("POST", `action.php?a=add`, true);
    xhttp.send(`id=${id}`);
}

$(function() {
    $(".removeItem").click(function(e) {
        let i = Number($(this).parent().sibling(".itemCount").text());
        if (i > 1) { // Decrease by one

        } else { // Remove completely

        }

    });
});