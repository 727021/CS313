const http = require('http')
const fs = require('fs')
const url = require('url')
const glob = require('glob')

http.createServer((req, res) => {
    let path = url.parse(req.url).pathname.substr(1)
    fs.readFile(path, (err, data) => {
        if (err) {
            glob(`**/${path}/index.*`, {'dot':true}, (err, matches) => {
                if (err || matches.length == 0) {
                    console.error(err)
                    res.writeHead(404, {'Content-Type':'text/html'})
                    res.end(`<h1>Page "${path}" Not Found</h1>`)
                } else {
                    fs.readFile(matches[0], (err, data) => {
                        if (err) {
                            console.error(err)
                            res.writeHead(404, {'Content-Type':'text/html'})
                            res.end(`<h1>Page "${path}" Not Found</h1>`)
                        } else {
                            res.writeHead(200)
                            res.end(data.toString())
                        }
                    })
                }
            })
        } else {
            res.writeHead(200)
            res.end(data.toString())
        }
    })
}).listen(process.argv[2] || 8080)