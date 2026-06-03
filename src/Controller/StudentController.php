<?php

namespace App\Controller;

use App\DTO\StudentCreateDTO;
use App\Entity\Student;
use App\Form\StudentType;
use App\Form\StudentSearchType;
use App\Repository\StudentRepository;
use App\Security\Voter\StudentVoter;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Student\StudentSummaryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    '/{_locale}',
    requirements: ['_locale' => 'en|fa']
)]
#[IsGranted('ROLE_USER')]
final class StudentController extends AbstractController
{
    public function apiCreate(
        Request $request,
        SerializerInterface $serializer,
    )
    {
        $dto = $serializer
            ->deserialize(
                $request->getContent(),
                StudentCreateDTO::class,
                'json'
            );
    }

    #[Route(
        '/students',
        name: 'student_index'
    )]

    #[Route(
        '/',
        name: 'app_student_index',
        methods: ['GET']
    )]
    public function index(
        Request $request,
        StudentRepository $repository,
        PaginatorInterface $paginator
    ): Response {

        $form = $this->createForm(
            StudentSearchType::class
        );

        $form->handleRequest($request);

        $query =
            $form->get('query')
                ->getData();

        $students =
            $paginator
                ->paginate(
                    $repository
                        ->searchQuery(
                            $query
                        ),

                    $request
                        ->query
                        ->getInt(
                            'page',
                            1
                        ),

                    10
                );

        return $this->render(
            'student/index.html.twig',
            [
                'students' => $students,
                'searchForm' => $form->createView(),

            ]
        );
    }

    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $student = new Student();
        $this->denyAccessUnlessGranted(
            StudentVoter::ADD,
            $student
        );
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('app_student_index', ['_locale' => $request->getLocale()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_show', methods: ['GET'])]
    public function show(
        Student $student,
        StudentSummaryService $service,
    ): Response
    {
        return $this->render(
            'student/show.html.twig',
            [
                'student' =>
                        $service
                            ->create($student)
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted(
            StudentVoter::EDIT,
            $student
        );
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('warning', 'Warning');


            return $this->redirectToRoute('app_student_index', ['_locale' => $request->getLocale()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(Request $request,
       Student $student,
       EntityManagerInterface $entityManager,
    ): Response
    {
        $this->denyAccessUnlessGranted(
            StudentVoter::DELETE,
            $student
        );
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($student);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_student_index', ['_locale' => $request->getLocale()], Response::HTTP_SEE_OTHER);
    }
}
