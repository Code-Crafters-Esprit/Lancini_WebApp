<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Facebook;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\AppCustomAuthenticator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use function PHPUnit\Framework\throwException;

class SecurityController extends AbstractController
{
    private $provider;

    public function __construct()
    {
        $this->provider = new Facebook([
            'clientId'          => $_ENV['FCB_ID'],
            'clientSecret'      => $_ENV['FCB_SECRET'],
            'redirectUri'       => $_ENV['FCB_CALLBACK'],
            'graphApiVersion'   => 'v15.0',
        ]);
    }
    #[Route(path: '/facebook-login', name: 'fcb-login')]
    public function facebookLogin(AuthenticationUtils $authenticationUtils): Response
    {
        $helper_url = $this->provider->getAuthorizationUrl();

        return $this->redirect($helper_url);
    }

    #[Route(path: '/facebook-callback', name: 'fcb-callback')]
    public function facebookCallback(Request $request, UserRepository $ur, EntityManagerInterface $manager, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        //get token
        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        try {
            //getting the user informations
            $user = $this->provider->getResourceOwner($token);
            

        } catch (\Throwable $th) {
            //throw $th;
            throwException($th);
        }
        $user = $user->toArray();
            $email = $user['email'];
            $nom = $user['first_name'];
            $prenom = $user['last_name'];
            $profilePhoto = array($user['picture_url']);
            $user_exist= $ur->findOneByEmail($email);

            if($user_exist){
                return $userAuthenticator->authenticateUser(
                    $user_exist,
                    $authenticator,
                    $request
                );
            }else{
                $new_user = new User();
                $new_user->setEmail($email)
                         ->setNom($nom)
                         ->setPrenom($prenom)
                         ->setRole('Simple User')
                         ->setMotdepasse(sha1(str_shuffle('abcd1234')));
                $manager->persist($new_user);
                $manager->flush();

                return $userAuthenticator->authenticateUser(
                    $new_user,
                    $authenticator,
                    $request
                );
            }
    }

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

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
