<?php


namespace AdminBundle\Service;


use Doctrine\ORM\EntityManager;

class SettingsProvider
{
    private $em;

    /**
     * SettingsProvider constructor.
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function settings(){
        return $this->em->getRepository('AdminBundle:Settings')->findOneBy(array('id' => 1));
    }
}