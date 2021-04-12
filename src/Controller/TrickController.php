<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickPhotoType;
use App\Form\TrickType;
use App\Form\TrickVideoType;
use App\Repository\CommentRepository;
use App\Repository\PhotoRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    public function addTrick(Request $request, TrickRepository $trickRepository) : Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $trick = $form->getData();

            $trick->setUserId($this->getUser());

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            return $this->redirectToRoute("addvideo", ['id' => $trick->getId()]);

        }


        return $this->render('trick/addtrick.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function addVideo(Request $request, int $id, TrickRepository $trickRepository) : Response
    {
        $trick = $trickRepository->find($id);

        $form = $this->createForm(TrickVideoType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
            $video_url = $request->request->all()['trick_video']['videos'];


            $v = new Video();
            $v->setLink($video_url);

            $trick->addVideo($v);

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            return $this->redirectToRoute("addvideo", ['id' => $trick->getId()]);
        }

        return $this->render('trick/addvideo.html.twig', [
            'form' => $form->createView(),
            'id' => $trick->getId(),
            'trick' => $trick
        ]);
    }

    public function addPhoto(Request $request, int $id, TrickRepository $trickRepository, SluggerInterface $slugger) : Response
    {
        $trick = $trickRepository->find($id);

        $form = $this->createForm(TrickPhotoType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();

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

            $trick->addPhoto($p);

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            return $this->redirectToRoute("addphoto", ['id' => $trick->getId()]);

        }

        return $this->render('trick/addphoto.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);

    }

    public function updateTrick(Request $request, int $id, TrickRepository $trickRepository) : Response
    {
        $trick = $trickRepository->find($id);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            return $this->redirectToRoute("addvideo", ['id' => $trick->getId()]);
        }

        return $this->render('trick/updateTrick.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    public function deletePhoto(int $photo_id, PhotoRepository $photoRepository) : Response
    {
        $photo = $photoRepository->find($photo_id);
        $trick_id = $photo->getTrickId()->getId();

        $this->entityManager->remove($photo);
        $this->entityManager->flush();


        return $this->redirectToRoute("addphoto", ['id' => $trick_id]);

    }

    public function deleteVideo(int $video_id, VideoRepository $videoRepository) : Response
    {
        $video = $videoRepository->find($video_id);
        $trick_id = $video->getTrickId()->getId();

        $this->entityManager->remove($video);
        $this->entityManager->flush();

        return $this->redirectToRoute("addvideo", ['id' => $trick_id]);

    }

    public function deleteTrick(int $id, TrickRepository $trickRepository) : Response
    {
        $trick = $trickRepository->find($id);

        foreach ($trick->getVideos() as $video)
        {
            $this->entityManager->remove($video);
        }

        foreach ($trick->getPhotos() as $photo)
        {
            $this->entityManager->remove($photo);
        }

        foreach ($trick->getComments() as $comment)
        {
            $this->entityManager->remove($comment);
        }

        $this->entityManager->remove($trick);
        $this->entityManager->flush();

        return $this->redirectToRoute("index");
    }

    public function finalStep() : Response
    {
        $this->addFlash(
            'success',
            'Votre Trick a bien été ajouté / modifié.'
        );

        return $this->redirectToRoute("index");
    }


}
