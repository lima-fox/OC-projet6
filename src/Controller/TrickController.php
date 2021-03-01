<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(TrickRepository $trickRepository, int $id, Request $request, CommentRepository $commentRepository): Response
    {
        $trick = $trickRepository->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();
            $date_comment = new \DateTime("now");

            $comment->setUser($this->getUser());
            $comment->setTrick($trick);
            $comment->setDateComment($date_comment);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();


        }

        $comments = $commentRepository->findBy(['trick' => $trick], ['id' => 'desc'], 10 );


        return $this->render('trick/index.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'comments' => $comments
        ]);
    }

    public function addTrick(Request $request, SluggerInterface $slugger) : Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $trick = $form->getData();
            $video_url = $request->request->all()['trick']['videos'];

            $v = new Video();
            $v->setLink($video_url);

            $photo = $form->get('photos')->getData();


            $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();


            $photo->move(
                'img_trick',
                $newFilename
            );

            $p = new Photo();
            $p->setPath($newFilename);

            $trick->setUserId($this->getUser());
            $trick->addVideo($v);
            $trick->addPhoto($p);

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Le trick a bien été ajouté, merci pour votre contribution'
            );

            return $this->redirectToRoute("index");

        }


        return $this->render('trick/addtrick.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function updateTrick(int $id, TrickRepository $trickRepository, Request $request, SluggerInterface $slugger) : Response
    {
        $trick = $trickRepository->find($id);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $trick = $form->getData();
            $video_url = $request->request->all()['trick']['videos'];

            $v = new Video();
            $v->setLink($video_url);

            $photo = $form->get('photos')->getData();


            $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();


            $photo->move(
                'img_trick',
                $newFilename
            );

            $p = new Photo();
            $p->setPath($newFilename);

            $trick->setUserId($this->getUser());
            $trick->addVideo($v);
            $trick->addPhoto($p);

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Le trick a bien été modifié, merci pour votre contribution'
            );

            return $this->redirectToRoute("index");

        }

        return $this->render('trick/updatetrick.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
