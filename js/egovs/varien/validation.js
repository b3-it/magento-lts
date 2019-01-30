// add html5-validate to varien Form Validation

Validation.add('html5-validate', ' ', function(v, elm) {
  if (!elm.checkValidity()) {
    elm.reportValidity();
    return false;
  }
  return true;
});