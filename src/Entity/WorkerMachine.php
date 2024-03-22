<?php

namespace App\Entity;

use App\Repository\WorkerMachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkerMachineRepository::class)
 */
class WorkerMachine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $memoryTotal;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $cpuTotal;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $memoryAvailable;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $cpuAvailable;

    /**
     * @ORM\OneToMany(targetEntity="Process", mappedBy="workerMachine", orphanRemoval=true, cascade={"remove"})
     */

    private $processesArray;

    public function __construct()
    {
        $this->processesArray = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemoryTotal(): ?int
    {
        return $this->memoryTotal;
    }

    public function setMemoryTotal(int $memoryTotal): self
    {
        $this->memoryTotal = $memoryTotal;

        return $this;
    }

    public function getCpuTotal(): ?int
    {
        return $this->cpuTotal;
    }

    public function setCpuTotal(int $cpuTotal): self
    {
        $this->cpuTotal = $cpuTotal;

        return $this;
    }

    public function getMemoryAvailable(): ?float
    {
        return $this->memoryAvailable;
    }

    public function setMemoryAvailable(float $memoryAvailable): self
    {
        $this->memoryAvailable = $memoryAvailable;

        return $this;
    }

    public function getCpuAvailable(): ?float
    {
        return $this->cpuAvailable;
    }

    public function setCpuAvailable(float $cpuAvailable): self
    {
        $this->cpuAvailable = $cpuAvailable;

        return $this;
    }

    public function getProcessesArray(): Collection
    {
        return $this->processesArray;
    }

    public function setProcessesArray(Collection $processesArray): void
    {
        $this->processesArray = $processesArray;
    }
}
