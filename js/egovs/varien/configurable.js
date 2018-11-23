Product.ConfigEgovsReady = Class.create(Product.Config, {
    getOptionLabel: function(option, price){
        var addTaxConfig = this.config.addTaxConfig;
        var price = parseFloat(price);
        if (this.taxConfig.includeTax) {
            var tax = price / (100 + this.taxConfig.defaultTax) * this.taxConfig.defaultTax;
            var excl = price - tax;
            var incl = excl*(1+(this.taxConfig.currentTax/100));
        } else {
            var tax = price * (this.taxConfig.currentTax / 100);
            var excl = price;
            var incl = excl + tax;
        }

        if (this.taxConfig.showIncludeTax || this.taxConfig.showBothPrices) {
            price = incl;
        } else {
            price = excl;
        }

        var str = option.label;
        if(price){
            if (this.taxConfig.showBothPrices) {
                str+= ' ' + this.formatPrice(excl, true) + ' (' + this.formatPrice(price, true) + ' ' + this.taxConfig.inclTaxTitle + ')';
            } else if (this.taxConfig.currentTax > 0) {
                if (this.taxConfig.showIncludeTax) {
                    str += ' ' + this.formatPrice(price, true) + ' (' + this.taxConfig.inclTaxTitle + ')';
                } else {
                    str += ' ' + this.formatPrice(price, true) + ' (' + addTaxConfig.exclTaxTitle + ')';
                }
            } else {
                str += ' ' + this.formatPrice(price, true) + ' (' + addTaxConfig.taxFreeTitle + ')';
            }
        }
        return str;
    }
});