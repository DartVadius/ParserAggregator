var page = require('webpage').create(),
        system = require('system'),
        url = system.args[1]; //достаем параметр, в котором передан наш url страницы, которую мы парсим

page.open(url, function (status) {
    page.injectJs('jquery-3.1.1.min.js');	//подключаем jquery

    var text = page.evaluate(function () {
        return $('body').html();
    });
    console.log(text);
    phantom.exit();
});