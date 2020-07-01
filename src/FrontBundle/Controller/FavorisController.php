<?php


namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FavorisController extends Controller
{
    public function favorisAction(Request $request){
        return $this->render('@Front/pages/wishlist.html.twig');
    }
}