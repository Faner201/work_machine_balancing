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
    private $memoryRequired;

    /**
     * @ORM\Column(type="integer")
     */
    private $cpuRequired;

    /**
     * @ORM\ManyToOne(targetEntity="WorkerMachine", inversedBy="processesArray")
     */
    private $machineId;

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

    public function getMachineId(): ?int
    {
        return $this->machineId;
    }
    public function setMachineId(int $machineId): self
    {
        $this->machineId = $machineId;

        return  $this;
    }

}
