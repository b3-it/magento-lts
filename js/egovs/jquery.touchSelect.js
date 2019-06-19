(function($, window, document){
	var instanceName = "touchSelect";

	/**
	 * Plugin bei jQuery registrieren
	 */
	$.fn.touchSelect = function(options) {
		var container = $(this);

		if (!container.data(instanceName)) {
			options = $.extend({}, $.fn.touchSelect.options, options);
			var instance = new touchSelect(container, options);
			container.data(instanceName, instance);
			return instance;
		}

		return container.data(instanceName);
    }

	/**
	 * Pruefen, ob das Plugin bereits existiert
	 */
	$.fn.isTouchSelectInstalled = function() {
	    var container = $(this);
	    return container.data(instanceName) != null;
	};

	/**
	 * Optionen setzen
	 */
	$.fn.touchSelect.options = {
		'useMulti'     : false,          // Option bewirkt, das immer die Multi-Auswahl über ein Popup erzeugt wurd
		'elementID'    : null,           // ID fuer des Elementes
        'elementTitle' : null,           // Info-Titel fuer das Elementes
        'elementClass' : null,           // CSS-Klassen für die Darstellung des Elements
        'elementAttr'  : 'data-code',    // In welchem Attribut befinden sich die Schalter-Beschriftungen
        'elementData'  : 'value',        // In welchem Attribut befindet sich das Click-Ziel
        'elementInsert': '<div />',      // Struktur des einzufuegenden Elementes (als Child wird ein Link erzeugt)
        'elementParent': null,           // Wenn das neue Element nicht einzeln steht, muss hier der Parent rein
		'elementText'  : null,           // Text, welcher auf dem Schalter angezeigt wird, falls mehr als eine Option vorhanden ist
		'elementImage' : null,           // Pfad zum Bild angeben, falls der Schalter ein Bild anzeigen soll
		'countOptions' : null,           // Interne Variable mit der Anzahl der Optionen
        'flagsUse'     : false,          // Soll fuer die Anzeige ein Bild oder der Schriftzug verwendet werden
        'flagsSubPath' : '',             // Wo sind die Bilder mit den Flaggen zu finden (Relativ zum Media-Pfad)
        'flagsType'    : '',             // Welche Datei-Endung haben die Flaggen
        'uiElement'    : null,           // Elemente-ID von jQuery-UI
        'uiFindElement': false           // Wird der Wert TRUE, wird automatisch das zugehörige UI-Element gesucht
	};

	var touchSelect = function(container, options) {
		/**
		 * Initialisierung aller Eigenschaften
		 */
		this.options = options;
		this.container = container;

        this._init();
	};

	touchSelect.prototype = {
	    /**
         * Initial-Funktion
         */
        '_init': function() {
        	this._checkDefaultIsComplete();
        	this._removeElementFromPage();
        	this._removeOnChange();

        	if ( this.options.uiElement !== null ) {
        		this._moveRemoveElement(this.options.uiElement);
        	}

        	if ( this.options.countOptions == 2 && this.options.useMulti == false ) {
        		this._buildToggleButtons();
        	}
        	else {
        		this._buildMultiToggleButtons();
        	}
        },

        /**
         * URL öffnen
         */
        '_openURL': function(url) {
        	window.location.href = url;
        },

        /**
         * Alle Default-Belegungen überpruefen und gegebenenfalls komplettieren
         */
        '_checkDefaultIsComplete': function() {
        	if ( this.options.elementID == null ) {
        		this.options.elementID = $(this.container).attr('id');
        	}
        	if ( this.options.elementTitle == null ) {
        		this.options.elementTitle = $(this.container).attr('title');
        	}
        	if ( this.options.elementClass == null ) {
        		this.options.elementClass = 'button';
        	}

			if ( this.options.flagsSubPath.length == 0 ) {
				this.options.flagsSubPath = 'flags/world_22x14';
			}
			if ( this.options.flagsType.length == 0 ) {
				this.options.flagsType = 'png';
			}

        	if ( this.options.uiFindElement == true ) {
        		this.options.uiElement = this.options.elementID + '-button';
        	}

        	if ( this.options.countOptions == null ) {
        		this.options.countOptions = $('#' + this.options.elementID + ' option').length;
        	}
        },

        /**
         * Wenn ein OnChange definiert ist, muss es entfernt werden
         */
        '_removeOnChange': function() {
        	if ( $(this.container).attr('onchange') !== null ) {
        		$(this.container).removeAttr('onchange');
        	}
        },

        /**
         * Ursprungs-Element verbergen
         */
        '_removeElementFromPage': function() {
        	if ( $(this.container).css('display') !== 'none' ) {
        		this._moveRemoveElement(this.options.elementID);
        	}
        },

        /**
         * ein auf der Seite vorhandenes Element aus der Anzeige entfernen;
         * Das per JS erledigen, damit ein Fallback für normale Funktion vorhanden ist
         */
        '_moveRemoveElement': function(element) {
        	$('#' + element).css({
    			'display' : 'none',
    			'position': 'absolute',
    			'top'     : '-1000px',
    			'left'    : '-1000px'
    		});
        },

        /**
         * Wenn GENAU 2 Optionen vorhanden sind, dann einen Toggle-Schalter erzeugen
         */
        '_buildToggleButtons': function() {
        	var elementText    = $('#' + this.options.elementID + ' option:not(:selected)').attr(this.options.elementAttr);
        	var destinationURL = $('#' + this.options.elementID + ' option:not(:selected)').attr(this.options.elementData);
        	var elementNewID   = 'touch-' + this.options.elementID;

        	// Falls die Flagge angezeigt werden soll, hier das noetige Element erzeugen
        	if ( this.options.flagsUse == true ) {
        	    var image = $('<img />', {
        	    	'src'  : baseUrl + 'media/' + this.options.flagsSubPath + '/' +
		                     elementText.toLowerCase() + '.' + this.options.flagsType,
        	    	'title': elementText,
        	    	'alt'  : elementText
        	    });
        	    elementText = '';
        	}

        	if ( this.options.elementParent == null ) {
        		// Einzelnes Element einfügen
        		var newElement = $(this.options.elementInsert, {
            		'id'       : elementNewID,
            		'title'    : this.options.elementTitle,
            		'class'    : this.options.elementClass,
            		'data-dest': destinationURL,
            		'text'     : elementText
            	});

        		var neu = $(newElement).insertAfter(this.container).css('cursor', 'pointer');
        	}
        	else {
        		// Sub-Element einfügen (Listen, Container, ...)
        		var parentElem = $(this.options.elementInsert, {
        			'id': 'parent-' + elementNewID
        		});

        		var newElement = $('<a />', {
            		'href'     : 'javascript:void(0);',
            		'id'       : elementNewID,
            		'title'    : this.options.elementTitle,
            		'class'    : this.options.elementClass,
            		'data-dest': destinationURL,
            		'text'     : elementText
            	});

        		$('#' + this.options.elementParent).append(parentElem).css('cursor', 'pointer');
        		var neu = $('#parent-' + elementNewID).append(newElement).css('cursor', 'pointer');
        	}

    		// Falls die Flagge angezeigt werden soll, so muss das Element eingefügt werden
        	if ( this.options.flagsUse == true ) {
    			$('#' + elementNewID).append(image);
    		}

        	// Click-Event erzeugen, damit es bei allen Elementen funktioniert
        	neu.click(function(event){
        		// Falls das Element ein eigenes Klick-Event hat, so muss das beendet werden
        		event.preventDefault();
        		touchSelect.prototype._openURL( $('#' + elementNewID).attr('data-dest') );
        	});
        },

        /**
         * Wenn MEHR als 2 Optionen vorhanden sind oder die Option 'userMlti' TRUE ist,
		 * muss ein Drop-Down erzeugt werden
         */
        '_buildMultiToggleButtons': function() {
        	var elementNewID   = 'touch-'  + this.options.elementID;
			var elementPopupID = 'header-' + this.options.elementID;
			var elementCaption = this.options.elementText;

			// Titel ist leer, aber ein Bild wurde angegeben
			if ( this.options.elementText == null && this.options.elementImage.length ) {
				if ( lngUseImageButton == 0 ) {
					// Font-Awesome-Icvon benutzen
					elementCaption = $('<span />', {
						'id'   : elementNewID,
						'class': 'egov-lang'
					});
					// Dummy-Klasse hinzufügen, um Margin beim Link zu verhindern
					this.options.elementClass += ' skip-switch-language-fa';
				}
				else {
					// Grafik als Button benutzen
					elementCaption = $('<img />', {
						'src': this.options.elementImage
					});
				}
			}

			// Navigations-Element erzeugen
			var newElement = $('<a />', {
				'href' : 'javascript:void(0);',
				'id'   : elementNewID,
				'title': this.options.elementTitle,
				'class': this.options.elementClass,

				// da es nur angeklickt werden kann, wenn das Popup nicht aktiv ist => Block hinzufügen (jQuery-Bug bei Toggle-Event)
				'onClick': '$j(\'#' + elementPopupID + '\').addClass(\'skip-active\').toggle(\'slow\').css(\'display\', \'block\');',

				'data-target-element': '#' + elementPopupID
			});
			// Beschriftung zum Link hinzufügen
			newElement.append(elementCaption);

			// Overlay-Wrapper erzeugen
			var overlayContent = $('<div />', {
				'class': 'overlay-wrapper'
			});

			// Inhalt zum Overlay hinzufügen
			overlayContent.append(this.localCreateOverlayClose(elementPopupID))
			              .append(this.localCreateOverlayTitel)
						  .append(this.localCreateOverlayContent());

			if ( this.options.elementParent == null ) {
				$(this.options.elementInsert).append(newElement).css('cursor', 'pointer');
			}
			else {
				var parentElem = $(this.options.elementInsert, {
					'id': 'parent-' + elementNewID
				});

        		$('#' + this.options.elementParent).append(parentElem).css('cursor', 'pointer');
        		$('#parent-' + elementNewID).append(newElement).css('cursor', 'pointer');
			}

			// Popup erzeugen und zur Seite hinzufügen
			var newPopup = $('<div />', {
				'html' : overlayContent,
				'id'   : elementPopupID,
				'class': 'skip-content',
				'style': 'display:none;'
			});
			$('.page-header-container').append('<!-- Language-Switcher -->').append(newPopup);
        },

		/**
		 * Erzeugt einen Schliessen-Button
		 */
		'localCreateOverlayClose': function(popupID) {
			var element = $('<a />', {
				'href' : 'javascript:void(0)',
				'html' : 'x',
				'class': 'overlay-close',

				'onClick': '$j(\'#' + popupID + '\').removeClass(\'skip-active\').toggle(\'slow\');'
			});

			return element;
		},

		/**
		 * Erzeugt im Overlay einen DIV mit dem Titel
		 */
		'localCreateOverlayTitel': function() {
			var element = $('<div />', {
				'html' : languageSelectTitle,
				'class': 'overlay-title'
			});

			return element;
		},

		/**
		 * Erzeugt Buttons mit den Sprach-Schaltern
		 */
		'localCreateOverlayContent': function() {
			var element = $('<div />', {
				'class': 'overlay-content'
			});

			// Variablen für Schleife erzeugen
			var sourceElementID = this.options.elementID;
			var imagePath       = this.options.flagsSubPath;
			var imageType       = this.options.flagsType;

			// Alle Elemente durchsuchen und hinzufügen
			$.each( $('#' + sourceElementID + ' option'), function() {
				var lngStore    = $(this).text();                 // StoreView-Name
				var lngLanguage = $(this).attr('data-lang');      // Sprach-Code
				var lngCountry  = $(this).attr('data-country');   // Länder-Code
				var lngRegion   = $(this).attr('data-region');    // Länder-Region
				var lngLink     = $(this).val();
				var lngActive   = '';
				var bntCaption  = '';
				var btnClass    = '';

				if ($(this).prop('selected')) {
					var lngActive = ' country-current';
				}

				if ( lngShowFlags == 1 ) {
					var image = $('<img />', {
	        	    	'src'  : baseUrl + 'media/' + imagePath + '/' + lngRegion.toLowerCase() + '.' + imageType,
	        	    	'title': lngCountry,
	        	    	'alt'  : lngCountry,
						'class': 'country-image'
	        	    });
				}
				else {
					var image = $('<img />', {
	        	    	'src'  : baseUrl + 'media/flags/dummy.png',
						'class': 'country-dummy-image'
	        	    });
				}

				switch( lngButtonCaption ) {
					case '1': bntCaption = lngCountry;
					          break;
			        case '2': bntCaption = lngCountry + ' ' + lngLanguage;
					          break;
			        case '3': bntCaption = lngLanguage;
					          break;
			        case '4': bntCaption = lngRegion;
					          break;
			        case '5': bntCaption = lngStore;
					          break;
			        case '6': bntCaption = lngStore + ' ' + lngLanguage;
					          break;
					default : bntCaption = lngCountry;
				}

				if ( lngButtonRow == 1 ) {
					btnClass = ' link-block';
				}
				else {
					btnClass = ' link-inline';
				}

				var link = $('<a />', {
					'html' : image,
					'href' : lngLink,
					'class': 'county-link' + btnClass + lngActive
				});
				link.append('<span class="country-name">' + bntCaption + '</span>');

				element.append(link);
			});

			return element;
		}
	};

	window.touchSelect = touchSelect;

})(jQuery, window, document);
