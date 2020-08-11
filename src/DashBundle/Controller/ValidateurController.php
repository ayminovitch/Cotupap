<?php


namespace DashBundle\Controller;


use DashBundle\Entity\Client;
use DashBundle\Entity\Commande;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ValidateurController extends Controller
{
 public function clientsListAction (Request $request){

     if ($request->isMethod('POST')){
         //Get Article List From File And Convert From XML To Json Array
         $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).'/web/uploads/clients.xml');
         $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
         $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
         $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getClientsResponse']['ttclients']['ttclientsRow'];

         $recordsTotoal = count($jsonArray);

         //Pagination to Fast Load Cotupap Article Result
         $page = $request->request->get('draw', 1);
         $maxpage = $request->request->get('length', 10);
         $adapter= new ArrayAdapter($jsonArray);
         $pagerfanta = new Pagerfanta($adapter);
         $pagerfanta->setMaxPerPage($maxpage);
         $pagerfanta->setCurrentPage($page);
         return new JsonResponse(array('data' =>$pagerfanta->getCurrentPageResults(), 'draw'=>$page, 'recordsTotal'=>$recordsTotoal));
     }
     return $this->render('@Dash/validateur/clients-list.html.twig');
 }

 public function commandListAction(Request $request){
     $em = $this->getDoctrine()->getManager();
     if ($request->isMethod('POST')){
         if ($request->request->get('type') == 'singleCommand') {
             //If Method POST then Trait the logic of showing single command informations
             $req = $request->request;
             $id = $req->get('id');
             $commande = $em->getRepository('DashBundle:Commande')->findOneBy(array('id' => $id));
             $view = $this->renderView('@Dash/partials/_modalCommand.html.twig', array('command' => $commande));
             return new JsonResponse($view);
         }
         if ($request->request->get('type') == 'updateArticles'){
             $articleCollection = $request->request->get('articleCollection');
             foreach ($articleCollection as $ac){
                 $article = $em->getRepository('FrontBundle:Detcmd')->findOneBy(['id' => $ac['id']]);
                 $article->setQte($ac['qte']);
                 $em->persist($article);
             }
             $em->flush();
             $id = $request->request->get('commande');
             $commande = $em->getRepository('DashBundle:Commande')->findOneBy(array('id' => $id));
             $view = $this->renderView('@Dash/partials/__dynamicArticlesTableModal.html.twig', array('command' => $commande));
             return new JsonResponse($view);
         }
     }
     $listeCommands = $em->getRepository('DashBundle:Commande')->findAll();
     $commands = $this->get('knp_paginator')->paginate(
       $listeCommands,
       $request->request->get('page',1),
       6
     );
     return $this->render('@Dash/validateur/commands-list.html.twig', array('commands' => $commands));
 }
}
