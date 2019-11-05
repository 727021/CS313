var http = require('http');
var url = require('url');
var formidable = require('formidable');

var server = http.createServer(function (req, res) {
    if (req.url == '/home') {
        res.writeHead(200, {"Content-Type": "text/html"});
        res.write('<h1 style="text-align: center;">Welcome to the Home Page</h1>');
        res.end();
    } else if (req.url == '/getData') {
        res.writeHead(200, {"Content-Type": "application/json"});
        res.write('{"name":"Andrew Schimelpfening","class":"cs313"}');
        res.end();
    } else if (url.parse(req.url).pathname == '/add') {
        var q = url.parse(req.url, true).query;
        if (q.json != undefined) {
            res.writeHead(200, {"Content-Type":"application/json"});
            res.write(`{"left":${q.left},"right":${q.right},"sum":${Number(q.left) + Number(q.right)}}`);
            res.end();
        } else {
            res.writeHead(200, {"Content-Type": "text/html"});
            res.write(`<p>${q.left} + ${q.right} = ${Number(q.left) + Number(q.right)}</p>`);
            res.end();
        }
    } else if (url.parse(req.url).pathname == '/addForm') {
        res.writeHead(200, {"Content-Type": "text/html"});
        res.write('<form action="addForm" method="POST">');
        res.write('<p><input type="text" style="width: 100px;" placeholder="2" name="left"> + <input type="text" style="width: 100px;" placeholder="2" name="right"> = <button type="submit">Add</button></p>')
        res.write('</form>');
        var form = new formidable.IncomingForm();
        form.parse(req, function(err, fields, files) {
            res.write(`<p><b>Sum:</b> ${fields.left || 0} + ${fields.right || 0} = ${Number(fields.left) + Number(fields.right) || ''}</p>`);
            res.end();
        });
    } else { // 404
        res.writeHead(404, {"Content-Type": "text/html"});
        res.write('<h1 style="text-align: center;">Page Not Found</h1>');
        res.end();
    }
});

server.listen(8080);