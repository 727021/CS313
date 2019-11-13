var express = require('express');
var router = express.Router();

/* GET users listing. */
router.get('/', function(req, res, next) {
  res.render('users', { pageTitle: 'Users', currentYear: new Date().getFullYear() })
});

module.exports = router;
