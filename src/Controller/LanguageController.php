<?php

namespace App\Controller;

use App\Locale\LocaleResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LanguageController extends AbstractController
{
    private $session;
    private $localeResolver;

    public function __construct(SessionInterface $session, LocaleResolver $localeResolver)
    {
        $this->session = $session;
        $this->localeResolver = $localeResolver;
    }

    #[Route("/language/{locale}", name:"language_switcher")]
    public function switchLocale(Request $request, $locale): Response
    {
       // Set the new locale in the session
       $this->session->set('locale', $locale);
       $this->localeResolver->setDefaultLocale($locale);

       // Redirect the user back to the previous page
       $referer = $request->headers->get('referer');
       return new RedirectResponse($referer);
   }
}
