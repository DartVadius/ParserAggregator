/*console.log('hello');
 phantom.exit();*/

/*var page = require('webpage').create(),
 system = require('system'),
 url = system.args[1]; //достаем параметр, в котором передан наш url страницы, которую мы парсим
 
 page.open(url, function (status) { //ждем загрузки страницы
 page.includeJs('https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');	//подключаем jquery
 
 var text = page.evaluate(function () { //запускаем функцию в контексте вебстраницы
 return $('body').html();
 });
 console.log(text);
 phantom.exit();
 });*/

var args = require('system').args;
var webPage = require('webpage');
var page = webPage.create();
var address = args[1];

page.open(address, function (status) {
    page.includeJs('https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');	//подключаем jquery
    if (status !== 'success') {
        console.log(page.content); //content = Null
        console.log('Unable to load the address! PHP');
        phantom.exit();
    } else {
        window.setTimeout(function () {
            var text = page.evaluate(function () { //запускаем функцию в контексте вебстраницы
                return $('body').html();
            });
            console.log(text);
            phantom.exit();
        }, 1000); // Change timeout as required to allow sufficient time
    }
});