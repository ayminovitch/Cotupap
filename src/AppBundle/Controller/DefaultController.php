<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }


    public function soapAction()
    {
        $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).'/web/uploads/test.xml');
        $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
        $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
        $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getArticlesResponse']['ttrticles']['ttrticlesRow'];
//        dump($jsonArray[0]);
//        die();
        return $this->render('default/soap.html.twig');
    }
}
