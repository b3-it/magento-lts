$j(document).ready(function () {
    // Header-Welle hinzufügen
    var headerWave = $j('<div />',{
        'id'   : 'top-wave',
        'class': 'top-wave'
    });
    $j('.page').prepend(headerWave);
});