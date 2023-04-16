<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UpdateBlogController extends AbstractController
{
    #[Route('/updateblog/{id}', name: 'app_update_blog')]
    public function index($id,BlogRepository $blogRepository,EntityManagerInterface $manager,SluggerInterface $slugger,Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $blog=$blogRepository->findByIDobject($id);
        $img=$blog->getImage();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $blog=$form->getData();
            $photo = $form->get('image')->getData();
            if ($photo!=null)
            {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('blog_Imgs'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $blog->setImage($newFilename);
            }
            $manager->persist($blog);
            $manager->flush();
            return $this->redirectToRoute('app_blogs');

        }
        return $this->render('update_blog/index.html.twig', [
            'controller_name' => 'UpdateBlogController',
            'BlogForm'=>$form,
            'img'=>$img
        ]);
    }
    #[Route('/deleteblog/{id}', name: 'app_delete_blog', methods: ['GET','DELETE'])]
    public function deleteblog($id,BlogRepository $blogRepository,UserRepository $userRepository,EntityManagerInterface $manager,SluggerInterface $slugger,Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $blog=$blogRepository->findByIDobject($id);
        $userallowed=$userRepository->findbyID($blog->getIdUser());
        $usernotallowed=$userRepository->findbyEmail($this->getUser()->getUserIdentifier());

        if ($usernotallowed->getId()-$userallowed->getId()<>0)
        {
            if($usernotallowed->getRoles()[0]=="ROLE_ROOT")
            {
                $manager->remove($blog);
                $manager->flush();
            }
            return $this->redirectToRoute('app_blogs');
        }
        return $this->redirectToRoute('app_blogs');
    }
}
