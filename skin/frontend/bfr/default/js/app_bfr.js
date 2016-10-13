// Allgemeine JS-Funktionen
function removeZomm()
{
    setTimeout(function(){
        $j('div.zoomContainer').remove();
    }, 200);
}

function setTabIndex(arr)
{
    $j.each(arr, function(element, tabindex){
        $j('#' + element).attr('tabindex', tabindex);
    });
}

$j(document).ready(function(){
    removeZomm();

    $j('a.egov-product-image').click(function(){
        removeZomm();
    });
});
