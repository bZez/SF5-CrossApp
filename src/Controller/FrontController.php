<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FrontController extends AbstractController
{

    #[Route('/', name: 'front')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $request = Request::createFromGlobals();
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('front/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/@{route}', name: 'app')]
    public function app($route): Response
    {
        $response = $this->render('app/page/' . $route . '.html.twig')->getContent();
        $request = Request::createFromGlobals();
        $auth = $request->get('auth');
        if (!$this->isCsrfTokenValid('navs', $auth) && !$this->isCsrfTokenValid('authenticate', $auth) && $auth !== 'visitor')
            return $this->render('front/index.html.twig');
        return new Response($response);
    }

}
