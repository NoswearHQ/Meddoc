<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UpdateUserController extends AbstractController
{
    #[Route('/update/user', name: 'app_update_user')]
    public function index(EntityManagerInterface $manager,SluggerInterface $slugger,Request $request,UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user=$userRepository->findbyEmail($this->getUser()->getUserIdentifier());
        $img=$user->getAvatar();
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $user=$form->getData();
            $photo = $form->get('avatar')->getData();
            if ($photo!=null)
            {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('personne_Imgs'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setAvatar($newFilename);
            }
            else
            {
                $user->setAvatar($img);
            }
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('update_user/index.html.twig', [
            'controller_name' => 'UpdateUserController',
            'UserForm' =>$form->createView(),
        ]);
    }
}
