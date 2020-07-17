<?php


namespace AdminBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Slider
 *
 * @ORM\Table(name="sliders")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\SliderRepository")
 */

class Slider
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
     *
     * @ORM\Column(name="files", type="string", length=255)
     * @Assert\NotBlank(message="You must select at least one valid image
    file.")
     *
     */
    private $files;

    /**
     *
     * @ORM\Column(name="size", type="string", length=255)
     *
     */
    private $size;


    /**
     * @var int
     *
     * @ORM\Column(name="dateCreated", type="integer", nullable=true)
     */
    private $dateCreated;

    /**
     * Class Contructor
     *
     * @param array $options
     * @return void
     */
    public function __construct()
    {}

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
     * Set image Files
     *
     * @param String $files
     *
     * @return Slider
     */
    public function setFiles($files = NULL)
    {
        $this->files = (string)$files;

        return $this;
    }

    /**
     * Get image Files
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     *
     * @return Slider
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
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }


}