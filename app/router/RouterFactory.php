<?php

namespace App\Router;

use App\Model\Entity\Day;
use App\Model\Entity\Grade;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\GradeQuery;
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
                    $query = new GradeQuery();
                    $query->setGrade($grade);
                    $results = $this->entityManager->getRepository(Grade::class)->fetch($query);
                    foreach ($results as $result)
                        return $result;
                }
            )
        ));

        $administration[] = new Route('detailni-ucast/<grade><typeClass>', array(
            'presenter' => 'Attendance',
            'action' => 'detailAll',
            'grade' => array(
                Route::FILTER_OUT => function (Grade $grade) {
                    return $grade->getGrade();
                },
                Route::FILTER_IN => function ($grade) {
                    $query = new GradeQuery();
                    $query->setGrade($grade);
                    $results = $this->entityManager->getRepository(Grade::class)->fetch($query);
                    foreach ($results as $result)
                        return $result;
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

        $administration[] = new Route('ucast/<grade><typeClass>', array(
            'presenter' => 'Attendance',
            'action' => 'default',
            'grade' => array(
                Route::FILTER_OUT => function (Grade $grade) {
                    return $grade->getGrade();
                },
                Route::FILTER_IN => function ($grade) {
                    $query = new GradeQuery();
                    $query->setGrade($grade);
                    $results = $this->entityManager->getRepository(Grade::class)->fetch($query);
                    foreach ($results as $result)
                        return $result;
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

        $administration[] = new Route('ucast-editace/<grade><typeClass>/<day>', array(
            'presenter' => 'Attendance',
            'action' => 'edit',
            'grade' => array(
                Route::FILTER_OUT => function (Grade $grade) {
                    return $grade->getGrade();
                },
                Route::FILTER_IN => function ($grade) {
                    $query = new GradeQuery();
                    $query->setGrade($grade);
                    $results = $this->entityManager->getRepository(Grade::class)->fetch($query);
                    foreach ($results as $result)
                        return $result;
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
            'day' => array(
                Route::FILTER_OUT => function (Day $day) {
                    return $day->getDay()->format('Y-m-d');
                },
                Route::FILTER_IN => function ($day) {
                    $days = new Nette\Utils\DateTime($day);
                    return $this->entityManager->getRepository(Day::class)->findOneBy(array('day' => $days));
                }
            ),
        ));

        $administration[] = new Route('trida/<grade><typeClass>', array(
            'presenter' => 'ShowList',
            'action' => 'class',
            'grade' => array(
                Route::FILTER_OUT => function (Grade $grade) {
                    return $grade->getGrade();
                },
                Route::FILTER_IN => function ($grade) {
                    $query = new GradeQuery();
                    $query->setGrade($grade);
                    $results = $this->entityManager->getRepository(Grade::class)->fetch($query);
                    foreach ($results as $result)
                        return $result;
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

        $administration[] = new Route('<presenter>/<action>[/<id>]', array(
            'model' => 'Administration',
            'presenter' => 'Homepage',
            'action' => 'default'
        ));


        $admin = new RouteList('Admin');

        $admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');


        $base = new RouteList('');
        $base[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        $router = new RouteList();

        $router[] = $admin;
        $router[] = $administration;
        $router[] = $base;

        return $router;
    }

}
