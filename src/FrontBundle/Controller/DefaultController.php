<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Front/Default/index.html.twig');
    }

    public function categorysAction(){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $categorys = $em->findBy(array('niveau' => 2));
        $heading = $em->findBy(array('niveau' => 1));
        return $this->render('@Front/partials/elements/categorys.html.twig', array('categorys' => $categorys, 'heading' => $heading));
    }

    public function panierTopHeaderAction(Request $request){
        $session = $request->getSession();
        if (!($session->has('panier'))){
            $session->set('panier', []);
        }
        $panier = $session->get('panier');
        $nbrItems = count($panier);
        if ($nbrItems == 0){
            $status = 'hidden';
        }else{
            $status = '';
        }
        $somme = 0;
        foreach ($panier as $keyz => $valuez) {
            $singleArticlePrice = $panier[$keyz]['qte'] * $panier[$keyz]['prix'];
            $somme += $singleArticlePrice;
        }
        return $this->render('@Front/partials/elements/top-basket.html.twig', array('items'=>$panier, 'nbrItems' => $nbrItems, 'status'=>$status, 'somme'=>$somme));
    }
}



