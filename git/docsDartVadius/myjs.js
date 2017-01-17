var page = require('webpage').create(),
        system = require('system'),
        url = system.args[1]; //достаем параметр, в котором передан наш url страницы, которую мы парсим

page.open(url, function (status) { //ждем загрузки страницы
    page.includeJs('https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');	//подключаем jquery

    var text = page.evaluate(function () { //запускаем функцию в контексте вебстраницы
        return $('body').html();
    });
    console.log(text);
    phantom.exit();
});