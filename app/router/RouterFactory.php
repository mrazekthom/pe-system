<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$administration = new RouteList('Administration');
		$administration[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		$base = new RouteList('');
		$base[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router = new RouteList();

		$router[] = $administration;
		$router[] = $base;

		return $router;
	}

}
