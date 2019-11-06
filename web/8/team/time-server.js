const net = require('net');
const strftime = require('strftime');

net.createServer(function(socket) {
    socket.end(strftime('%Y-%m-%d %H:%M', new Date()) + '\n');
}).listen(process.argv[2]);