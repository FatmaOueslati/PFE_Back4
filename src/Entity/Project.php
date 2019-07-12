<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *      itemOperations={
 *     "get"={
 *            "normalization_context"={"groups"={"get"}},
 *            "methods"="GET"
 * }
 *}
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 * @ApiFilter(DateFilter::class, properties={"dateDebut"})
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 *
 */
class Project
{


    /**
     * Many meetings have Many projects.
     * @ManyToMany(targetEntity="meeting", inversedBy="projects")
     * @JoinTable(name="projects_meetings")
     */
    private $meet;

    /**
     * Many projects have Many Users.
     * @ManyToMany(targetEntity="User", mappedBy="projects")
     */
    private $users;

  
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Epic", mappedBy="projs")
     */
    protected $epics;



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *  @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get"})
     */
    private $status;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->epics = new ArrayCollection();
        $this->meet = new ArrayCollection();
    }



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

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param mixed $dateStart
     */
    public function setDateStart($dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param mixed $dateEnd
     */
    public function setDateEnd($dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status = 'on going'): void
    {
        $this->status = $status;
    }



    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addProject($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection|Epic[]
     */
    public function getEpics(): Collection
    {
        return $this->epics;
    }

    public function addEpic(Epic $epic): self
    {
        if (!$this->epics->contains($epic)) {
            $this->epics[] = $epic;
            $epic->setProjs($this);
        }

        return $this;
    }

    public function removeEpic(Epic $epic): self
    {
        if ($this->epics->contains($epic)) {
            $this->epics->removeElement($epic);
            // set the owning side to null (unless already changed)
            if ($epic->getProjs() === $this) {
                $epic->setProjs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|meeting[]
     */
    public function getMeet(): Collection
    {
        return $this->meet;
    }

    public function addMeet(meeting $meet): self
    {
        if (!$this->meet->contains($meet)) {
            $this->meet[] = $meet;
        }

        return $this;
    }

    public function removeMeet(meeting $meet): self
    {
        if ($this->meet->contains($meet)) {
            $this->meet->removeElement($meet);
        }

        return $this;
    }

}
