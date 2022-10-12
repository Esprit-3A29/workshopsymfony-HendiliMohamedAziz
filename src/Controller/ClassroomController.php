<?php

namespace App\Controller;


use App\Form\ClassroomType;
use App\Entity\Classroom;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;

class ClassroomController extends AbstractController
{
    #[Route('/listClassroom', name: 'list_classroom')]
    public function listclassroom(ClassroomRepository $repository)
    {
        $classroom = $repository->findAll();
        // $students= $this->getDoctrine()->getRepository(StudentRepository::class)->findAll();
        return $this->render("classroom/list.html.twig", array("tabclassroom" => $classroom));
    }
    #[Route('/addForm', name: 'add22')]
    public function addForm(ManagerRegistry $doctrine, Request $request)
    {
        $classroom = new classroom;
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return  $this->redirectToRoute("list_classroom");
        }
        return $this->renderForm("classroom/add.html.twig", array("formclassroom" => $form));
    }

    #[Route('/updateForm/{id}', name: 'update1')]
    public function  updateForm($id, ClassroomRepository $repository, ManagerRegistry $doctrine, Request $request)
    {
        $classroom = $repository->find($id);
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_classroom");
        }
        return $this->renderForm("classroom/update.html.twig", array("formclassroom" => $form));
    }

    #[Route('/removeForm/{id}', name: 'remove1')]

    public function removeStudent(ManagerRegistry $doctrine, $id, ClassroomRepository $repository)
    {
        $student = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return  $this->redirectToRoute("list_classroom");
    }
}
