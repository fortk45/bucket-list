<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render("home.html.twig");
    }

    /**
     * @Route("/base", name="test")
     */
    public function base()
    {
        return $this->render("base.html.twig");
    }

    /**
     * @Route("/about", name="aboutus")
     */
    public function about()
    {
        return $this->render("about.html.twig");
    }

    /**
     * @Route("/change-locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirect($request->headers->get('referer'));
    }
}