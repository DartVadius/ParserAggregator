var csrfParam = $('meta[name="csrf-param"]').attr("content");
var csrfToken = $('meta[name="csrf-token"]').attr("content");
$(document).ready(
        function () {
            $('#test').click(function () {

                var data = {
                    url: $('#testform-url').val(),
                    method: $('#testform-method').val(),
                    rules: $('#testform-rules').val()
                };
                data[csrfParam] = csrfToken;
                $.post("/parser/parser/test", JSON.stringify(data)).done(function (data) {
                    if (data.length > 0) {
                        var newData = JSON.parse(data);
                        if (newData.page !== '') {
                            $('#title >').remove();
                            $('#text >').remove();
                            $('#data >').remove();
                            $('#title').append($('<p>').text(newData.title));
                            $('#text').append($('<p>').text(newData.text));
                            $('#data').append($('<p>').text(newData.images));
                            $('#data').append($('<p>').text(newData.tags));
                        }
                        if (newData.rule !== '') {
                            $('#rule pre').remove();
                            $('#rule').append($('<pre>').text(newData.rule));
                        }
                    }
                });
            });
        }
);