$(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/linearConvolution',
            data: $('form').serialize(),
            success: function (res) {
                res = JSON.parse(res);
                var tdCoef = $('td#' + res.coef.alternative), tdPriority = $('td#' + res.priority.alternative);
                //default
                tdCoef.text('E' + res.coef.alternative);
                tdPriority.text('E' + res.priority.alternative);
                $("td").removeClass('danger');
                //
                tdCoef.text(tdCoef.text() + ' by coef');
                tdPriority.text(tdPriority.text() + ' by priority');
                tdCoef.addClass('danger');
                tdPriority.addClass('danger');
                //debugger
                //var coefTable = buildCoefTable(res.coef);
                //$('div#response').text(coefTable);
            }
        });
    });
});
//
//function buildCoefTable(data)
//{
//
//    debugger
//}