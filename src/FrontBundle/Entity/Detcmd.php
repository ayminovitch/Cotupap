<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detcmd
 *
 * @ORM\Table(name="detcmd")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\DetcmdRepository")
 */
class Detcmd
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
     * @ORM\Column(name="article", type="string", length=255, nullable=true)
     */
    private $article;

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer", nullable=true)
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="totalprice", type="string", length=255, nullable=true)
     */
    private $totalprice;

    /**
     * @ORM\ManyToOne(targetEntity="DashBundle\Entity\Commande", inversedBy="Detcmd")
     * @ORM\JoinColumn(name="command_id", referencedColumnName="id")
     */
    private $commande;


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
     * Set article
     *
     * @param string $article
     *
     * @return Detcmd
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set qte
     *
     * @param integer $qte
     *
     * @return Detcmd
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Detcmd
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set totalprice
     *
     * @param string $totalprice
     *
     * @return Detcmd
     */
    public function setTotalprice($totalprice)
    {
        $this->totalprice = $totalprice;

        return $this;
    }

    /**
     * Get totalprice
     *
     * @return string
     */
    public function getTotalprice()
    {
        return $this->totalprice;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }


}

