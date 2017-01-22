
var args = require('system').args;
var webPage = require('webpage');
var page = webPage.create();
var address = args[1];

page.open(address, function (status) {
    page.includeJs('https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');
    if (status !== 'success') {
        console.log(page.content); //content = Null
        console.log('Unable to load the address! PHP');
        phantom.exit();
    } else {
        window.setTimeout(function () {
            var text = page.evaluate(function () { //запускаем функцию в контексте вебстраницы
                /**
                 * place your code here
                 */
                return $('body').html();
            });
            console.log(text);
            phantom.exit();
        }, 1000); // Change timeout as required to allow sufficient time
    }
});