<?php

namespace App\Controller;

use App\Entity\User;
use
    Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function register()
    {
        return $this->render('security/register.html.twig');
    }

    //ajouter la route qui va bien
    public function register_process(Request $request, ValidatorInterface $validator) {

        //https://symfony.com/doc/current/security/csrf.html#csrf-protection-in-symfony-forms
        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('register', $submittedToken)) {
            return new Response(null, 403);
        }

        $name = $request->request->get("name");
        $email = $request->request->get("email");
        $password = $request->request->get("password");
        $password2 = $request->request->get("password2");

        if ($password |= $password2)
        {
            $error_pass = 'Les deux mot de passe ne sont pas identiques';
        }

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);

        $errors = $validator->validate($user);
        var_dump($errors);
        //exit();

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        //https://symfony.com/doc/current/validation.html

        //inserer en base
        //https://symfony.com/doc/current/bundles/DoctrineMongoDBBundle/first_steps.html#service-repositories

        // return redirect
    }
}
