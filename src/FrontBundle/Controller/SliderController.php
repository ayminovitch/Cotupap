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
}