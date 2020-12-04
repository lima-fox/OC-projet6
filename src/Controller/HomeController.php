<?php


namespace App\Controller;


use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index() :Response
    {
        $tricks = $this->entityManager->getRepository(Trick::class)->findBy([], ['id' => 'desc'], 15);

        return $this->render('home.html.twig', [
            'tricks' => $tricks
        ]);
    }
}