<?php

namespace App\Controller;

use App\Entity\Process;
use App\Entity\WorkerMachine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('main/index.html.twig', [
            'workersMachine' => $em->getRepository(WorkerMachine::class)->findAll(),
            'processes' => $em->getRepository(Process::class)->findAll()
        ]);
    }
}
