<?php

namespace App\Controller;

use App\Entity\Process;
use App\Entity\WorkerMachine;
use App\Form\ProcessType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/process", name="app_process_")
 */
class ProcessController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('process/index.html.twig', [
            'processes' => $em->getRepository(Process::class)->findAll()
        ]);
    }
    /**
     * @Route("/adding", name="adding", methods={"POST", "GET"})
     */
    public function addingProcess(Request $request, EntityManagerInterface $em): Response
    {
       $process = new Process();
       $form = $this->createForm(ProcessType::class, $process);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()) {
           if (!empty($em->getRepository(WorkerMachine::class)->findAll())) {
               $em->persist($process);
               $em->flush();
               return $this->redirectToRoute('app_process_index', [], Response::HTTP_SEE_OTHER);
           }
           else {
               $form->addError(new FormError('Нету ни одного сервера, добавьте хоть один сервер'));
           }
       }

       return $this->render('process/adding.html.twig', [
           'process' => $process,
           'form' => $form->createView()
       ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"GET", "DELETE"})
     */
    public function deleteProcess(int $id, EntityManagerInterface $em): Response
    {
        $process = $em->getRepository(Process::class)->find($id);
        $workerMachine = $process->getWorkerMachine();
        if (!is_null($workerMachine)) {
            $workerMachine->setCpuAvailable($workerMachine->getCpuAvailable() + $process->getCpuRequired());
            $workerMachine->setMemoryAvailable($workerMachine->getMemoryAvailable() + $process->getMemoryRequired());
            $em->persist($workerMachine);
        }
        $em->remove($process);
        $em->flush();
        return $this->redirectToRoute('app_process_index', [], Response::HTTP_SEE_OTHER);
    }
}
