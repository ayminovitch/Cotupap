<?php


namespace FrontBundle\Controller;


use DashBundle\Entity\Category;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller
{
    public function getArticleContent(){
        $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).$this->getParameter('articles_path'));
        $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
        $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
        $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getArticlesResponse']['ttrticles']['ttrticlesRow'];
        return $jsonArray;
    }

    public function in_array_r($category, $jsonArray, $strict = false, $mode)
    {
        $filterContainer = array();
        foreach ($jsonArray as $row) {
            if ($mode == 'single') {
                if (($strict ? $row === $category : $row == $category) || (is_array($row) && $this->in_array_r($category, $row, $strict, $mode))) {
                    array_push($filterContainer, $row);
                }
            }
            elseif ($mode = 'singleArticle'){
                if ($row['tarticle'] == $category) {
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

        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $article = $em->findOneBy(array('reference' => $catRef));
        if (substr($catRef,0,2) == 'CA'){
            $catRef = $article->getReference();
        }else{
            $catRef = $article->getParent();
        }
        $category = $article->getReference();
        $categoryb = $article->getReference();
        //Get Article List From File And Convert From XML To Json Array
        $jsonArray = $this->getArticleContent();
        //Filter HERE
        //if ($request->isMethod('POST')) {
        //If we have two categorys separated with + then we iterate throw them and merge all arrays
        if (strpos($category, '+') !== false) {
            $category = explode ("+", $category);
            $filteredResult = [];
            foreach ($category as $catr){
                $filteredResult = array_merge($filteredResult, $this->in_array_r($catr, $jsonArray, false,'single'));
            }
        }else{
            $filteredResult = $this->in_array_r($category, $jsonArray, false,'single');
        }
        //End Of Merging two categorys
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
                    'category' => $article,
                    'catso' => $catRef,
                    'soucatso' => $categoryb
                ));
            return new JsonResponse($result) ;
        }
        return $this->render('@Front/partials/elements/articleResult.html.twig',
            array(
                'productsPaged' => $productsPaged,
                'pager' => $pagerfanta,
                'category' => $article,
                'catso' => $catRef,
                'soucatso' => $categoryb
            ));
//        }
    }
    public function globalArticlesAction($category, $page, Request $request){
        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $article = $em->findOneBy(array('reference' => $category));
        $categoryName = $article->getName();
        return $this->render('@Front/pages/articleResult.html.twig', array('category' =>$category, 'page'=>$page, 'categoryName'=>$categoryName));
    }

    public function searchAction(Request $request){
        $query = $request->get('q');
        $jsonArray = $this->getArticleContent();
        //Filter HERE
        if ($request->isMethod('POST')) {
        $filteredResult = $this->in_array_r($query, $jsonArray, false,'single');
        }
        $recordsTotoal = count($filteredResult);

        $adapter = new ArrayAdapter($filteredResult);
        $pagerfanta = new Pagerfanta($adapter);
        $productsPaged = $pagerfanta
            ->setMaxPerPage(12)
            ->setCurrentPage(1)
            ->getCurrentPageResults();
        if ($request->isMethod('POST')) {
            $result = $this->renderView('@Front/partials/elements/articleResult.html.twig',
                array(
                    'productsPaged' => $productsPaged,
                    'pager' => $pagerfanta,
                    'category' => $query
                ));
            return new JsonResponse($result) ;
        }
        return $this->render('@Front/partials/elements/articleResult.html.twig',
            array(
                'productsPaged' => $productsPaged,
                'pager' => $pagerfanta,
                'category' => $query
            ));
//        }
    }

    public function apercuRapideAction($tcateg, $tsouscateg, $ref, Request $request){
        //Get Article List From File And Convert From XML To Json Array
        $jsonArray = $this->getArticleContent();
        //Filter HERE
//        $tarticle = $request->request->get('tarticle');
        $filteredResult = $this->in_array_r($ref, $jsonArray, false,'singleArticle');
        //get information about category
        $em = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $soucat = $em->findOneBy(array('reference' => $tsouscateg));
        $cat = $em->findOneBy(array('reference' => $tcateg));
        $refArticle = explode (".", $filteredResult[0]['tarticle']);
        $uploadDir = $this->get('kernel')->getArticlesDir() . DIRECTORY_SEPARATOR . $cat->getReference() . DIRECTORY_SEPARATOR . $soucat->getReference() . DIRECTORY_SEPARATOR . $refArticle[2] ;
        $files = [];
        if(is_dir($uploadDir))
        {
            $files = array_map('basename', glob($uploadDir . "/*.{jpg,gif,png}", GLOB_BRACE));
        }
        return $this->render('@Front/pages/singleArticle.html.twig',
            array(
                'soucat' => $soucat,
                'cat' => $cat,
                'article' => $filteredResult[0],
                'options' => $files
            ));
    }
}
