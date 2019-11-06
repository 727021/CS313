const fs = require('fs');
const path = require('path');

module.exports = function(dir, ext, callback) {
    var result = [];
    fs.readdir(dir, function(err, data) {
        if (err) {
            return callback(err, result);
        }
        data.forEach(file => {
            if (path.extname(file) == '.' + ext) {
                result.push(file);
            }
        });
        callback(null, result);
    });
}