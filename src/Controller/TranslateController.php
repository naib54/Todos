<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TranslateController extends AbstractController
{
    #[Route('/translate', name: 'app_translate')]
    public function index(): Response
    {
        return $this->render('translate/index.html.twig', [
            'controller_name' => 'TranslateController',
        ]);
    
    }

    
    #[Route("/change_locale/{locale}", name:"change_locale")]
    public function changeLocale($locale, Request $request)
    {
    // On stocke la langue dans la session
    $request->getSession()->set('_locale', $locale);

    // On revient sur la page précédente
    return $this->redirect($request->headers->get('referer'));
    }


}
