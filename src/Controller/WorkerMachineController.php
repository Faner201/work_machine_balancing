<?php

namespace App\Controller;

use App\Entity\WorkerMachine;
use App\Form\WorkerMachineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/worker_machine", name="app_worker_machine_")
 */
class WorkerMachineController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('workerMachine/index.html.twig', [
            'workersMachine' => $em->getRepository(WorkerMachine::class)->findAll()
        ]);
    }
    /**
     * @Route("/adding", name="adding", methods={"POST", "GET"})
     */
    public function addingMachine(Request $request, EntityManagerInterface $em): Response
    {
        $workerMachine = new WorkerMachine();
        $form = $this->createForm(WorkerMachineType::class, $workerMachine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()) {
            $workerMachine->setMemoryAvailable($workerMachine->getMemoryTotal());
            $workerMachine->setCpuAvailable($workerMachine->getCpuTotal());
            $em->persist($workerMachine);
            $em->flush();
            return $this->redirectToRoute('app_worker_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('workerMachine/adding.html.twig', [
            'workersMachine' => $workerMachine,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE", "GET"})
     */

    public function deleteMachine(int $id, EntityManagerInterface $em): Response
    {
        $workerMachine = $em->getRepository(WorkerMachine::class)->find($id);
        $em->remove($workerMachine);
        $em->flush();
        return $this->redirectToRoute('app_worker_machine_index', [], Response::HTTP_SEE_OTHER);
    }
}
