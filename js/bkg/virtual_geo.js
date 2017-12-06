$j(document).ready(function(){
    scanForActiveOptions();

    $j('#virtualgeo').accordion({
        'icons': {
            "header"      : "ui-icon-plus",
            "activeHeader": "ui-icon-minus"
        },
        'activate': function(event, ui) {
            // wird aktiviert
        }
    });

    $j('#virtualgeo input[type="radio"]').on('click', function(event){
        var _sender = $j(this);

        $j('#title-' + _sender.attr('data-id') ).html(
            strPrefixSelected + ' ' +
            _sender.attr('data-name') + ' (' +
            _sender.attr('data-shortname') + ')'
        );
    });
});

function scanForActiveOptions()
{
    $j('#virtualgeo input:checked').each(function(index, element){
        $j('#title-' + $j(element).attr('data-id') ).html(
            strPrefixSelected + ' ' +
            $j(element).attr('data-name') + ' (' +
            $j(element).attr('data-shortname') + ')'
        );
    });
}
