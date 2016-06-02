$(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/linearConvolution',
            data: $('form').serialize(),
            success: function (res) {
                res = JSON.parse(res);
                debugger
                var tdCoef = $('td#' + res.coef.alternative), tdPriority = $('td#' + res.priority.alternative);
                for(var i = 1; i <= res.coef.alternative; i++) {
                    debugger
                    $('td#' + i).text('E' + i);
                }
                $("td").removeClass('danger');
                //
                tdCoef.text(tdCoef.text() + ' by coef');
                tdPriority.text(tdPriority.text() + ' by priority');
                tdCoef.addClass('danger');
                tdPriority.addClass('danger');
                var coefTable = buildCoefTable(res.coef);
                //$('div#response').text(coefTable);
            }
        });
    });
});

function buildCoefTable(data)
{

   debugger
}