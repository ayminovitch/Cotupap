<?php


namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompteClientController extends Controller
{
    public function mainAccountAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        return $this->render('@Front/pages/compte.html.twig');
    }
}