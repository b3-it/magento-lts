/**
 * Es wird mindestens Prototype 1.6 benötigt!
 *
 * @category    Egovs
 * @package     Egovs_Video
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

//Product.GalleryVideoSupport = Class.create();
//Product.GalleryVideoSupport.prototype = Object.extend(Product.Gallery, {
Product.GalleryVideoSupport = Class.create(Product.Gallery, {
    initialize : function(containerId, imageTypes) {
    	//Wird für getElement(...) benötigt!
    	this.containerId = containerId, this.container = $(this.containerId);
    	this.templateVideo = new Template('<tr id="__id__" class="preview">' + this
                .getElement('template_video').innerHTML + '</tr>', new RegExp(
                        '(^|.|\\r|\\n)(__([a-zA-Z0-9_]+)__)', '')
    	);
    	
    	Product.Gallery.prototype.initialize.call(this, containerId, imageTypes);    	
    },
    updateImages : function() {
        this.getElement('save').value = Object.toJSON(this.images);
        $H(this.imageTypes).each(
                function(pair) {
                    this.getFileElement('no_selection',
                            'cell-' + pair.key + ' input').checked = true;
                }.bind(this));
        this.images.each( function(row) {
            if (!$(this.prepareId(row.file))) {
                this.createImageRow(row);
            }
            this.updateVisualisation(row.file);
        }.bind(this));
        this.updateUseDefault(false);
    },
    createImageRow : function(image) {
    	var validVideoFileTypes = new Array('flv', 'avi', 'mp4');
    	var isVideo = false;
    	$(validVideoFileTypes).each(function(type) {
    		if (image.file.endsWith(type) || image.file.endsWith(type+".tmp")) {
    			isVideo = true;
    			return;
    		}
    	});
    	
    	if (isVideo) {
	    	var vars = Object.clone(image);
	        vars.id = this.prepareId(image.file);
	        var html = this.templateVideo.evaluate(vars);
	        Element.insert(this.getElement('list'), {
	            bottom :html
	        });
	
	        $(vars.id).select('input[type="radio"]').each(function(radio) {
	            radio.observe('change', this.onChangeRadio);
	        }.bind(this));
    	} else {
    		Product.Gallery.prototype.createImageRow.call(this, image);
    	}
    }
});