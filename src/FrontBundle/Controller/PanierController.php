<?php


namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function panierAction(Request $request){
        return $this->render('@Front/pages/panier.html.twig');
    }
}