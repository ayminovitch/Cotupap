<?php

namespace DashBundle\Controller;

use DashBundle\Entity\Category;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('@Dash/pages/product/product-list.html.twig');
    }

    public function filterArticlesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $article = $em->findOneBy(array('id'=>$id));
        $articleName = $article->getName();
        return $this->render('@Dash/pages/product/product-list.html.twig', array('name'=>$articleName));
    }
    public function articleResultAction (Request $request, $id){

        if ($request->isMethod('POST')){
//            $id = 18;
//            $id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
            $article = $em->findOneBy(array('id'=>$id));
            $category = $article->getName();

            //Get Article List From File And Convert From XML To Json Array
            $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).'/web/uploads/test.xml');
            $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
            $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
            $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getArticlesResponse']['ttrticles']['ttrticlesRow'];

            //Filter HERE
            function in_array_r($category, $jsonArray, $strict = false) {
                $filterContainer = array();
                foreach ($jsonArray as $row) {
                    if (($strict ? $row === $category : $row == $category) || (is_array($row) && in_array_r($category, $row, $strict))) {
                        array_push($filterContainer, $row);
                    }
                }
                return $filterContainer;
            }
            $filteredResult = in_array_r($category, $jsonArray);
            $recordsTotoal = count($filteredResult);

            //Pagination to Fast Load Cotupap Article Result
            $page = $request->request->get('draw', 1);
            $maxpage = $request->request->get('length', 10);
            $adapter= new ArrayAdapter($filteredResult);
            $pagerfanta = new Pagerfanta($adapter);
            $pagerfanta->setMaxPerPage($maxpage);
            $pagerfanta->setCurrentPage($page);
            return new JsonResponse(array('data' =>$pagerfanta->getCurrentPageResults(), 'draw'=>$page, 'recordsTotal'=>$recordsTotoal));
        }
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $category = $em->findBy(array('parent' => $id));
        $heading = $em->findBy(array('id' => $id));
        return $this->render('@Dash/pages/product/product-list.html.twig', array('categorys' => $category, 'heading' => $heading));
    }
}
