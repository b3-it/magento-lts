; <?php die(); ?>

; PHPIDS Config.ini

; General configuration settings

[General]

    ; basic settings - customize to make the PHPIDS work at all
    filter_type     = xml

    base_path       = /full/path/to/IDS/
    use_base_path   = false

    filter_path     = default_filter.xml
    tmp_path        = tmp
    scan_keys       = false

    ; in case you want to use a different HTMLPurifier source, specify it here
    ; By default, those files are used that are being shipped with PHPIDS
    HTML_Purifier_Cache = vendors/htmlpurifier/HTMLPurifier/DefinitionCache/Serializer

    ; define which fields contain html and need preparation before
    ; hitting the PHPIDS rules (new in PHPIDS 0.5)
    ;html[]          = POST.__wysiwyg

    ; define which fields contain JSON data and should be treated as such
    ; for fewer false positives (new in PHPIDS 0.5.3)
    ;json[]          = POST.__jsondata
	json[]          = POST.product.media_gallery.values;
	json[]          = REQUEST.product.media_gallery.values;
	json[]          = POST.product.media_gallery.images;
	json[]          = REQUEST.product.media_gallery.images;
	json[]          = POST.groups.payplace.fields.merchant_name.value;
	json[]          = REQUEST.groups.payplace.fields.merchant_name.value;
	
	
	
    ; define which fields shouldn't be monitored (a[b]=c should be referenced via a.b)
    ;exceptions[]    = GET.__utmz
    ;exceptions[]    = GET.__utmc


    exceptions[]    = POST.groups.address_templates.fields.html.value;
	exceptions[]    = POST.groups.address_templates.fields.js_template.value;
	exceptions[]    = POST.groups.address_templates.fields.oneline.value;
	exceptions[]    = POST.groups.address_templates.fields.pdf.value;
	exceptions[]    = POST.groups.address_templates.fields.text.value;
	exceptions[]    = POST.layout_update_xml;
	exceptions[]    = POST.content;
	exceptions[]    = REQUEST.groups.address_templates.fields.html.value;
	exceptions[]    = REQUEST.groups.address_templates.fields.js_template.value;
	exceptions[]    = REQUEST.groups.address_templates.fields.oneline.value;
	exceptions[]    = REQUEST.groups.address_templates.fields.pdf.value;
	exceptions[]    = REQUEST.groups.address_templates.fields.text.value;
	exceptions[]    = REQUEST.content;
	exceptions[]    = REQUEST.layout_update_xml;
	exceptions[]          = REQUEST.variables;
    exceptions[]          = REQUEST.template_text;
    exceptions[]          = POST.variables;
    exceptions[]          = POST.template_text;
	
	
    ; you can use regular expressions for wildcard exceptions - example: /.*foo/i

[Caching]

    ; caching:      session|file|database|memcached|apc|none
    caching         = file
    expiration_time = 600

    ; file cache
    path            = tmp/default_filter.cache

    ; database cache
    wrapper         = "mysql:host=localhost;port=3306;dbname=phpids"
    user            = phpids_user
    password        = 123456
    table           = cache

    ; memcached
    ;host           = localhost
    ;port           = 11211
    ;key_prefix     = PHPIDS

    ; apc
    ;key_prefix     = PHPIDS
