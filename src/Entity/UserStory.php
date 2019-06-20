<?php

namespace App\Entity;



use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Epic;

/**
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"name": "partial", "priorite": "partial",})
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserStoryRepository")
 */
class UserStory
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Epic", inversedBy="stories")
     * @JoinColumn(name="epic_id", referencedColumnName="id")
     */
    protected $epic;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $BV;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"drag"})
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ptComplex;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBV(): ?int
    {
        return $this->BV;
    }

    public function setBV(?int $BV): self
    {
        $this->BV = $BV;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }



    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status = 'new'): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPtComplex()
    {
        return $this->ptComplex;
    }

    /**
     * @param mixed $ptComplex
     */
    public function setPtComplex($ptComplex): void
    {
        $this->ptComplex = $ptComplex;
    }



    public function getEpic(): ?Epic
    {
        return $this->epic;
    }

    public function setEpic(?Epic $epic): self
    {
        $this->epic = $epic;

        return $this;
    }


}
