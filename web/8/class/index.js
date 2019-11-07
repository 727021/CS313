// > node index.js <PORT> <FILE>
const http = require('http')
const fs = require('fs')

http.createServer((req, res) => {
    fs.createReadStream(process.argv[3]).pipe(res)
}).listen(process.argv[2] || 8080)