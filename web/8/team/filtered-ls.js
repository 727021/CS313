const fs = require('fs');
const path = require('path');

fs.readdir(process.argv[2], function(err, data) {
    if (err) {
        return console.log(err);
    }
    data.forEach(file => {
        if (path.extname(file) == '.' + process.argv[3]) {
            console.log(file);
        }
    });
});