const http = require('http');
const map = require('through2-map');

http.createServer(function(req, res) {
    if (req.method != 'POST') {
        return res.end();
    }
    req.pipe(map(function(chunk) {
        return chunk.toString().toUpperCase();
    })).pipe(res);
}).listen(process.argv[2]);