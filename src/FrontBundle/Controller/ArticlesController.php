<?php


namespace FrontBundle\Controller;


use DashBundle\Entity\Category;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller
{
    public function in_array_r($category, $jsonArray, $strict = false, $mode)
    {
        $filterContainer = array();
        foreach ($jsonArray as $row) {
            if ($mode == 'single') {
                if (($strict ? $row === $category : $row == $category) || (is_array($row) && $this->in_array_r($category, $row, $strict, $mode))) {
                    array_push($filterContainer, $row);
                }
            }
            elseif ($mode == 'all'){
                array_push($filterContainer, $row);
            }
        }
        return $filterContainer;
    }
    public function articleResultAction($catRef, $page, Request $request)
    {
//        $catRef = 8;
//            $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $article = $em->findOneBy(array('reference' => $catRef));
        $category = $article->getReference();
        //Get Article List From File And Convert From XML To Json Array
        $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).'/web/uploads/test.xml');
        $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
        $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
        $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getArticlesResponse']['ttrticles']['ttrticlesRow'];

        //Filter HERE
//        if ($request->isMethod('POST')) {
            $filteredResult = $this->in_array_r($category, $jsonArray, false,'single');
//        }else{
//            $filteredResult = $this->in_array_r($category, $jsonArray, false, 'all');
//        }
        $recordsTotoal = count($filteredResult);

        $adapter = new ArrayAdapter($filteredResult);
        $pagerfanta = new Pagerfanta($adapter);
        $productsPaged = $pagerfanta
            ->setMaxPerPage(12)
            ->setCurrentPage($page)
            ->getCurrentPageResults();
        if ($request->isMethod('POST')) {
            $result = $this->renderView('@Front/partials/elements/articleResult.html.twig',
                array(
                    'productsPaged' => $productsPaged,
                    'pager' => $pagerfanta,
                    'category' => $article
                ));
            return new JsonResponse($result) ;
        }
        return $this->render('@Front/partials/elements/articleResult.html.twig',
            array(
                'productsPaged' => $productsPaged,
                'pager' => $pagerfanta,
                'category' => $article
            ));
//        }
    }
    public function globalArticlesAction($category, $page, Request $request){
        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $article = $em->findOneBy(array('reference' => $category));
        $categoryName = $article->getName();
        return $this->render('@Front/pages/articleResult.html.twig', array('category' =>$category, 'page'=>$page, 'categoryName'=>$categoryName));
    }

    public function apercuRapideAction(Request $request){
        return $this->render('@Front/partials/elements/apercuRapide.html.twig');
    }
}
