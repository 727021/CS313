const mymodule = require('./mymodule');

mymodule(process.argv[2], process.argv[3], function(err, data) {
    if (err) {
        return console.log(err);
    }
    data.forEach(line => {
        console.log(line);
    });
});