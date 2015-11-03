<?php

namespace App\Model\Service;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use App\Model\Entity\Student;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\ClassQuery;
use Kdyby\Doctrine\EntityManager;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;

class StudentImportService
{


    /** @var  EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function decodeStudents($students)
    {
        $schoolClass = NULL;
        $class = NULL;
        foreach ($students as $student) {
            $pupil = Strings::split($student, '/ /');
            if ($pupil[0] == $schoolClass) {
                $class[] = ArrayHash::from([
                    'name' => $pupil[1],
                    'surname' => $pupil[2]
                ]);
            } elseif (isset($schoolClass)) {
                $this->writeToDB($schoolClass, $class);
                $class = NULL;
                $schoolClass = NULL;
            } else {
                $schoolClass = $pupil[0];
                $class[] = ArrayHash::from([
                    'name' => $pupil[1],
                    'surname' => $pupil[2]
                ]);
            }
        }
        $this->writeToDB($schoolClass, $class);
    }

    private function writeToDB($schoolClass, $students)
    {
        $class = $this->getClass($schoolClass);
        $this->writeStudentToDB($class, $students);
    }


    private function getClass($schoolClass)
    {
        $schoolClassGrade = Strings::split($schoolClass, '/[A-Z]/')[0];
        $schoolClassTypeClass = Strings::split($schoolClass, '/[0-9]/')[1];

        $query = new ClassQuery();
        $query->setClass($schoolClassGrade, $schoolClassTypeClass);
        $IssetSchoolClass = $this->entityManager->getRepository(SchoolClass::class)->fetch($query)->count();
        if ($IssetSchoolClass) {
            return $this->entityManager->getRepository(SchoolClass::class)->findOneBy([
                'grade.grade' => $schoolClassGrade,
                'typeClass.class' => $schoolClassTypeClass
            ]);
        } else {
            $typeClass = $this->getTypeClass($schoolClassTypeClass);
            $grade = $this->getGrade($schoolClassGrade);

            $newEntitySchoolClass = new SchoolClass();
            $newEntitySchoolClass->setGrade($grade);
            $newEntitySchoolClass->setTypeClass($typeClass);
            $this->entityManager->persist($newEntitySchoolClass);
            $this->entityManager->flush();

            return $this->entityManager->getRepository(SchoolClass::class)->findOneBy([
                'grade' => $grade,
                'typeClass' => $typeClass
            ]);
        }
    }

    private function getTypeClass($typeClass)
    {
        $typeClassEntity = $this->entityManager->getRepository(TypeClass::class)->findOneBy([
            'class' => $typeClass
        ]);
        if (!$typeClassEntity) {
            $newEntityTypeClass = new TypeClass();
            $newEntityTypeClass->setClass($typeClass);
            $this->entityManager->persist($newEntityTypeClass);
            $this->entityManager->flush();
            $typeClassEntity = $this->entityManager->getRepository(TypeClass::class)->findOneBy([
                'class' => $typeClass
            ]);
        }
        return $typeClassEntity;
    }

    private function getGrade($grade)
    {
        $gradeEntity = $this->entityManager->getRepository(Grade::class)->findOneBy([
            'grade' => $grade
        ]);
        if (!$grade) {
            $newEntityGrade = new Grade();
            $newEntityGrade->setGrade($grade);
            $newEntityGrade->setSchoolYear($this->entityManager->getRepository(SchoolYear::class)->findOneBy([
                'actual' => 1
            ]));
            $this->entityManager->persist($newEntityGrade);
            $this->entityManager->flush();
            $gradeEntity = $this->entityManager->getRepository(Grade::class)->findOneBy([
                'grade' => $grade
            ]);
        }
        return $gradeEntity;
    }

    private function writeStudentToDB($schoolClass, $students)
    {
        foreach ($students as $student) {
            $entityStudent = $this->entityManager->getRepository(Student::class)->findOneBy([
                'class' => $schoolClass,
                'name' => $student->name,
                'surname' => $student->surname
            ]);
            if (!$entityStudent) {
                $newEntityStudent = new Student();
                $newEntityStudent->setClass($schoolClass);
                $newEntityStudent->setName($student->name);
                $newEntityStudent->setSurname($student->surname);
                $this->entityManager->persist($newEntityStudent);
            }
        }
        $this->entityManager->flush();
    }

}