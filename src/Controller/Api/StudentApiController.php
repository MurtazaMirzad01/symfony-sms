<?php

namespace App\Controller\Api;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\StudentCreateDTO;
use App\Service\StudentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/students')]
final class StudentApiController extends AbstractController
{
    #[Route('', methods: ['POST'])]
   public function create(
       Request $request,
        SerializerInterface $serializer,
        StudentService $service,
       ValidatorInterface $validator
    ) : JsonResponse
    {
        $dto = $serializer->deserialize($request->getContent(), StudentCreateDTO::class, 'json');
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json((string)$errors, 400);
        }
        $student = $service->create($dto);
        return  $this->json([
            'message' => 'Student created',
            'student' => [
                'name' => $student->getName(),
                'email' => $student->getEmail(),
            ],
        ],
            201
        );
    }

    #[Route(
        '',
        methods:['GET']
    )]
    public function index(

        StudentRepository $repo

    ): JsonResponse
    {

        return $this->json(

            $repo
                ->findAll(),

            200,

            [],

            [

                'groups' =>

                    [

                        'student:list'

                    ]

            ]

        );
    }

    #[Route(

        '/{id}',

        methods:['GET']

    )]
    public function show(

        Student $student

    ): JsonResponse
    {

        return $this->json(

            $student,

            200,

            [],

            [

                'groups'=>

                    [

                        'student:detail'

                    ]

            ]

        );
    }
}
