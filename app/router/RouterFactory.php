<?php

namespace App\Router;

use App\Model\Entity\Grade;
use App\Model\Entity\TypeClass;
use Doctrine\ORM\EntityManager;
use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


/**
 * Router factory.
 */
class RouterFactory
{

    /** @var EntityManager */
    private $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Nette\Application\IRouter
     */
    public function createRouter()
    {
        $administration = new RouteList('Administration');

        $administration[] = new Route('spseol', array(
            'presenter' => 'ShowList',
            'action' => 'school'
        ));

        $administration[] = new Route('rocnik/<grade>', array(
            'presenter' => 'ShowList',
            'action' => 'grade',
            'grade' => array(
                Route::FILTER_OUT => function (Grade $grade) {
                    return $grade->getGrade();
                },
                Route::FILTER_IN => function ($grade) {
                    return $this->entityManager->getRepository(Grade::class)->findOneBy(array('grade' => $grade));
                }
            )
        ));

        $administration[] = new Route('trida/<grade><typeClass>', array(
            'presenter' => 'ShowList',
            'action' => 'class',
            'grade' => array(
                Route::FILTER_OUT => function (Grade $grade) {
                    return $grade->getGrade();
                },
                Route::FILTER_IN => function ($grade) {
                    return $this->entityManager->getRepository(Grade::class)->findOneBy(array('grade' => $grade));
                }
            ),
            'typeClass' => array(
                Route::FILTER_OUT => function (TypeClass $class) {
                    return $class->getClass();
                },
                Route::FILTER_IN => function ($class) {
                    return $this->entityManager->getRepository(TypeClass::class)->findOneBy(array('class' => $class));
                }
            ),
        ));

        $administration[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        $admin = new RouteList('Admin');

        $admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');


        $base = new RouteList('');
        $base[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        $router = new RouteList();

        $router[] = $administration;
        $router[] = $admin;
        $router[] = $base;

        return $router;
    }

}
