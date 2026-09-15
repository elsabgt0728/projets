var express = require('express');
var router = express.Router();
let fs= require("fs");


// jeu  snake case 
router.get('/mots-meles', function(req, res, next) {
  res.render('mots-meles');
});


module.exports = router
