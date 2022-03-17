<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method' => 'indexAction'), array()));
$routes->add('stats', new Route(constant('URL_SUBFOLDER') . '/stats', array('controller' => 'StatisticController', 'method' => 'prepareStatsAction'), array()));
