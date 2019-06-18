<?php

namespace App\Entity;



use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Epic;

/**
 * @ApiResource(
 *     itemOperations={
 *         "dragAndDrop"={
 *         "denormalization_context"={"groups"={"dragAndDrop"}},
 *            "route_name"="drag_drop",
 *            "method"= "PUT",
 *            "swagger_context" = {
 *               "responses" = {
 *                   "200" = {
 *                       "description" = "Successful drag",
 *                       "schema" =  {
 *                           "type" = "object",
 *                           "required" = {
 *                               "statut"
 *                           },
 *                           "properties" = {
 *                                "staut" = {
 *                                   "type" = "string"
 *                                }
 *                            }
 *                       }
 *                   },
 *                   "400" = {
 *                       "description" = "Invalid input"
 *                   },
 *                   "401" = {
 *                       "description" = "drag failure"
 *                   }
 *                  },
 *                  "summary" = "change the status of the user story",
 *                  "consumes" = {
 *                       "application/json",
 *                   },
 *                  "produces" = {
 *                      "application/json"
 *                   }
 *              }
 *          }
 *     })
 * @ApiFilter(SearchFilter::class, properties={"name": "partial", "priorite": "partial"})
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
    private $priorite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

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

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(?string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

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
