<?php


namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompteClientController extends Controller
{
    public function mainAccountAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        if (!($session->has('client'))){
            $session->set('client', []);
        }
        $clientSession = $session->get('client');
        $clientObj = $em->getRepository('DashBundle:Client')->findBy(array('codeClient' => $clientSession['tclient'] ));
        $orders = $em->getRepository('DashBundle:Commande');
        $clientOrder = $orders->findBy(array('client'=>$clientObj));
        return $this->render('@Front/pages/compte.html.twig', array('clientOrders' => $clientOrder));
    }
}