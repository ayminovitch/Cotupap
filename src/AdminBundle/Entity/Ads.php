<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ads
 *
 * @ORM\Table(name="ads")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\AdsRepository")
 */
class Ads
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
     * @ORM\Column(name="files", type="string", length=255, nullable=true)
     */
    private $files;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=500, nullable=true)
     */
    private $url;

    /**
     * @var int
     *
     * @ORM\Column(name="dateCreated", type="integer", nullable=true)
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=500, nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=500, nullable=true)
     */
    private $position;


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
     * Set files
     *
     * @param string $files
     *
     * @return Ads
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Ads
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Ads
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     *
     * @return Ads
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return int
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Ads
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

}

