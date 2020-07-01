<?php

namespace DashBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="DashBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="dcr", type="datetime", nullable=true)
     */
    private $dcr;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=255, nullable=true)
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="situation", type="integer", nullable=true)
     */
    private $situation;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="DashBundle\Entity\Client", inversedBy="Commande")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\Detcmd", mappedBy="commande")
     */
    private $detcmd;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    public function __construct()
    {
        $this->detcmd = new ArrayCollection();
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
     * Set dcr
     *
     * @param \DateTime $dcr
     *
     * @return Commande
     */
    public function setDcr($dcr)
    {
        $this->dcr = $dcr;

        return $this;
    }

    /**
     * Get dcr
     *
     * @return \DateTime
     */
    public function getDcr()
    {
        return $this->dcr;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Commande
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set situation
     *
     * @param integer $situation
     *
     * @return Commande
     */
    public function setSituation($situation)
    {
        $this->situation = $situation;

        return $this;
    }

    /**
     * Get situation
     *
     * @return int
     */
    public function getSituation()
    {
        return $this->situation;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Commande
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Set status
     *
     * @param string $status
     *
     * @return Commande
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return ArrayCollection
     */
    public function getDetcmd()
    {
        return $this->detcmd;
    }

    /**
     * @param ArrayCollection $detcmd
     */
    public function setDetcmd($detcmd)
    {
        $this->detcmd = $detcmd;
    }
}

