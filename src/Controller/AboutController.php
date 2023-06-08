<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    /**
     * @Route("/about")
     */
    public function list()
    {
        return $this->render("about.html.twig");
    }

    /**
     * @Route("/about/{id}",
     * requirements={"id": "\d+"})
     */
    public function detail($id)
    {

        die($id);
        return $this->render("about.html.twig");
    }
}