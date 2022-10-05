<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/students', name: 'app_student')]
    public function ListEtudiant(StudentRepository $repository)
    {
        $students= $repository->findAll();
        return $this->render("etudiant/listEtudiant.html.twig",array("tabStudent"=>$students));
    }
}
