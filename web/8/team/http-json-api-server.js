'use strict';
const http = require('http');
const url = require('url');

http.createServer(function(req, res) {
    if (req.method !== 'GET') { res.end(); }
    res.writeHead(200, {'Content-Type': 'application/json'});
    let iso = new Date(url.parse(req.url, true).query.iso);
    var json = null;
    if (url.parse(req.url).pathname === '/api/parsetime') {
        json = { hour: iso.getHours(), minute: iso.getMinutes(), second: iso.getSeconds() };
    } else if (url.parse(req.url).pathname === '/api/unixtime') {
        json = { unixtime: iso.getTime() };
    } else {
        res.writeHead(404);
        res.end();
    }
    res.end(JSON.stringify(json));
}).listen(process.argv[2]);