var max_upload = 500;
var added      = 0;
var max_size_1 = '1024KB';
var max_size_2 = '1100KB';

$j(document).ready(function(){
    $j('#file-upload').uploadify({
        'formData'        : {
            'timestamp' : currentTimeStamp,
            'token'     : currentToken,
            'form_key'  : currentFormKey
        },
        'method'          : 'post',
        'wmode'           : 'transparent',
        'swf'             : moduleHomePath + 'lib/jquery/uploadify/uploadify.swf',
        'uploader'        : ajaxUploaderUrl,

        'removeCompleted' : true,             // fertige Dateien aus der Warteschlange entfernen
        'uploadLimit'     : max_upload,       // Hochlade-Limit       (default: 999)
        'queueSizeLimit'  : max_upload,       // Warteschlangen-Limit (default: 999)
        'fileSizeLimit'   : max_size_1,       // Dateigröße beschränken
        'multi'           : true,             // mehrere Dateien auswählen
        'progressData'    : 'speed',          // Angabe über der Progressbar (Prozent oder Geschwindigkeit)
        'auto'            : false,            // Upload nicht automatisch beginnen
        'buttonText'      : strBrowseFiles,   // Beschriftung des Buttons

        'fileTypeDesc' : strSelectImage,
        'fileTypeExts' : '*.gif; *.jpg; *.png',
        'buttonText'   : strSelectImage,

        'onInit'        : function(instance) {
            $j('#result').html('');
        },
        'onSelectError' : function(file, errorCode, errorMsg) {
            var meldung = strThisFile + file.name;
            switch(errorCode) {
                case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED :
                    meldung = '<span>' + strLimitReached + meldung + strNotAppend + '</span>';
                    break;
                case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT :
                    meldung = '<span>' + meldung + strIsWith + getFileSize(file.size) + strIsToBig + '(Max. ' + max_size_2 + ')</span>';
                    break;
                case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE :
                    meldung = '<span>' + meldung + strIsEmpty + '<br />';
                    break;
                case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE :
                    meldung = '<span>' + meldung + strInvalidFileName + '</span>';
                    break;
            }
            this.queueData.errorMsg = strError;
            $j('#result').append(meldung);
        },
        'onSelect'        : function(file) {
            added = added + 1;
            var rest_ul = max_upload - added;
            $j('#result').append('<span>' + file.name + strAppendFile + '(Rest: ' + rest_ul + ')</span>');
        },
        'onCancel'        : function(file) {
            added = added - 1;
            var rest_ul = max_upload - added;
            $j('#result').append('<span>' + file.name + strCancel + '(Rest: ' + rest_ul + ')</span>');
        },
        'onUploadError'   : function(file, errorCode, errorMsg, errorString) {
            $j('#result').append(file + '<br />Code: ' + errorCode + '<br />Msg: ' + errorMsg + '<br />Str: ' + errorString + '<br />---------------------------<br /><br />');
        },
        'onQueueComplete' : function(queueData) {
            $j('#result').append('<span>' + queueData.uploadsSuccessful + strUploadSuccess + '</span>');
        }
    });
});

function getFileSize(fileSizeInBytes) {
    var i = -1;
    var byteUnits = [' kB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB'];
    do {
        fileSizeInBytes = fileSizeInBytes / 1024;
        i++;
    } while (fileSizeInBytes > 1024);
    return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
}

function start_upload() {
    $j('#file_upload').uploadify('upload', '*');
}
