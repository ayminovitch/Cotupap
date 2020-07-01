<?php


namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function contactAction(\Symfony\Component\HttpFoundation\Request $request){
        return $this->render('@Front/pages/contact.html.twig');
    }
}