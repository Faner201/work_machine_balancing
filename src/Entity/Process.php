<?php

namespace App\Entity;

use App\Repository\ProcessRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProcessRepository::class)
 */
class Process
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
    private ?int $memoryRequired;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $cpuRequired;

    /**
     * @ORM\ManyToOne(targetEntity="WorkerMachine", inversedBy="processesArray")
     * @ORM\JoinColumn(name="machine_id",referencedColumnName="id",nullable=true)
     */
    private ?WorkerMachine $workerMachine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemoryRequired(): ?int
    {
        return $this->memoryRequired;
    }

    public function setMemoryRequired(int $memoryRequired): self
    {
        $this->memoryRequired = $memoryRequired;

        return $this;
    }

    public function getCpuRequired(): ?int
    {
        return $this->cpuRequired;
    }

    public function setCpuRequired(int $cpuRequired): self
    {
        $this->cpuRequired = $cpuRequired;

        return $this;
    }

    public function getWorkerMachine(): ?WorkerMachine
    {
        return $this->workerMachine;
    }

    public function setWorkerMachine(?WorkerMachine $workerMachine): void
    {
        $this->workerMachine = $workerMachine;
    }
}
