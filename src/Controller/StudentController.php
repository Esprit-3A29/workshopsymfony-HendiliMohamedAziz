<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/listStudent', name: 'list_student')]
    public function listStudent(StudentRepository $repository)
    {
        $students= $repository->findAll();
       // $students= $this->getDoctrine()->getRepository(StudentRepository::class)->findAll();
       return $this->render("student/list.html.twig",array("tabStudent"=>$students));
    }


    #[Route('/addStudent', name: 'add_student')]
    public function addStudent(ManagerRegistry $doctrine)
    {
        $student= new Student();
        $student->setRef("258");
        $student->setUsername("rahma");
        $student->setMoyenne(18);
       // $em=$this->getDoctrine()->getManager();
        $em= $doctrine->getManager();
        $em->persist($student);
        $em->flush();
        return $this->redirectToRoute("list_student");
    }

    #[Route('/addForm', name: 'add2')]
    public function addForm(ManagerRegistry $doctrine,Request $request)
    {
        $student= new Student;
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
             $em= $doctrine->getManager();
             $em->persist($student);
             $em->flush();
             return  $this->redirectToRoute("list_student");
         }
        return $this->renderForm("student/add.html.twig",array("formStudent"=>$form));
    }

    #[Route('/updateForm/{ref}', name: 'update2')]
    public function  updateForm($ref,StudentRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $student= $repository->find($ref);
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_student");
        }
        return $this->renderForm("student/update.html.twig",array("formStudent"=>$form));
    }

    #[Route('/removeForm/{ref}', name: 'remove')]

    public function removeStudent(ManagerRegistry $doctrine,$ref,StudentRepository $repository)
    {
        $student= $repository->find($ref);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return  $this->redirectToRoute("list_student");
    }

    #[Route('/addStudent2', name: 'addStudent2')]
    public function addStudent2(StudentRepository $repository, Request $request)
    {
        $student= new Student;
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $repository->add($student,true);   
        }
        return $this->renderForm("student/add2.html.twig",array("Studentform"=>$form));
    }
}
