<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Student;
use App\Form\AttendanceType;
use App\Repository\AttendanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/allAttendance", name="attendance_all", methods={"GET"})
     */
    public function allAttendance(AttendanceRepository $attendanceRepository): Response
    {
        $class = $this -> getDoctrine() -> getRepository(Student::class)->findAll();

        return $this->render('attendance/index.html.twig', [
            'attendances' => $attendanceRepository->findAll(),
        ]);

    }

    /**
     * @Route("/new", name="attendance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attendance = new Attendance();
        $form = $this->createForm(AttendanceType::class, $attendance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attendance);
            $entityManager->flush();

            return $this->redirectToRoute('attendance_all');
        }

        return $this->render('attendance/new.html.twig', [
            'attendance' => $attendance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attendance_show", methods={"GET"})
     */
    public function show(Attendance $attendance): Response
    {
        $student = $this -> getDoctrine() -> getRepository(Student::class)->findAll();
        return $this->render('attendance/show.html.twig', [
            'attendance' => $attendance,
            'id' => $student,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attendance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Attendance $attendance): Response
    {
        $form = $this->createForm(AttendanceType::class, $attendance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attendance_all');
        }

        return $this->render('attendance/edit.html.twig', [
            'attendance' => $attendance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attendance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Attendance $attendance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attendance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attendance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attendance_all');
    }
}
