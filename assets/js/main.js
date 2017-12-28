// assets/js/app.js

// loads the jquery package from node_modules

var $ = require('jquery');
require('bootstrap-sass');

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var greet = require('./greet');


$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
