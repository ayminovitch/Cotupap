<?php

namespace DashBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="DashBundle\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="fullname", type="string", length=255, nullable=true)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string", length=500, nullable=true)
     */
    private $addresse;

    /**
     * @var string
     *
     * @ORM\Column(name="mfiscal", type="string", length=255, nullable=true)
     */
    private $mfiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="verified", type="boolean", length=255, options={"default" : 0})
     */
    private $verified;


    /**
     * @var string
     *
     * @ORM\Column(name="code_client", type="string", length=255, nullable=true)
     */
    private $codeClient;

    /**
     * @ORM\OneToMany(targetEntity="DashBundle\Entity\Commande", mappedBy="client")
     */
    private $commande;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
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
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Client
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set addresse
     *
     * @param string $addresse
     *
     * @return Client
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;

        return $this;
    }

    /**
     * Get addresse
     *
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * Set mfiscal
     *
     * @param string $mfiscal
     *
     * @return Client
     */
    public function setMfiscal($mfiscal)
    {
        $this->mfiscal = $mfiscal;

        return $this;
    }

    /**
     * Get mfiscal
     *
     * @return string
     */
    public function getMfiscal()
    {
        return $this->mfiscal;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return ArrayCollection
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param ArrayCollection $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    /**
     * @return string
     */
    public function getCodeClient()
    {
        return $this->codeClient;
    }

    /**
     * @param string $codeClient
     */
    public function setCodeClient($codeClient)
    {
        $this->codeClient = $codeClient;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param string $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }


}

