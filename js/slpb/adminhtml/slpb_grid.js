/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
var SlpbWarningGridMassaction = Class.create();
SlpbWarningGridMassaction.prototype = {
    /* Predefined vars */
    checkedValues: $H({}),
    checkedString: '',
    oldCallbacks: {},
    errorText:'',
    items: {},
    gridIds: [],
    currentItem: false,
    fieldTemplate: new Template('<input type="hidden" name="#{name}" value="#{value}" />'),
    initialize: function (containerId, grid, checkedValues, formFieldNameInternal, formFieldName) {
        this.setOldCallback('row_click', grid.rowClickCallback);
        this.setOldCallback('init',      grid.initCallback);
        this.setOldCallback('init_row',  grid.initRowCallback);
        this.setOldCallback('pre_init',  grid.preInitCallback);

        this.useAjax        = false;
        this.grid           = grid;
        this.containerId    = containerId;
        this.initMassactionElements();

        this.checkedString          = checkedValues;
        this.formFieldName          = formFieldName;
        this.formFieldNameInternal  = formFieldNameInternal;

        this.grid.initCallback      = this.onGridInit.bind(this);
        this.grid.preInitCallback   = this.onGridPreInit.bind(this);
        this.grid.initRowCallback   = this.onGridRowInit.bind(this);
        this.grid.rowClickCallback  = this.onGridRowClick.bind(this);
        this.initCheckboxes();
        this.checkCheckboxes();
    },
    setUseAjax: function(flag) {
        this.useAjax = flag;
    },
    initMassactionElements: function() {
        this.container      = $(this.containerId);
        this.form           = $(this.containerId + '-form');
        this.count          = $(this.containerId + '-count');
        this.validator      = new Validation(this.form);
        this.formHiddens    = $(this.containerId + '-form-hiddens');
        this.formAdditional = $(this.containerId + '-form-additional');
        this.select         = $(this.containerId + '-select');
        this.select.observe('change', this.onSelectChange.bindAsEventListener(this));
    },
    setGridIds: function(gridIds) {
        this.gridIds = gridIds;
        this.updateCount();
    },
    getGridIds: function() {
        return this.gridIds;
    },
    setItems: function(items) {
        this.items = items;
        this.updateCount();
    },
    getItems: function() {
        return this.items;
    },
    getItem: function(itemId) {
        if(this.items[itemId]) {
            return this.items[itemId];
        }
        return false;
    },
    getOldCallback: function (callbackName) {
        return this.oldCallbacks[callbackName] ? this.oldCallbacks[callbackName] : Prototype.emptyFunction;
    },
    setOldCallback: function (callbackName, callback) {
        this.oldCallbacks[callbackName] = callback;
    },
    onGridPreInit: function(grid) {
        this.initMassactionElements();
        this.getOldCallback('pre_init')(grid);
    },
    onGridInit: function(grid) {
        this.initCheckboxes();
        this.checkCheckboxes();
        this.updateCount();
        this.getOldCallback('init')(grid);
    },
    onGridRowInit: function(grid, row) {
        this.getOldCallback('init_row')(grid, row);
    },
    onGridRowClick: function(grid, evt) {
        var tdElement = Event.findElement(evt, 'td');

        if(!$(tdElement).down('input')) {
            if($(tdElement).down('a') || $(tdElement).down('select')) {
                return;
            }
            var trElement = Event.findElement(evt, 'tr');
            if (trElement.title) {
                setLocation(trElement.title);
            }
            return;
        }

        if(Event.element(evt).isMassactionCheckbox) {
           this.setCheckbox(Event.element(evt));
        } else if (checkbox = this.findCheckbox(evt)) {
           checkbox.checked = !checkbox.checked;
           this.setCheckbox(checkbox);
        }
    },
    onSelectChange: function(evt) {
        var item = this.getSelectedItem();
        if(item) {
            this.formAdditional.update($(this.containerId + '-item-' + item.id + '-block').innerHTML);
        } else {
            this.formAdditional.update('');
        }

        this.validator.reset();
    },
    findCheckbox: function(evt) {
        if(['a', 'input', 'select'].indexOf(Event.element(evt).tagName.toLowerCase())!==-1) {
            return false;
        }
        checkbox = false;
        Event.findElement(evt, 'tr').select('.massaction-checkbox').each(function(element){
            if(element.isMassactionCheckbox) {
                checkbox = element;
            }
        }.bind(this));
        return checkbox;
    },
    initCheckboxes: function() {
        this.getCheckboxes().each(function(checkbox) {
           checkbox.isMassactionCheckbox = true;
        }.bind(this));
    },
    checkCheckboxes: function() {
        this.getCheckboxes().each(function(checkbox) {
            checkbox.checked = varienStringArray.has(checkbox.value, this.checkedString);
        }.bind(this));
    },
    selectAll: function() {
        this.setCheckedValues(this.getGridIds());
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    unselectAll: function() {
        this.setCheckedValues('');
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    selectVisible: function() {
        this.setCheckedValues(this.getCheckboxesValuesAsString());
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    unselectVisible: function() {
        this.getCheckboxesValues().each(function(key){
            this.checkedString = varienStringArray.remove(key, this.checkedString);
        }.bind(this));
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    setCheckedValues: function(values) {
        this.checkedString = values;
    },
    getCheckedValues: function() {
        return this.checkedString;
    },
    getCheckboxes: function() {
        var result = [];
        this.grid.rows.each(function(row){
            var checkboxes = row.select('.massaction-checkbox');
            checkboxes.each(function(checkbox){
                result.push(checkbox);
            });
        });
        return result;
    },
    getCheckboxesValues: function() {
        var result = [];
        this.getCheckboxes().each(function(checkbox) {
            result.push(checkbox.value);
        }.bind(this));
        return result;
    },
    getCheckboxesValuesAsString: function()
    {
        return this.getCheckboxesValues().join(',');
    },
    setCheckbox: function(checkbox) {
        if(checkbox.checked) {
            this.checkedString = varienStringArray.add(checkbox.value, this.checkedString);
        } else {
            this.checkedString = varienStringArray.remove(checkbox.value, this.checkedString);
        }
        this.updateCount();
    },
    updateCount: function() {
        this.count.update(varienStringArray.count(this.checkedString));
        if(!this.grid.reloadParams) {
            this.grid.reloadParams = {};
        }
        this.grid.reloadParams[this.formFieldNameInternal] = this.checkedString;
    },
    getSelectedItem: function() {
        if(this.getItem(this.select.value)) {
            return this.getItem(this.select.value);
        } else {
            return false;
        }
    },
    apply: function() {
        if(varienStringArray.count(this.checkedString) == 0) {
                alert(this.errorText);
                return;
            }

        var item = this.getSelectedItem();
        if(!item) {
            this.validator.validate();
            return;
        }
        this.currentItem = item;
        var fieldName = (item.field ? item.field : this.formFieldName);
        var fieldsHtml = '';

        if(this.currentItem.confirm && !window.confirm(this.currentItem.confirm)) {
            return;
        }

        this.formHiddens.update('');
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: fieldName, value: this.checkedString}));
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: 'amount_to_order', value: $$('[name="amount_to_order"]').map(Form.Element.getValue)}));
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: 'product_keys', value: $$('[name="product_keys"]').map(Form.Element.getValue)}));
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: 'destination', value: $$('[name="destination"]').map(Form.Element.getValue)}));
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: 'package', value: $$('[name="package"]').map(Form.Element.getValue)}));

        if(!this.validator.validate()) {
            return;
        }

        if(this.useAjax && item.url) {
            new Ajax.Request(item.url, {
                'method': 'post',
                'parameters': this.form.serialize(true),
                'onComplete': this.onMassactionComplete.bind(this)
            });
        } else if(item.url) {
            this.form.action = item.url;
            this.form.submit();
        }
    },
    onMassactionComplete: function(transport) {
        if(this.currentItem.complete) {
            try {
                var listener = this.getListener(this.currentItem.complete) || Prototype.emptyFunction;
                listener(grid, this, transport);
            } catch (e) {}
       }
    },
    getListener: function(strValue) {
        return eval(strValue);
    }
};

var SlpbStockMovmentGridMassaction = Class.create();
SlpbStockMovmentGridMassaction.prototype = {
    /* Predefined vars */
    checkedValues: $H({}),
    checkedString: '',
    oldCallbacks: {},
    errorText:'',
    items: {},
    gridIds: [],
    currentItem: false,
    fieldTemplate: new Template('<input type="hidden" name="#{name}" value="#{value}" />'),
    initialize: function (containerId, grid, checkedValues, formFieldNameInternal, formFieldName) {
        this.setOldCallback('row_click', grid.rowClickCallback);
        this.setOldCallback('init',      grid.initCallback);
        this.setOldCallback('init_row',  grid.initRowCallback);
        this.setOldCallback('pre_init',  grid.preInitCallback);

        this.useAjax        = false;
        this.grid           = grid;
        this.containerId    = containerId;
        this.initMassactionElements();

        this.checkedString          = checkedValues;
        this.formFieldName          = formFieldName;
        this.formFieldNameInternal  = formFieldNameInternal;

        this.grid.initCallback      = this.onGridInit.bind(this);
        this.grid.preInitCallback   = this.onGridPreInit.bind(this);
        this.grid.initRowCallback   = this.onGridRowInit.bind(this);
        this.grid.rowClickCallback  = this.onGridRowClick.bind(this);
        this.initCheckboxes();
        this.checkCheckboxes();
    },
    setUseAjax: function(flag) {
        this.useAjax = flag;
    },
    initMassactionElements: function() {
        this.container      = $(this.containerId);
        this.form           = $(this.containerId + '-form');
        this.count          = $(this.containerId + '-count');
        this.validator      = new Validation(this.form);
        this.formHiddens    = $(this.containerId + '-form-hiddens');
        this.formAdditional = $(this.containerId + '-form-additional');
        this.select         = $(this.containerId + '-select');
        this.select.observe('change', this.onSelectChange.bindAsEventListener(this));
    },
    setGridIds: function(gridIds) {
        this.gridIds = gridIds;
        this.updateCount();
    },
    getGridIds: function() {
        return this.gridIds;
    },
    setItems: function(items) {
        this.items = items;
        this.updateCount();
    },
    getItems: function() {
        return this.items;
    },
    getItem: function(itemId) {
        if(this.items[itemId]) {
            return this.items[itemId];
        }
        return false;
    },
    getOldCallback: function (callbackName) {
        return this.oldCallbacks[callbackName] ? this.oldCallbacks[callbackName] : Prototype.emptyFunction;
    },
    setOldCallback: function (callbackName, callback) {
        this.oldCallbacks[callbackName] = callback;
    },
    onGridPreInit: function(grid) {
        this.initMassactionElements();
        this.getOldCallback('pre_init')(grid);
    },
    onGridInit: function(grid) {
        this.initCheckboxes();
        this.checkCheckboxes();
        this.updateCount();
        this.getOldCallback('init')(grid);
    },
    onGridRowInit: function(grid, row) {
        this.getOldCallback('init_row')(grid, row);
    },
    onGridRowClick: function(grid, evt) {
        var tdElement = Event.findElement(evt, 'td');

        if(!$(tdElement).down('input')) {
            if($(tdElement).down('a') || $(tdElement).down('select')) {
                return;
            }
            var trElement = Event.findElement(evt, 'tr');
            if (trElement.title) {
                setLocation(trElement.title);
            }
            return;
        }

        if(Event.element(evt).isMassactionCheckbox) {
           this.setCheckbox(Event.element(evt));
        } else if (checkbox = this.findCheckbox(evt)) {
           checkbox.checked = !checkbox.checked;
           this.setCheckbox(checkbox);
        }
    },
    onSelectChange: function(evt) {
        var item = this.getSelectedItem();
        if(item) {
            this.formAdditional.update($(this.containerId + '-item-' + item.id + '-block').innerHTML);
        } else {
            this.formAdditional.update('');
        }

        this.validator.reset();
    },
    findCheckbox: function(evt) {
        if(['a', 'input', 'select'].indexOf(Event.element(evt).tagName.toLowerCase())!==-1) {
            return false;
        }
        checkbox = false;
        Event.findElement(evt, 'tr').select('.massaction-checkbox').each(function(element){
            if(element.isMassactionCheckbox) {
                checkbox = element;
            }
        }.bind(this));
        return checkbox;
    },
    initCheckboxes: function() {
        this.getCheckboxes().each(function(checkbox) {
           checkbox.isMassactionCheckbox = true;
        }.bind(this));
    },
    checkCheckboxes: function() {
        this.getCheckboxes().each(function(checkbox) {
            checkbox.checked = varienStringArray.has(checkbox.value, this.checkedString);
        }.bind(this));
    },
    selectAll: function() {
        this.setCheckedValues(this.getGridIds());
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    unselectAll: function() {
        this.setCheckedValues('');
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    selectVisible: function() {
        this.setCheckedValues(this.getCheckboxesValuesAsString());
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    unselectVisible: function() {
        this.getCheckboxesValues().each(function(key){
            this.checkedString = varienStringArray.remove(key, this.checkedString);
        }.bind(this));
        this.checkCheckboxes();
        this.updateCount();
        return false;
    },
    setCheckedValues: function(values) {
        this.checkedString = values;
    },
    getCheckedValues: function() {
        return this.checkedString;
    },
    getCheckboxes: function() {
        var result = [];
        this.grid.rows.each(function(row){
            var checkboxes = row.select('.massaction-checkbox');
            checkboxes.each(function(checkbox){
                result.push(checkbox);
            });
        });
        return result;
    },
    getCheckboxesValues: function() {
        var result = [];
        this.getCheckboxes().each(function(checkbox) {
            result.push(checkbox.value);
        }.bind(this));
        return result;
    },
    getCheckboxesValuesAsString: function()
    {
        return this.getCheckboxesValues().join(',');
    },
    setCheckbox: function(checkbox) {
        if(checkbox.checked) {
            this.checkedString = varienStringArray.add(checkbox.value, this.checkedString);
        } else {
            this.checkedString = varienStringArray.remove(checkbox.value, this.checkedString);
        }
        this.updateCount();
    },
    updateCount: function() {
        this.count.update(varienStringArray.count(this.checkedString));
        if(!this.grid.reloadParams) {
            this.grid.reloadParams = {};
        }
        this.grid.reloadParams[this.formFieldNameInternal] = this.checkedString;
    },
    getSelectedItem: function() {
        if(this.getItem(this.select.value)) {
            return this.getItem(this.select.value);
        } else {
            return false;
        }
    },
    apply: function() {
        if(varienStringArray.count(this.checkedString) == 0) {
                alert(this.errorText);
                return;
            }

        var item = this.getSelectedItem();
        if(!item) {
            this.validator.validate();
            return;
        }
        this.currentItem = item;
        var fieldName = (item.field ? item.field : this.formFieldName);
        var fieldsHtml = '';

        if(this.currentItem.confirm && !window.confirm(this.currentItem.confirm)) {
            return;
        }

        this.formHiddens.update('');
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: fieldName, value: this.checkedString}));
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: 'amount_to_order', value: $$('[name="amount_to_order"]').map(Form.Element.getValue)}));
        new Insertion.Bottom(this.formHiddens, this.fieldTemplate.evaluate({name: 'journal_keys', value: $$('[name="journal_keys"]').map(Form.Element.getValue)}));
 
        if(!this.validator.validate()) {
            return;
        }

        if(this.useAjax && item.url) {
            new Ajax.Request(item.url, {
                'method': 'post',
                'parameters': this.form.serialize(true),
                'onComplete': this.onMassactionComplete.bind(this)
            });
        } else if(item.url) {
            this.form.action = item.url;
            this.form.submit();
        }
    },
    onMassactionComplete: function(transport) {
        if(this.currentItem.complete) {
            try {
                var listener = this.getListener(this.currentItem.complete) || Prototype.emptyFunction;
                listener(grid, this, transport);
            } catch (e) {}
       }
    },
    getListener: function(strValue) {
        return eval(strValue);
    }
};
