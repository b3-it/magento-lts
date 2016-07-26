// Allgemeine JS-Funktionen
function setTabIndex(arr)
{
    $j.each(arr, function(element, tabindex){
        $j('#' + element).attr('tabindex', tabindex);
    });
}