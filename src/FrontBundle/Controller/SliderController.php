<?php


namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SliderController extends Controller
{
    public function renderSliderAction (Request $request){
        $em = $this->getDoctrine()->getManager();
        $sliders = $em->getRepository('AdminBundle:Slider')->findAll();
//        dump($sliders);
//        die();
        return $this->render('@Front/partials/slider.html.twig', array('sliders' => $sliders));
    }

    public function renderAdsAction (Request $request){
        $em = $this->getDoctrine()->getManager();
        $sliders = $em->getRepository('AdminBundle:Ads')->findAll();
//        dump($sliders);
//        die();
        return $this->render('@Front/partials/elements/ads.html.twig', array('ads' => $sliders));
    }

    public function renderMarquesAction (Request $request){
        $em = $this->getDoctrine()->getManager();
        $marques = $em->getRepository('AdminBundle:Marques')->findAll();
//        dump($sliders);
//        die();
        return $this->render('@Front/partials/elements/_marques.html.twig', array('marques' => $marques));
    }
}