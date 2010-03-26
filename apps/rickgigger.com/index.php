<?php
include('config.php');
include('includes.php');

Session::start();

ZoneApplication::handleRequest();