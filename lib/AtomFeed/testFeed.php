<?php
require_once 'bootstrap.php';

$feed = new AtomFeed_Api_V1_Feed();
//$feed->setId("feedId");
$feed->setTitle("Feed Title");
$feed->setUpdated(new DateTime());

$feed->addNamespace('e', 'example.com/mynamespace');

$entry = new AtomFeed_Api_V1_Entry();
//$entry->setId("entryId");
$entry->setTitle("Entry Title");
$entry->setUpdated(new DateTime());
$entry->setContent("A & B");

$entry->addChild('e:periode', "periode-Wert");
$entry->addChild('e:pdffile', "PDFFile");

$feed->addEntry($entry);

$entry2 = new AtomFeed_Api_V1_Entry();

//$entry2->addNamespace('e', 'example.com/mynamespace');
//$entry2->setId("entryId2");
$entry2->setTitle("Entry Title2");
$entry2->setUpdated(new DateTime());
$entry2->setContent(new AtomFeed_Api_V1_Content("<ul><li>1</li><li>2</li></ul>", "xhtml"));

$entry2->addChild('e:periode', "periode-Wert2");
$entry2->addChild('e:pdffile', "PDFFile2");

$feed->addEntry($entry2);

echo($feed->toXML());