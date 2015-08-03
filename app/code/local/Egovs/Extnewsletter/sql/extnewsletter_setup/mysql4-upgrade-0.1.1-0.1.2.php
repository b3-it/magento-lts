<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('extnewsletter_issue')};
CREATE TABLE {$this->getTable('extnewsletter_issue')} (
  `extnewsletter_issue_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `remarks` varchar(512) NOT NULL default '',
  `store_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY (`extnewsletter_issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


$installer->run("

DROP TABLE IF EXISTS {$this->getTable('extnewsletter_issues_subscriber')};
CREATE TABLE {$this->getTable('extnewsletter_issues_subscriber')} (
  `extnewsletter_issuesubscriber_id` int(11) unsigned NOT NULL auto_increment,
  `subscriber_id` int(11) unsigned NOT NULL,
  `issue_id` int(11) unsigned NOT NULL,
  `is_active` smallint(6) NOT NULL default '0',
  FOREIGN KEY (`issue_id`) REFERENCES `{$this->getTable('extnewsletter_issue')}`(`extnewsletter_issue_id`) ON DELETE CASCADE,
  PRIMARY KEY (`extnewsletter_issuesubscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->run("
DROP TABLE IF EXISTS {$this->getTable('extnewsletter_queue_issue')};
CREATE TABLE {$this->getTable('extnewsletter_queue_issue')} (
  `extnewsletter_queue_issue_id` int(11) unsigned NOT NULL auto_increment,
  `issue_id` int(11) unsigned NOT NULL,
  `queue_id` int(11) unsigned NOT NULL,
   FOREIGN KEY (`issue_id`) REFERENCES `{$this->getTable('extnewsletter_issue')}`(`extnewsletter_issue_id`) ON DELETE CASCADE,
   FOREIGN KEY (`queue_id`) REFERENCES `{$this->getTable('newsletter_queue')}`(`queue_id`) ON DELETE CASCADE,
  PRIMARY KEY (`extnewsletter_queue_issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");




$installer->endSetup(); 