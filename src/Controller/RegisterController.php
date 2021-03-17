<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
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
            http://snowtricks.test'.$verify_mail.'
             
            '; // Our message above including the link

            mail($to, $subject, $message); // Send our email

            $this->addFlash(
                'success',
                'Votre inscription est terminée, veuillez activer votre adresse mail pour vous connecter.'
            );

            return $this->redirectToRoute("login");

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

        $this->addFlash(
            'success',
            'Votre compte est maintenant validé !'
        );

        return $this->redirectToRoute("login");

    }

    public function forgotPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer) : Response
    {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form_data = $form->getData();
            $email = $form_data['email'];

            $users = $userRepository->findBy(['email' => $email]);

            if (isset($users[0])) {
                $hash_pass = md5(rand(0, 1000));

                $user = $users[0];

                $user->setHashPass($hash_pass);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $forgotpassword = $this->generateUrl('resetpassword', ['hash_pass' => $hash_pass]);

                $message = '
 
            Bonjour '.sprintf('%s', $user->getName()).'  
            
            Vous avez demandé à réinitialiser votre mot de passe, 
            
             
            Merci de cliquer sur le lien ci-dessous et de suivre la procédure.
            http://snowtricks.test'.$forgotpassword.'
             
            '; // Our message above including the link

                $email = (new Email())
                    ->from('lulu@test.com')
                    ->to($user->getEmail())
                    ->subject('Réinitialiser votre mot de passe')
                    ->text($message);

                $mailer->send($email);

            }

            $this->addFlash(
                'success',
                'Un mail vous a été envoyé afin de réinitialiser votre mot de passe'
            );

            //return $this->redirectToRoute("forgotpassword");

        }

        return $this->render('register/forgotpassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function resetPassword(Request $request, string $hash_pass, UserRepository $userRepository, UserPasswordEncoderInterface $encoder) : Response
    {
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        $users = $userRepository->findBy(['hash_pass' => $hash_pass]);
        if (!isset($users[0])) {
            return $this->redirectToRoute("index");
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $users[0];

            $form_data = $form->getData();
            $password = $form_data['password'];

            $password = $encoder->encodePassword($user, $password);
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Votre mot de passe a bien été modifié'
            );

            return $this->redirectToRoute("login");

        }

        return $this->render('register/resetpassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
