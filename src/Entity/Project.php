<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;


/**
 * @ApiResource(
 *       itemOperations={
 *         "postAttemptCreateProject"={
 *         "denormalization_context"={"groups"={"create_project"}},
 *            "route_name"="api_projects_post_collection",
 *            "method"= "POST",
 *            "swagger_context" = {
 *               "responses" = {
 *                   "200" = {
 *                       "description" = "Successful create project ",
 *                       "schema" =  {
 *                           "type" = "object",
 *                           "required" = {
 *                               "name",
 *                               "dateDebut"
 *                           },
 *                           "properties" = {
 *                                "name" = {
 *                                   "type" = "string"
 *                                },
 *                                "description" = {
 *                                   "type" = "string"
 *                                },
 *                                "dateDebut" = {
 *                                   "type" = "datetime"
 *                                },
 *                                "dateFin" = {
 *                                   "type" = "datetime"
 *                                },
 *                           }
 *                       }
 *                   },
 *                   "400" = {
 *                       "description" = "Invalid input"
 *                   },
 *                   "401" = {
 *                       "description" = "Authentication failure"
 *                   }
 *                  },
 *                  "summary" = "Create Project",
 *                  "consumes" = {
 *                       "application/json",
 *                   },
 *                  "produces" = {
 *                      "application/json"
 *                   }
 *              }
 *          }
 *     })
 *
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 * @ApiFilter(DateFilter::class, properties={"dateDebut"})
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 *
 */
class Project
{

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
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->epics = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut): void
    {
        $this->statut = $statut;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
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
}
