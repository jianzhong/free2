<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request)
    {
        $user =  new User();
        $userForm = $this->createFormBuilder($user)
            ->add('salutation', ChoiceType::class, [
                'choices' => [
                    'Mr'  => 'Mr',
                    'Mrs' => 'Mrs',
                    'Ms'  => 'Ms',
                    'Miss'=> 'Miss',
                ],
                'label' => 'Title'
            ])
            ->add('firstname', TextType::class, ['label' => 'Firstname'])
            ->add('lastname', TextType::class, ['label' => 'Lastname'])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male'  => 'male',
                    'Female' => 'female',
                ],
                'label' => 'Title'
            ])
            ->add('dob', DateType::class, ['label' => 'Date'])
            ->add('postcode', TextType::class, ['label' => 'Postcode'])
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $userData = $userForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userData);
            $entityManager->flush();

            return $this->redirectToRoute('user-add-success');
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/user-add-success", name="user-add-success")
     */
    public function success()
    {
        return $this->render('user/success.html.twig');
    }

    public function postcodeValidator(Request $request)
    {

    }
}
