<?php


namespace FrontBundle\Controller;


use DashBundle\Entity\Category;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function preSearchContainerAction(Request $request){
        $query = $request->request->get('query');
        return $this->redirectToRoute('search', array('query' => $query, 'page'=>1));
    }
    public function searchContainerAction($query, $page){
        return $this->render('@Front/pages/searchResult.html.twig', array('query' => $query, 'page' => $page));
    }


    public function searchAction($query, $page, Request $request){
//        $query = $request->get('q');
        $jsonArray = $this->getArticleContent();
        //Filter HERE
        $filteredResult = $this->in_array_r($query, $jsonArray, false,'single');
        $recordsTotoal = count($filteredResult);

        $adapter = new ArrayAdapter($filteredResult);
        $pagerfanta = new Pagerfanta($adapter);
        $productsPaged = $pagerfanta
            ->setMaxPerPage(24)
            ->setCurrentPage($page)
            ->getCurrentPageResults();
        if ($request->isMethod('POST')) {
            $result = $this->renderView('@Front/partials/elements/searchResult.html.twig',
                array(
                    'productsPaged' => $productsPaged,
                    'pager' => $pagerfanta,
                    'query' => $query
                ));
            return new JsonResponse($result) ;
        }
        return $this->render('@Front/partials/elements/searchResult.html.twig',
            array(
                'productsPaged' => $productsPaged,
                'pager' => $pagerfanta,
                'query' => $query
            ));
//        }
    }

    public function getArticleContent(){
        $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).$this->getParameter('articles_path'));
        $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
        $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
        $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getArticlesResponse']['ttrticles']['ttrticlesRow'];
        return $jsonArray;
    }

    public function in_array_r($query, $jsonArray, $strict = false, $mode)
    {
        $filterContainer = array();
        foreach ($jsonArray as $row) {
            if ($this->checkarrayvalues($query, $row, false, true)){
                array_push($filterContainer, $row);
            }
        }
        return $filterContainer;
    }

    function checkarrayvalues($term, $arr, $strict = false, $partial = false) {
        if ($partial) {  // whether it should perform a partial match
            $fn = ($strict) ? "strpos" : "stripos";
        }
        foreach ($arr as $item) {
            if (is_array($item)) {
                if ($this->checkarrayvalues($term, $item, $strict, $partial))
                    return true;
            } elseif (($partial && call_user_func($fn, $item, $term) !== false)
                || ($strict ? $item === $term : $item == $term)) {
                return true;
            }
        }
        return false;
    }
}