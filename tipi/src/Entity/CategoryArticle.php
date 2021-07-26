<?php

namespace App\Entity;

use App\Entity\Liste;
use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\CategoryArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @ORM\Entity(repositoryClass=CategoryArticleRepository::class)
 */
class CategoryArticle
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
    private $titleCategoryArticle;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="categoryArticle")
     */
    private $articles;

    /**
     * @ORM\ManyToMany(targetEntity=Liste::class, mappedBy="titleCategoryArticle")
     */
    private $listes;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->listes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleCategoryArticle(): ?string
    {
        return $this->titleCategoryArticle;
    }

    public function setTitleCategoryArticle(string $titleCategoryArticle): self
    {
        $this->titleCategoryArticle = $titleCategoryArticle;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategoryArticle($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategoryArticle() === $this) {
                $article->setCategoryArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Liste[]
     */
    public function getListes(): Collection
    {
        return $this->listes;
    }

    public function addListe(Liste $liste): self
    {
        if (!$this->listes->contains($liste)) {
            $this->listes[] = $liste;
            $liste->addTitleCategoryArticle($this);
        }

        return $this;
    }

    public function removeListe(Liste $liste): self
    {
        if ($this->listes->removeElement($liste)) {
            $liste->removeTitleCategoryArticle($this);
        }

        return $this;
    }

}
