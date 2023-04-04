<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserManagerController extends AbstractController
{
    #[Route('/usermanager', name: 'app_user_manager')]
    public function index(UserRepository $userRepository): Response
    {
        if ($this->getUser())
        {
        if($this->getUser()->getRoles()[0]=="ROLE_USER")
        {
            return $this->redirectToRoute('app_accueil');
        }
        }else
        {
            return $this->redirectToRoute('app_login');
        }
        $Docteurs=$userRepository->findAll();
        return $this->render('user_manager/index.html.twig', [
            'controller_name' => 'UserManagerController',
            'Docteurs'=>$Docteurs
        ]);
    }

    #[Route('/boostuser/{id}', name: 'app_boost')]
    public function boost(UserRepository $userRepository,$id,EntityManagerInterface $manager): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->getRoles()[0] == "ROLE_USER") {
                return $this->redirectToRoute('app_accueil');
            }
        }else
        {
            return $this->redirectToRoute('app_login');
        }
        $user=$userRepository->findbyID($id);
        $user->setRoles((array)"ROLE_ADMIN");
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('app_user_manager');
    }
    #[Route('/demoteuser/{id}', name: 'app_demote')]
    public function demote(UserRepository $userRepository,$id,EntityManagerInterface $manager): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->getRoles()[0] == "ROLE_USER") {
                return $this->redirectToRoute('app_accueil');

            }
            if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_accueil');
            }
        }else
        {
            return $this->redirectToRoute('app_login');
        }
        $user=$userRepository->findbyID($id);
        $user->setRoles((array)"ROLE_USER");
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('app_user_manager');
    }
}
