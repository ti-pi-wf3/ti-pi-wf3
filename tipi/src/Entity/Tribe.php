<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TribeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TribeRepository::class)
 */
class Tribe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tribeName;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="tribeId")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=CategoryDocument::class, mappedBy="tribeCategoryDoc")
     */
    private $categoryDocumentsTribe;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->categoryDocumentsTribe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTribeName(): ?string
    {
        return $this->tribeName;
    }

    public function setTribeName(string $tribeName): self
    {
        $this->tribeName = $tribeName;

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
            $user->setTribeId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTribeId() === $this) {
                $user->setTribeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CategoryDocument[]
     */
    public function getCategoryDocumentsTribe(): Collection
    {
        return $this->categoryDocumentsTribe;
    }

    public function addCategoryDocumentsTribe(CategoryDocument $categoryDocumentsTribe): self
    {
        if (!$this->categoryDocumentsTribe->contains($categoryDocumentsTribe)) {
            $this->categoryDocumentsTribe[] = $categoryDocumentsTribe;
            $categoryDocumentsTribe->setTribeCategoryDoc($this);
        }

        return $this;
    }

    public function removeCategoryDocumentsTribe(CategoryDocument $categoryDocumentsTribe): self
    {
        if ($this->categoryDocumentsTribe->removeElement($categoryDocumentsTribe)) {
            // set the owning side to null (unless already changed)
            if ($categoryDocumentsTribe->getTribeCategoryDoc() === $this) {
                $categoryDocumentsTribe->setTribeCategoryDoc(null);
            }
        }

        return $this;
    }
}
