<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$cmsPages = array(
    array(
        'identifier'    => 'enable-cookies',
        'title'         => 'Cookies aktivieren',
        'root_template' => 'two_columns_left',
        'content'       => '<div class="std">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>Bitte aktivieren Sie die Cookies in Ihrem Web-Browser, um fortzufahren.</li>
            </ul>
        </li>
    </ul>

    <div class="page-title">
        <h1>Was sind Cookies?</h1>
    </div>
    <p>
        Ein Cookie ist eine kleine Datei, die von einer Website, die Sie besuchen,
        auf Ihrem Rechner gespeichert wird.<br />
        Cookies speichern Informationen wie z. B. Ihre bevorzugte Sprache oder andere
        persönliche Seiteneinstellungen. Wenn Sie später diese Website erneut besuchen,
        übermittelt ihr Browser die gespeicherten Cookie-Informationen an die Seite
        zurück. Dadurch können individuelle und an Sie angepasste Informationen angezeigt
        werden.<br />
        Cookies können eine Vielzahl von Informationen beinhalten, die den Besucher
        persönlich identifizierbar machen (wie Ihren Namen, Ihre Adresse, Ihre E-Mail-Adresse
        oder Telefonnummer). Eine Website hat jedoch nur Zugang zu persönlichen Daten,
        die Sie bereitstellen. So kann eine Seite beispielsweise nicht ohne Ihr Zutun
        Ihre E-Mail-Adresse ermitteln. Eine Website kann auch nicht auf andere Dateien
        auf Ihrem Computer zugreifen.
    </p>

    <h2 class="subtitle">Cookies aktivieren</h2>
    <ul class="disc">
        <li><a href="#ie6">Internet Explorer 6.x</a></li>
        <li><a href="#ie7">Internet Explorer 7.x</a></li>
        <li><a href="#firefox">Mozilla/Firefox</a></li>
        <li><a href="#opera">Opera 7.x</a></li>
    </ul>

    <h3>Internet Explorer 6.x</h3>
    <ol>
        <li>
            <p>Select <strong>Internet Options</strong> from the Tools menu</p>
            <p><img alt="" src="{{skin url="images/cookies/ie6-1.gif"}}" /></p>
        </li>
        <li>
            <p>Click on the <strong>Privacy</strong> tab</p>
        </li>
        <li>
            <p>Click the <strong>Default</strong> button (or manually slide the bar down to <strong>Medium</strong>) under <strong>Settings</strong>. Click <strong>OK</strong></p>
            <p><img alt="" src="{{skin url="images/cookies/ie6-2.gif"}}" /></p>
        </li>
    </ol>
    <p class="a-top"><a href="#top">Back to Top</a></p>

    <h3>Internet Explorer 7.x</h3>
    <ol>
        <li><p>Start Internet Explorer</p></li>
        <li>
            <p>Under the <strong>Tools</strong> menu, click <strong>Internet Options</strong></p>
            <p><img alt="" src="{{skin url="images/cookies/ie7-1.gif"}}" /></p>
        </li>
        <li>
            <p>Click the <strong>Privacy</strong> tab</p>
            <p><img alt="" src="{{skin url="images/cookies/ie7-2.gif"}}" /></p>
        </li>
        <li>
            <p>Click the <strong>Advanced</strong> button</p>
            <p><img alt="" src="{{skin url="images/cookies/ie7-3.gif"}}" /></p>
        </li>
        <li>
            <p>
                Put a check mark in the box for <strong>Override Automatic Cookie
                Handling</strong>, put another check mark in the <strong>Always
                accept session cookies </strong>box
            </p>
            <p><img alt="" src="{{skin url="images/cookies/ie7-4.gif"}}" /></p>
        </li>
        <li>
            <p>Click <strong>OK</strong></p>
            <p><img alt="" src="{{skin url="images/cookies/ie7-5.gif"}}" /></p>
        </li>
        <li>
            <p>Click <strong>OK</strong></p>
            <p><img alt="" src="{{skin url="images/cookies/ie7-6.gif"}}" /></p>
        </li>
        <li>
            <p>Restart Internet Explore</p>
        </li>
    </ol>
    <p class="a-top"><a href="#top">Back to Top</a></p>

    <h3>Mozilla/Firefox</h3>
    <ol>
        <li>
            <p>Click on the <strong>Tools</strong>-menu in Mozilla</p>
        </li>
        <li>
            <p>Click on the <strong>Options...</strong> item in the menu - a new window open</p>
        </li>
        <li>
            <p>Click on the <strong>Privacy</strong> selection in the left part of the window. (See image below)</p>
            <p><img alt="" src="{{skin url="images/cookies/firefox.png"}}" /></p>
        </li>
        <li>
            <p>Expand the <strong>Cookies</strong> section</p>
        </li>
        <li>
            <p>Check the <strong>Enable cookies</strong> and <strong>Accept cookies normally</strong> checkboxes</p>
        </li>
        <li>
            <p>Save changes by clicking <strong>Ok</strong>.</p>
        </li>
    </ol>
    <p class="a-top"><a href="#top">Back to Top</a></p>

    <h3>Opera 7.x</h3>
    <ol>
        <li>
            <p>Click on the <strong>Tools</strong> menu in Opera</p>
        </li>
        <li>
            <p>Click on the <strong>Preferences...</strong> item in the menu - a new window open</p>
        </li>
        <li>
            <p>Click on the <strong>Privacy</strong> selection near the bottom left of the window. (See image below)</p>
            <p><img alt="" src="{{skin url="images/cookies/opera.png"}}" /></p>
        </li>
        <li>
            <p>The <strong>Enable cookies</strong> checkbox must be checked, and <strong>Accept all cookies</strong> should be selected in the "<strong>Normal cookies</strong>" drop-down</p>
        </li>
        <li>
            <p>Save changes by clicking <strong>Ok</strong></p>
        </li>
    </ol>
    <p class="a-top"><a href="#top">Back to Top</a></p>
</div>'
    ),
    array(
				'root_template' => 'three_columns',
				'identifier'    => 'no-route',
				'title'         => 'Seite nicht gefunden',
				'content'       => '<div class="page-title">
    <h1>Whoops, etwas ging schief...</h1>
</div>
<dl>
    <dt>Die von Ihnen angeforderte Seite wurde nicht gefunden, und wir haben eine Vermutung, warum.</dt>
    <dd>
        <ul class="disc">
            <li>Wenn Sie die URL direkt eingegeben haben, stellen Sie bitte sicher, dass die Schreibweise korrekt ist.</li>
            <li>Wenn Sie auf einen Link geklickt, um hierher zu kommen, ist der Link veraltet.</li>
        </ul>
    </dd>
</dl>
<dl>
    <dt>Was kann man tun?</dt>
    <dd>
        Haben Sie keine Angst, Hilfe ist in der N&auml;he! Es gibt viele M&ouml;glichkeiten,
        wie Sie wieder in unseren Shop kommen.
    </dd>
    <dd>
        <ul class="disc">
            <li>Gehen Sie <a onclick="history.go(-1); return false;" href="#">zur&uuml;ck</a> auf die vorherige Seite.</li>
            <li>Benutzen Sie das Suchleiste am oberen Rand der Seite, um Ihr Produkt zu suchen.</li>
            <li>Benutzen Sie diese Links um in den Shop zur&uuml;ck zu kommen!<br /> <a href="{{store url=""}}">Startseite</a> <span class="separator">|</span> <a href="{{store url="customer/account"}}">Mein Benutzerkonto</a></li>
        </ul>
    </dd>
</dl>'
    ),
    array(
        'root_template' => 'two_columns_left',
				'identifier'    => 'privacy-policy-cookie-restriction-mode',
				'title'         => 'Cookies',
				'content'       => '<p>
    Eine vollständige Übersicht aller Cookies, haben wir hier zusammengestellt.
</p>

<h2>Liste der Cookies, welche wir verwenden</h2>
<p>Die folgende Tabelle zeigt alle Cookies, die wir verwenden und welche Informationen sie enthalten.</p>
<table class="data-table">
    <thead>
        <tr>
            <th>COOKIE Name</th>
            <th>COOKIE Beschreibung</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>CART</th>
            <td>Der Inhalt des Warenkorb.</td>
        </tr>
        <tr>
            <th>CATEGORY_INFO</th>
            <td>Kategorie-Informationen, damit die Seiten schneller angezeigt werden.</td>
        </tr>
        <tr>
            <th>COMPARE</th>
            <td>Alle Einträge, welche der Vergleichsliste hinzugefügt wurden.</td>
        </tr>
        <tr>
            <th>CURRENCY</th>
            <td>Die bevorzugte Währung.</td>
        </tr>
        <tr>
            <th>CUSTOMER</th>
            <td>Eine verschlüsselte Version Ihrer Kundennummer im Store.</td>
        </tr>
        <tr>
            <th>CUSTOMER_AUTH</th>
            <td>Speichert, ob Sie im Shop angemeldet sind.</td>
        </tr>
        <tr>
            <th>CUSTOMER_INFO</th>
            <td>Eine verschlüsselte Version der Kundengruppe welcher Sie zugeordnet sind.</td>
        </tr>
        <tr>
            <th>CUSTOMER_SEGMENT_IDS</th>
            <td>Speichert die Kundensegment ID.</td>
        </tr>
        <tr>
            <th>EXTERNAL_NO_CACHE</th>
            <td>Ein Flag, das anzeigt, ob das Caching deaktiviert ist oder nicht.</td>
        </tr>
        <tr>
            <th>FRONTEND</th>
            <td>Die Session-ID auf dem Server.</td>
        </tr>
        <tr>
            <th>GUEST-VIEW</th>
            <td>Bestellungen für Gäste können bearbeitet werden.</td>
        </tr>
        <tr>
            <th>LAST_CATEGORY</th>
            <td>Die letzte Kategorie, welche angezeigt wurde.</td>
        </tr>
        <tr>
            <th>LAST_PRODUCT</th>
            <td>Das latzte Produkt, das Sie gesehen haben.</td>
        </tr>
        <tr>
            <th>NEWMESSAGE</th>
            <td>Gibt an, ob eine neue Nachricht eingegangen ist.</td>
        </tr>
        <tr>
            <th>NO_CACHE</th>
            <td>Gibt an, ob der Cache verwendet werden kann.</td>
        </tr>
        <tr>
            <th>PERSISTENT_SHOPPING_CART</th>
            <td>Ein Link zu den Informationen über Ihren Warenkorb und der Seiten welche Sie im Shop gesehen haben.</td>
        </tr>
        <tr>
            <th>POLL</th>
            <td>Die ID der letzten Umfrage, bei welcher Sie vor kurzem abgestimmt haben.</td>
        </tr>
        <tr>
            <th>POLLN</th>
            <td>Informationen darüber, was Sie abgestimmt haben.</td>
        </tr>
        <tr>
            <th>RECENTLYCOMPARED</th>
            <td>Die Produkte, welche Sie in letzter Zeit verglichen haben.</td>
        </tr>
        <tr>
            <th>STF</th>
            <td>Informationen zu Produkten, welche Sie an Freunde per E-Mail gesendet haben.</td>
        </tr>
        <tr>
            <th>STORE</th>
            <td>Die Store-View oder Sprache, die Sie ausgewählt haben.</td>
        </tr>
        <tr>
            <th>USER_ALLOWED_SAVE_COOKIE</th>
            <td>Gibt an, ob ein Kunde das verwenden von Cookies erlaubt hat.</td>
        </tr>
        <tr>
            <th>VIEWED_PRODUCT_IDS</th>
            <td>Die Produkte, die Sie zuletzt angesehen haben.</td>
        </tr>
        <tr>
            <th>WISHLIST</th>
            <td>Eine verschlüsselte Liste der Produkte, welche Sie Ihre Wunschliste hinzugefügt haben.</td>
        </tr>
        <tr>
            <th>WISHLIST_CNT</th>
            <td>Die Anzahl der Artikel auf Ihrer Wunschliste.</td>
        </tr>
    </tbody>
</table>'
    ),
    array(
        'identifier' => 'about-magento-demo-store',
        'active'     => 0
    ),
    array(
        'identifier' => 'contacts',
        'title'      => 'Kontaktieren Sie uns'
    ),
    array(
        'identifier' => 'customer-service',
        'active'     => 0
    )
);

$cmsBlocks = array(
    array(
        'identifier' => 'footer_links',
        'content'    => '<div class="links">
    <div class="block-title">
        <strong><span>Über uns</span></strong>
    </div>
    <ul>
        <li><a href="{{store url=""}}contacts/">Kontaktieren Sie uns</a></li>
        <li><a href="{{store url=""}}datenschutz/">Datenschutz</a></li>
        <li><a href="{{store url=""}}privacy-policy-cookie-restriction-mode/">Cookies</a></li>
        <li><a href="{{store url=""}}enable-cookies/">Cookies aktivieren</a></li>
    </ul>
</div>'
    )
);

$installer = $this;
$installer->startSetup();

foreach ($cmsPages as $data) {
    $page = Mage::getModel('cms/page')->load($data['identifier']);
    if ( $page->isEmpty() ) {
        continue;
    }
    else {
        if ( isset($data['root_template']) ) {
            $page->setRootTemplate($data['root_template'])->save();
        }

        if ( isset($data['title']) ) {
            $page->setTitle($data['title'])->save();
        }

        if ( isset($data['content']) ) {
            $page->setContent($data['content'])->save();
        }

        if ( isset($data['active']) ) {
            $page->setIsActive($data['active'])->save();
        }
    }
}

foreach($cmsBlocks as $data) {
    $block = Mage::getModel('cms/block')->load($data['identifier']);
    if ( $block->isEmpty() ) {
        continue;
    }
    else {
        if ( isset($data['content']) ) {
            $block->setContent($data['content'])->save();
        }
    }
}

$installer->endSetup();
