<?php

namespace App\Utils;

use App\Entity\Process;
use App\Repository\ProcessRepository;
use App\Repository\WorkerMachineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class Balancing implements BalancingInterface
{
    private EntityManagerInterface $em;
    private WorkerMachineRepository $workerMachineRep;
    private ProcessRepository $processRep;

    public function __construct(ProcessRepository $processRepository, WorkerMachineRepository $workerMachineRepository, EntityManagerInterface $em)
    {
        $this->processRep = $processRepository;
        $this->workerMachineRep = $workerMachineRepository;
        $this->em = $em;
    }

    public function rebalanced(string $typeRebalanced): string
    {
        $cpuFactor = 0.5;
        $memoryFactor = 0.5;
        $this->resetRebalanced();
        while (($cpuFactor <= 1) && ($memoryFactor <= 1)) {
            $processes = $this->processRep->sortByTypeInDesc($typeRebalanced);
            $workerMachines = $this->workerMachineRep->sortByTypeInAsc($typeRebalanced);
            foreach ($workerMachines as $workerMachine) {
                $freeMemoryPercentage = $workerMachine->getMemoryAvailable() * $memoryFactor;
                $freeCpuPercentage = $workerMachine->getCpuAvailable() * $cpuFactor;
                foreach ($processes as &$process) {
                    $diffMemory = $freeMemoryPercentage - $process->getMemoryRequired();
                    $diffCpu = $freeCpuPercentage - $process->getCpuRequired();
                    if ($diffMemory >= 0 && $diffCpu >= 0 && is_null($process->getWorkerMachine())) {
                        $workerMachine->setMemoryAvailable($workerMachine->getMemoryAvailable() - $process->getMemoryRequired());
                        $workerMachine->setCpuAvailable($workerMachine->getCpuAvailable() - $process->getCpuRequired());
                        $process->setWorkerMachine($workerMachine);
                        $this->em->persist($process);
                    }
                }
            }
            $processesFree = array_filter($processes, fn($process) => is_null($process->getWorkerMachine()));
            if (empty($processesFree)) {
                $recoveryCpuFactor = 1 - $cpuFactor;
                $recoveryMemoryFactor = 1 - $memoryFactor;
                foreach ($workerMachines as &$machine) {
                    if (empty($machine->getProcessesArray())) {
                        $machine->setMemoryAvailable(
                            $machine->getMemoryAvailable() + $machine->getMemoryTotal() * $recoveryMemoryFactor
                        );
                        $machine->setCpuAvailable(
                            $machine->getCpuAvailable() + $machine->getCpuTotal() * $recoveryCpuFactor
                        );
                    }
                    $this->em->persist($machine);
                }
                $this->em->flush();
                return "Балансировка выполнена";
            }
            switch ($typeRebalanced) {
                case "cpu":
                    if ($memoryFactor != 1) {
                        $memoryFactor += 0.25;
                    } else {
                        $cpuFactor += 0.25;
                        $memoryFactor = 0.5;
                    }
                    break;
                case "memory":
                    if ($cpuFactor != 1) {
                        $cpuFactor += 0.25;
                    } else {
                        $memoryFactor += 0.25;
                        $cpuFactor = 0.5;
                    }
                    break;
            }
        }
        return 'Балансировка не удалась, расширьте пул серверов';
    }

    private function resetRebalanced(): void
    {
        $processes = $this->processRep->findAll();
        foreach ($processes as &$process) {
            if (!is_null($process->getWorkerMachine())) {
                $process->getWorkerMachine()->setMemoryAvailable($process->getWorkerMachine()->getMemoryAvailable() + $process->getMemoryRequired());
                $process->getWorkerMachine()->setCpuAvailable($process->getWorkerMachine()->getCpuAvailable() + $process->getCpuRequired());
            }
            $process->setWorkerMachine(null);
            $this->em->persist($process);
        }
        $this->em->flush();
    }
}