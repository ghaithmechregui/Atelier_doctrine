<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    /**
     * @Route("/listStudent", name="listStudent")
     */
    public function listStudent()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('student/list.html.twig', array("students" => $students));
    }
    /**
     * @Route("/addStudent", name="addStudent")
     */
    public function addStudent(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->add("Ajouter",SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('listStudent');
        }
        return $this->render("student/add.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/delete/{nsc}", name="deleteStudent")
     */
    public function deleteStudent($nsc)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($nsc);
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("listStudent");
    }

    /**
     * @Route("/show/{nsc}", name="showStudent")
     */
    public function showStudent($nsc)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($nsc);
        return $this->render('student/show.html.twig', array("student" => $student));
    }

    /**
     * @Route("/update/{nsc}", name="updateStudent")
     */
    public function updateStudent(Request $request, $nsc)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($nsc);
        $form = $this->createForm(StudentType::class, $student);
        $form->add("Modifier",SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listStudent');
        }
        return $this->render("student/update.html.twig", array('form' => $form->createView()));
    }

}
