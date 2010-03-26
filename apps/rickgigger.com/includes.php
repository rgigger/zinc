<?php
include(zoop_dir . '/Zoop.php');
Zoop::loadLib('zone');
Zoop::loadLib('db');
Zoop::loadLib('session');

//	register classess in the application that extend Zoop classes
Zoop::registerClass('AppZone', dirname(__file__) . '/extend/AppZone.php');
Zoop::registerClass('AppGui', dirname(__file__) . '/extend/AppGui.php');

//	register the classes that define your domain logic
Zoop::registerClass('Person', dirname(__file__) . '/domain/Person.php');
Zoop::registerClass('Content', dirname(__file__) . '/domain/Content.php');
Zoop::registerClass('Entry', dirname(__file__) . '/domain/Entry.php');

//	register the zones
// Zoop::registerClass('ZoneTest', dirname(__file__) . '/zones/ZoneTest.php');
Zoop::registerClass('ZoneAdmin', dirname(__file__) . '/zones/ZoneAdmin.php');
Zoop::registerClass('ZoneEntry', dirname(__file__) . '/zones/ZoneEntry.php');
