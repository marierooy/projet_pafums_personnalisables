<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
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

    #[Route('/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, UserInterface $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new DateTimeImmutable);
            $createdPerfumeRepository->save($createdPerfume, true);

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/register', name: 'app_user_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(['ROLE_USER']);
            $user->setToken(bin2hex(random_bytes(20)));
            $user->setActive(0);
            $user->setCreatedAt(new DateTimeImmutable);
            $user->setUpdatedAt(new DateTimeImmutable);

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $request->get('user')['password']
            );

            $user->setPassword($hashedPassword);

            
            $text = '<p>Bonjour,</p>
                <p>Veuillez activer votre compte en cliquant sur le lien ci-dessous</p>
                <a href="' . $this->generateUrl('app_activate', ['token' => $user->getToken()], UrlGeneratorInterface::ABSOLUTE_URL) . '">Activer mon compte</a>
                <p>Cordialement,</p>';
                
            $text = $text . "<p>L'équipe d'Identité olfactive</p>";

            $email = (new Email())
            ->from('identite-olfactive@ecom.fr')
            ->to($user->getEmail())
            ->subject('Activez votre compte sur le site "Identité olfactive"')
            ->html($text);

            $mailer->send($email);
    
            $userRepository->save($user, true);

            $this->addFlash('activate', 'Vous avez reçu un email pour activer votre compte.');

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/register.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route(path: '/activate/{token}', name: 'app_activate')]
    public function activate($token, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $user->setActive(true);
            $user->setToken(null);
            $userRepository->save($user, true);
        }

        $this->addFlash('activate', 'Votre compte est bien activé.');
        
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }
}
