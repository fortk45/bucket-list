<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Category;
use App\Form\IdeeType;
use App\Repository\IdeaRepository;
use App\Form\IdeaModifityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class IdeaController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list()
    {
        $ideaRepo = $this->getDoctrine()->getRepository(Idea::class);
        $ideas = $ideaRepo->findAll();

        return $this->render('idea/index.html.twig', [
            "ideas" => $ideas
        ]);
    }

    /**
     * /**
     * @Route("/detail/{id}",
     * name="showId",
     * requirements={"id": "\d+"})
     */
    public function detail($id)
    {
        $ideaRepo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $ideaRepo->find($id);

        return $this->render('idea/detail.html.twig', [
        "idea" => $idea]);
    }

    /**
     * @Route("/add", name="addIdea")
     */
    public function addIdea(EntityManagerInterface $em, Request $request, TranslatorInterface $translator){

        $idea = new Idea();
        $ideaForm = $this->createForm(IdeeType::class, $idea);

        $ideaForm->handleRequest($request);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()) {
            $idea->setDateCreated(new \DateTime());
            $idea->setIsPublished(true);
            $em->persist($idea);
            $em->flush();

            $message = $translator->trans('The idea has been created !');

            $this->addFlash('success', $message);
            return $this->redirectToRoute('showId', [
                'id' => $idea->getId()
            ]);
        }

        return $this->render('idea/createIdee.html.twig', [
            "ideaForm" => $ideaForm->createView()
        ]);
    }

    /**
     * @Route("/modify/{id}",
     * name="modifyIdea",
     * requirements={"id": "\d+"})
     */
    public function modifyIdea(EntityManagerInterface $em, $id, Request $request, IdeaRepository $ideaRepository, TranslatorInterface $translator){
        $ideaRepo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $ideaRepo->find($id);
        $ideaForm = $this->createForm(IdeaModifityType::class, $idea);

        $ideaForm->handleRequest($request);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()) {
            $ideaRepository->add($idea, true);

            $message = $translator->trans('The idea has been modified !');

            $this->addFlash('success', $message);
            return $this->redirectToRoute('showId', [
                'id' => $idea->getId()
            ]);
        }

        return $this->render('idea/modifyIdee.html.twig', [
            "ideaForm" => $ideaForm->createView()
        ]);
    }

    /**
     * @Route("/dell/{id}",
     * name="delIdea",
     * requirements={"id": "\d+"})
     */
    public function delIdea(EntityManagerInterface $em, $id, TranslatorInterface $translator){

        $ideaRepo = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $ideaRepo->find($id);
        $em->remove($idea);
        $em->flush();

        $message = $translator->trans('The idea has been deleted !');

        $this->addFlash('success', $message);
        return $this->render('home.html.twig');
    }
}
