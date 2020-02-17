<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\BirdModel;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BirdController extends AbstractController
{
    /**
     * Birds List
     * @Route("/", name="home")
     */
    public function home(SessionInterface $session)
    {
        $birdModel= new BirdModel;
        $birdsList = $birdModel->getBirds();

        $birdId = $session->get('bird_id');

        return $this->render('bird/home.html.twig',[
            'birds_list' => $birdsList,
            'bird_id' => $birdId,
        ]);
    }

    /**
     * @Route("/bird/{id}", name="bird_show", requirements={"id"="\d+"})
     */
    public function show($id, SessionInterface $session)
    {
        $birdModel = new BirdModel;
        $bird = $birdModel->getOneBird($id);

        // 404 if not found
        if ($bird === null) {
            throw $this->createNotFoundException('Bird not found');
        }

        $session->set('bird_id', $id);

        return $this->render('bird/show.html.twig', [
            'bird' => $bird,
        ]);
    }

    /**
     * @Route("/download", name="calendar_download")
     */
    public function download()
    {
        return $this->file('./files/angry_birds_2015_calendar.pdf');
    }
}
