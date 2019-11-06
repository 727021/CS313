const fs = require('fs');

fs.readFile(process.argv[2], function (err, data) {
    if (err) {
        return console.log(err);
    }
    console.log(data.toString().split('\n').length - 1);
});