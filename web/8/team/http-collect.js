const http = require('http');

http.get(process.argv[2], function(res) {
    let data = '';
    res.on('data', function(chunk) { data += chunk; });
    res.on('error', console.error);
    res.on('end', function() {
        console.log(data.length);
        console.log(data);
    });
}).on('error', console.error);