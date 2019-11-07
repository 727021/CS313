const http = require('http')
const fs = require('fs')

http.createServer((req, res) => {
    try {
        fs.createReadStream(process.argv[3]).pipe(res)
    } catch {
        res.writeHead(404, {'Content-Type': 'text/plain'})
        res.end('Page Not Found')
    }
}).listen(process.argv[2] || 8080)