<?php

namespace App\Entity;

use App\Repository\WorkerMachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $memoryTotal;

    /**
     * @ORM\Column(type="integer")
     */
    private $cpuTotal;

    /**
     * @ORM\Column(type="integer")
     */
    private $memoryAvailable;

    /**
     * @ORM\Column(type="integer")
     */
    private $cpuAvailable;

    /**
     * @ORM\OneToMany(targetEntity="Process", mappedBy="machineId")
     */

    private $processesArray;

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

    public function getMemoryAvailable(): ?int
    {
        return $this->memoryAvailable;
    }

    public function setMemoryAvailable(int $memoryAvailable): self
    {
        $this->memoryAvailable = $memoryAvailable;

        return $this;
    }

    public function getCpuAvailable(): ?int
    {
        return $this->cpuAvailable;
    }

    public function __construct()
    {
        $this->processesArray = new ArrayCollection();
    }

    public function setCpuAvailable(int $cpuAvailable): self
    {
        $this->cpuAvailable = $cpuAvailable;

        return $this;
    }

    public function getProcessesArray(): ArrayCollection
    {
        return $this->processesArray;
    }

    public function setProcessesArray(ArrayCollection $processesArray): void
    {
        $this->processesArray = $processesArray;
    }
}
