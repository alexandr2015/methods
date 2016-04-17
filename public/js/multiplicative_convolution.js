$(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/multiplicativeConvolution',
            data: $('form').serialize(),
            success: function (res) {
                res = JSON.parse(res);
                $("td").removeClass('danger');
                $('td#' + res.coef.alternative).addClass('danger');
            }
        });
    });
});