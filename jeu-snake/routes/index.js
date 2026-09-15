var express = require('express');
var router = express.Router();
let fs= require("fs");


// jeu  snake case 
router.get('/snake', function(req, res, next) {
  res.render('snake');
});


module.exports = router
