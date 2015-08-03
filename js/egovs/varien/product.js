Product.OptionsPrice.prototype.initPrices = function() {
    this.containers[0] = 'product-price-' + this.productId;
    this.containers[1] = 'bundle-price-' + this.productId;
    this.containers[2] = 'price-including-tax-' + this.productId;
    this.containers[3] = 'price-excluding-tax-' + this.productId;
    this.containers[4] = 'old-price-' + this.productId;
    this.containers[5] = 'product-price-' + this.productId + '-1';
};