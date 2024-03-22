<?php

namespace App\Controller;

use App\Entity\Process;
use App\Repository\ProcessRepository;
use App\Repository\WorkerMachineRepository;
use App\Utils\Balancing;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/balancing", name="app_balancing_")
 */
class BalancingController extends AbstractController
{
    private ProcessRepository $processRep;
    private WorkerMachineRepository $workerMachineRep;
    private EntityManagerInterface $em;

    public function __construct(ProcessRepository $processRepository, WorkerMachineRepository $workerMachineRepository, EntityManagerInterface $em)
    {
        $this->processRep = $processRepository;
        $this->workerMachineRep = $workerMachineRepository;
        $this->em = $em;
    }

    /**
     * @Route("/cpu", name="cpu", methods={"GET"})
     */
    public function balancingCpu(): Response
    {
        if (empty($this->processRep->getAllIndex())) {
            return $this->render('error/error.html.twig', [
                'message' => 'нету процессов для балансировки'
            ]);
        } else if (empty($this->workerMachineRep->getAllIndex())) {
            return $this->render('error/error.html.twig', [
                'message' => 'нету рабочих машид для балансировки'
            ]);
        }

        $rebalanced = new Balancing($this->processRep, $this->workerMachineRep, $this->em);

        return $this->render('balancing/index.html.twig', [
            'message' => $rebalanced->rebalanced('cpu')
        ]);
    }

    /**
     * @Route("/memory", name="memory", methods={"GET"})
     */
    public function balancingMemory(): Response
    {
        if (empty($this->processRep->getAllIndex())) {
            return $this->render('error/error.html.twig', [
                'message' => 'нету процессов для балансировки'
            ]);
        } else if (empty($this->workerMachineRep->getAllIndex())) {
            return $this->render('error/error.html.twig', [
                'message' => 'нету рабочих машид для балансировки'
            ]);
        }

        $rebalanced = new Balancing($this->processRep, $this->workerMachineRep, $this->em);

        return $this->render('balancing/index.html.twig', [
            'message' => $rebalanced->rebalanced('memory')
        ]);
    }
}
