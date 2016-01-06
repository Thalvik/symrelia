<?php

namespace Thalvik\SymreliaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="Thalvik\SymreliaBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="article_name", type="string", length=255)
     */
    private $articleName;


    /**
     * @var string
     *
     * @ORM\Column(name="article_slug", type="string", length=255)
     */
    private $articleSlug;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;


    /**
     *
     * @ORM\PrePersist
     */
    public function prePersist() {
      $this->created = new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set articleName
     *
     * @param string $articleName
     *
     * @return Article
     */
    public function setArticleName($articleName)
    {
        $this->articleName = $articleName;

        return $this;
    }

    /**
     * Get articleName
     *
     * @return string
     */
    public function getArticleName()
    {
        return $this->articleName;
    }

    /**
     * Set articleSlug
     *
     * @param string $articleSlug
     *
     * @return Article
     */
    public function setArticleSlug($articleSlug)
    {
        $this->articleSlug = $articleSlug;

        return $this;
    }

    /**
     * Get articleSlug
     *
     * @return string
     */
    public function getArticleSlug()
    {
        return $this->articleSlug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Article
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
