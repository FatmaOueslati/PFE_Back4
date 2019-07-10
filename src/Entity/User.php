<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ApiResource(
 *     collectionOperations={
 *         "getUsers"={
 *              "normalization_context"={"groups"={"cget"}},
 *              "method"="GET"
 *          },
 *
 *         "postAttemptLogin"={
 *         "denormalization_context"={"groups"={"login"}},
 *            "route_name"="api_login_check",
 *            "method"= "POST",
 *            "swagger_context" = {
 *               "responses" = {
 *                   "200" = {
 *                       "description" = "Successful login attempt, returning a new token",
 *                       "schema" =  {
 *                           "type" = "object",
 *                           "required" = {
 *                               "username",
 *                               "password"
 *                           },
 *                           "properties" = {
 *                                "username" = {
 *                                   "type" = "string"
 *                                },
 *                                "password" = {
 *                                   "type" = "string"
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
 *                  "summary" = "Performs a login attempt, returning a valid token on success",
 *                  "consumes" = {
*                       "application/json",
 *                   },
 *                  "produces" = {
 *                      "application/json"
 *                   }
 *              }
 *           },
 *
 *           "createUser"={
 *           "denormalization_context"={"groups"={"create"}},
 *              "route_name"="app_user_newuser",
 *              "method"= "POST",
 *              "swagger_context" = {
 *                "responses" = {
 *                   "200" = {
 *                       "description" = "Successful creation",
 *                       "schema" =  {
 *                           "type" = "object",
 *                           "required" = {
 *                               "username",
 *                               "name",
 *                               "email",
 *                               "password"
 *                           },
 *                           "properties" = {
 *                                "username" = {
 *                                   "type" = "string"
 *                                },
 *                                "password" = {
 *                                   "type" = "string"
 *                                },
 *                                "email" = {
 *                                   "type" = "string"
 *                                },
 *                                "name" = {
 *                                   "type" = "string"
 *                                }
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
 *                  "summary" = "user created successfully",
 *                  "consumes" = {
 *                       "application/json",
 *                   },
 *                  "produces" = {
 *                      "application/json"
 *                   }
 *              }
 *          }
 *     }
 *
 * )
 * @ApiFilter(PropertyFilter::class)
 * @ApiFilter(OrderFilter::class, properties={"id"})
 *
 */

class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"get", "cget"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"get", "cget", "post", "updateUser", "create"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"get", "cget", "post","updateUser", "create"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post", "updateUser", "login" , "create"})
     *
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"get", "cget", "post", "updateUser", "login", "create"})
     */
    private $username;





    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", inversedBy="$users")
     * @JoinTable(name="users_projects")
     *
     * @Groups({"get"})
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
        }

        return $this;
    }
}
