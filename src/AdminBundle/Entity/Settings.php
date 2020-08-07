<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\SettingsRepository")
 */
class Settings
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
     * @ORM\Column(name="newsletter", type="string", length=50, nullable=true)
     */
    private $newsletter;

    /**
     * @var string
     *
     * @ORM\Column(name="search", type="string", length=50, nullable=true)
     */
    private $search;

    /**
     * @var string
     *
     * @ORM\Column(name="modal", type="string", length=50, nullable=true)
     */
    private $modal;

    /**
     * @var string
     *
     * @ORM\Column(name="maintenanceMode", type="string", length=50, nullable=true)
     */
    private $maintenanceMode;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=500, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=500, nullable=true)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=500, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="pinterest", type="string", length=500, nullable=true)
     */
    private $pinterest;

    /**
     * @var string
     *
     * @ORM\Column(name="sitedescription", type="text", nullable=true)
     */
    private $sitedescription;

    /**
     * @var string
     *
     * @ORM\Column(name="sitekeywords", type="text", nullable=true)
     */
    private $sitekeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;
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
     * @ORM\Column(name="cg", type="string", length=255, nullable=true)
     */
    private $cg;
    /**
     * @var string
     *
     * @ORM\Column(name="copyright", type="string", length=255, nullable=true)
     */
    private $copyright;

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
     * Set newsletter
     *
     * @param string $newsletter
     *
     * @return Settings
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return string
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set search
     *
     * @param string $search
     *
     * @return Settings
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set modal
     *
     * @param string $modal
     *
     * @return Settings
     */
    public function setModal($modal)
    {
        $this->modal = $modal;

        return $this;
    }

    /**
     * Get modal
     *
     * @return string
     */
    public function getModal()
    {
        return $this->modal;
    }

    /**
     * Set maintenanceMode
     *
     * @param string $maintenanceMode
     *
     * @return Settings
     */
    public function setMaintenanceMode($maintenanceMode)
    {
        $this->maintenanceMode = $maintenanceMode;

        return $this;
    }

    /**
     * Get maintenanceMode
     *
     * @return string
     */
    public function getMaintenanceMode()
    {
        return $this->maintenanceMode;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Settings
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     *
     * @return Settings
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Settings
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set pinterest
     *
     * @param string $pinterest
     *
     * @return Settings
     */
    public function setPinterest($pinterest)
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * Get pinterest
     *
     * @return string
     */
    public function getPinterest()
    {
        return $this->pinterest;
    }

    /**
     * Set sitedescription
     *
     * @param string $sitedescription
     *
     * @return Settings
     */
    public function setSitedescription($sitedescription)
    {
        $this->sitedescription = $sitedescription;

        return $this;
    }

    /**
     * Get sitedescription
     *
     * @return string
     */
    public function getSitedescription()
    {
        return $this->sitedescription;
    }

    /**
     * Set sitekeywords
     *
     * @param string $sitekeywords
     *
     * @return Settings
     */
    public function setSitekeywords($sitekeywords)
    {
        $this->sitekeywords = $sitekeywords;

        return $this;
    }

    /**
     * Get sitekeywords
     *
     * @return string
     */
    public function getSitekeywords()
    {
        return $this->sitekeywords;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Settings
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
    public function getcg()
    {
        return $this->cg;
    }

    /**
     * @param string $cg
     */
    public function setcg($cg)
    {
        $this->cg = $cg;
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }


}

