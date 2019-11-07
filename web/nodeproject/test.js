const mtg = require('mtgsdk')
const http = require('http')
const url = require('url')

http.createServer((req, res) => {
    console.log(`Connection from ${req.socket.remoteAddress}`)
    if (url.parse(req.url).pathname === '/set') {
        let found = 0
        let all = mtg.set.all()
        let q = url.parse(req.url, true).query;
        res.writeHead(200, {'Content-Type': 'text/html'})
        res.write('<head><title>Set Search</title><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></head><body>')
        res.write('<div class="container"><h3 class="display-4">Set Search</h3><table class="table table-striped table-hover"><thead><tr><th class="text-muted">#</th><th>Code</th><th>Name</th>')
        if ((q.type || '').toLowerCase() === 'all') {
            res.write('<th>Type</th>')
        }
        res.write('</tr></thead><tbody>')
        all.on('data', function(set) {
            if ((q.type || '').toLowerCase() === 'all'|| set.type === (q.type || 'core').toLowerCase()) {
                res.write(`<tr><td>${++found}</td><td>${set.code}</td><td><a href="./cards?set=${set.code}">${set.name}</a></td>`)
                if ((q.type || '').toLowerCase() === 'all') {
                    res.write(`<td>${set.type}</td>`)
                }
                res.write('</tr>')
            }
        })
        all.on('error', console.error)
        all.on('end', () => {
            res.end('</tbody></table></div></body>')
        })
    } else if (url.parse(req.url).pathname === '/cards') {
        let q = url.parse(req.url, true).query;
        if (q == null || q.set == null) {
            res.writeHead(302, {'Location':'/set'})
            res.end()
        } else {
            let all = mtg.card.all({set: `${q.set}`})
            res.writeHead(200, {'Content-Type':'text/html'})
            res.write('<head><title>Card Search</title><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></head><body>')
            res.write('<div class="container"><h3 class="display-4">Card Search</h3><table class="table table-striped table-hover"><thead><tr><th class="text-muted">#</th><th>Name</th><th>Type</th><th>Rarity</th><th>P/T</th></tr></thead><tbody>')
            all.on('data', (card) => {
                // id name rarity p/t
            res.write(`<tr><td>${card.multiverseid}</td><td><a href="./card?id=${card.id}">${card.name}</a></td><td>${card.type}</td><td>${card.rarity}</td><td>${card.power || 'N'}/${card.toughness || 'A'}</td></tr>`)
            })
            all.on('error', console.error)
            all.on('end', () => {
                res.end('</tbody></table></div></body>')
            })
        }
    } else if (url.parse(req.url).pathname === '/card') {
        let q = url.parse(req.url, true).query;
        if (q == null || q.id == null) {
            res.writeHead(302, {'Location':'/set'})
            res.end()
        } else {
            res.writeHead(200, {'Content-Type':'text/html'})
            mtg.card.find(q.id).then(result => {
                res.end(`<img src="${result.card.imageUrl}" alt="${result.card.name}" />`)
            })
        }
    } else {
        res.writeHead(404, {'Content-Type': 'text/html'})
        res.end('<h1 style="text-align: center;">Page Not Found</h1>')
    }
}).listen(8080, () => { console.log('HTTP server listening on port 8080') })







