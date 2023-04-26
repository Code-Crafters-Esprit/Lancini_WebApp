<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LanguageController extends AbstractController
{
    #[Route("/language/{locale}", name:"language_switcher")]
    public function switchLocale(Request $request, SessionInterface $session, $locale): Response
    {
        // Set the new locale in the session
        $session->set('locale', $locale);

        // Set the new default locale using a custom service
        $localeResolver = $this->get('App\Locale\LocaleResolver');
        $localeResolver->setDefaultLocale($locale);

        // Redirect the user back to the previous page
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
