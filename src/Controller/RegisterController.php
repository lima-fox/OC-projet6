<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $hash = md5( rand(0,1000) );

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setHash($hash);
            //$user->setStatus(1);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $verify_mail = $this->generateUrl('verify_mail', ['hash' => $hash]);

            $to      = $user->getEmail(); // Send email to our user
            $subject = 'Activez votre adresse mail'; // Give the email a subject
            $message = '
 
            Bonjour '.sprintf('%s', $user->getName()).'  
            
            Votre compte a bien été enregistré, 
            
             
            Merci de cliquer sur le lien ci-dessous afin de l\'activer.
            http://snowtricks.test/'.$verify_mail.'
             
            '; // Our message above including the link

            mail($to, $subject, $message); // Send our email

            //header('Location: /seconnecter');

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function verify_mail(UserRepository $userRepository, string $hash): Response
    {
        $user = $userRepository->findByHash($hash);

        if($user == null)
            throw $this->createNotFoundException(
                'Impossible de valider cette adresse mail'
            );

        $user->setStatus(1);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute("login");

    }
}
