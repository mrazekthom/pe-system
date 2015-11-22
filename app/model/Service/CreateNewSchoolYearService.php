<?php

namespace App\Model\Service;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use App\Model\Entity\Student;
use App\Model\EntityService\ClassesQuery;
use App\Model\EntityService\GradeQuery;
use Kdyby\Doctrine\EntityManager;

class CreateNewSchoolYearService
{

    /** @var  EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createNewYear($startYear, $migrate)
    {
        $newSchoolYear = $this->createYear($startYear);
        $this->createGrade($newSchoolYear);
        $this->changeActualYear($newSchoolYear);
    }

    private function createYear($startYear)
    {
        $schoolYearStart = date('Y-m-d G:i:s', mktime(0, 0, 0, 9, 1, $startYear));
        $schoolYearEnd = date('Y-m-d G:i:s', mktime(0, 0, 0, 6, 30, $startYear + 1));
        $newEntitySchoolYear = new SchoolYear();
        $newEntitySchoolYear->setStart(new \Dibi\DateTime($schoolYearStart));
        $newEntitySchoolYear->setEnd(new \Dibi\DateTime($schoolYearEnd));
        $newEntitySchoolYear->setActual(1);
        $this->entityManager->persist($newEntitySchoolYear);
        $this->entityManager->flush();

        return $newEntitySchoolYear;
    }

    private function createGrade(SchoolYear $schoolYear)
    {
        $query = new GradeQuery();
        $query->setModeMigrationStudent();
        $oldGrades = $this->entityManager->getRepository(SchoolYear::class)->fetch($query);
        foreach ($oldGrades as $oldGrade) {
            $newEntityGrade = new Grade();
            $newEntityGrade->setSchoolYear($schoolYear);
            $newEntityGrade->setGrade($oldGrade->grade + 1);
            $this->entityManager->persist($newEntityGrade);
            $this->entityManager->flush();
            $this->createClass($newEntityGrade, $oldGrade);
        }
    }

    private function createClass(Grade $newGrade, Grade $oldGrade)
    {
        $query = new ClassesQuery();
        $query->setGrade($oldGrade);
        $oldClasses = $this->entityManager->getRepository(SchoolClass::class)->fetch($query);
        foreach ($oldClasses as $oldClass) {
            $newEntityClass = new SchoolClass();
            $newEntityClass->setGrade($newGrade);
            $newEntityClass->setTypeClass($oldClass->typeClass);
            $this->entityManager->persist($newEntityClass);
            $this->entityManager->flush();
            $this->studentMigrate($newEntityClass, $oldClass);
        }
    }

    private function studentMigrate(SchoolClass $newSchoolClass, SchoolClass $oldSchoolClass)
    {
        $students = $this->entityManager->getRepository(Student::class)->findBy([
            'class' => $oldSchoolClass
        ]);
        foreach ($students as $student) {
            $newEntityStudent = new Student();
            $newEntityStudent->setClass($newSchoolClass);
            $newEntityStudent->setName($student->name);
            $newEntityStudent->setSurname($student->surname);
            $this->entityManager->persist($newEntityStudent);
        }
        $this->entityManager->flush();
    }

    private function changeActualYear(SchoolYear $schoolYear)
    {
        $oldYear = $this->entityManager->getRepository(SchoolYear::class)->findOneBy([
            'actual' => 1
        ]);
        $oldYear->actual = 0;
        $schoolYear->setActual(1);
        $this->entityManager->flush();
    }

}