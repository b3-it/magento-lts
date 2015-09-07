03.09.15
Zur VAT Validierung wird nun die Magento eigene Funktion genutzt

//if (Mage::helper('payfilter')->moduleActive())
20.07.12:
Unter Konfiguration -> Kundenkonfiguration -> Namen und Adressoptionen muss die Anzeige der Steuernummer auf Optional gestellt werden

29.03.12:
Bei deutschen USt-IDs wird keine Adresse zurückgelifert!

Die Validierung der VAT bei der Eingabe schließt die Validerierung von VAT zu Land mit ein!
VAT Validierung findet schon bei der Eingabe statt, somit muss dies bei der autmatischen Kundengruppenzuordnung nicht mehr gemacht werden.