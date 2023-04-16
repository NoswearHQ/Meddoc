<?php

namespace App\Controller;

use App\Entity\data;
use App\Repository\BlogRepository;
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
    #[Route('/boostusertoblog/{id}', name: 'app_boostusertoblog')]
    public function Boostusertoblog(UserRepository $userRepository,$id,EntityManagerInterface $manager): Response
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
        $user->setHasblog("1");
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('app_user_manager');
    }
    #[Route('/demoteusertoblog/{id}', name: 'app_demoteusertoblog')]
    public function Demoteusertoblog(UserRepository $userRepository,$id,EntityManagerInterface $manager): Response
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
        $user->setHasblog("0");
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
    #[Route('/approuvepost/{id}', name: 'app_approuvepost')]
    public function approuvepost(UserRepository $userRepository,$id,EntityManagerInterface $manager,BlogRepository $blogRepository): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                $post=$blogRepository->findByIDobject($id);
                $post->setStatus("Accepted");
                $manager->persist($post);
                $manager->flush();
            }else
            {
                return $this->redirectToRoute('app_login');
            }
        }else
        {
            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('app_pendingpost');
    }
    #[Route('/cancelpost/{id}', name: 'app_cancelpost')]
    public function cancelpost(UserRepository $userRepository,$id,EntityManagerInterface $manager,BlogRepository $blogRepository): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                $post=$blogRepository->findByIDobject($id);
                $post->setStatus("Rejected");
                $manager->persist($post);
                $manager->flush();
            }else
            {
                return $this->redirectToRoute('app_login');
            }
        }else
        {
            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('app_pendingpost');
    }

    #[Route('/pendingpost', name: 'app_pendingpost')]
    public function pendingpost(UserRepository $userRepository,EntityManagerInterface $manager,BlogRepository $blogRepository): Response
    {
        $data=null;
        if ($this->getUser()) {
            if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                $posts=$blogRepository->findBystatusPending();
                $length = count($posts);
                $test=new data();
                $data=null;
                for ($i = 0; $i<=$length-1; $i++) {
                    $User=$userRepository->findbyID($posts[$i]->getIdUser());
                    $test->setUser($User);
                    $test->setBlog($posts[$i]);
                    $data[]=$test;
                    $test=new data();
                }

            }else
            {
                return $this->redirectToRoute('app_login');
            }
        }else
        {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('blogs/pendingblog.html.twig', [
            'controller_name' => 'UserManagerController',
            'posts'=>$data
        ]);
    }
}
