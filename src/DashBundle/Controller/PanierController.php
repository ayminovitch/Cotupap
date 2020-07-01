<?php


namespace DashBundle\Controller;


use DashBundle\Entity\Client;
use DashBundle\Entity\Commande;
use FrontBundle\Entity\Detcmd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function panierAction(Request $request){
        $session = $request->getSession();
        if (!($session->has('panier'))){
            $session->set('panier', []);
        }
        $panier = $session->get('panier');
        $nbrItems = count($panier);
        $sumprod = 0;
        foreach ($panier as $element){
            $tmprice = $element['prix'] * $element['qte'];
            $sumprod += $tmprice;
        }
        dump($panier);
        $livraison = 20;
        return $this->render('@Front/pages/panier.html.twig', array('items'=>$panier, 'nbrItems' => $nbrItems, 'somme'=>$sumprod, 'livraison' => $livraison, 'total' => $sumprod + $livraison));
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
        return $this->render('@Dash/partials/top-basket.html.twig', array('items'=>$panier, 'nbrItems' => $nbrItems, 'status'=>$status));
    }

    public function panierTopHeaderAddProductAction(Request $request){
        //Guard Clause
        if (!($request->isMethod('POST'))){
            return new JsonResponse('Request Problem');
        }
        //Initialisation Session
        $session = $request->getSession();
        if (!($session->has('panier'))){
            $session->set('panier', []);
        }
        $panier = $session->get('panier');
        $action = $request->request->get('action');
        $reference = $request->request->get('reference');

        //Parcourir Session
        foreach ($panier as $key => $value){
            if (array_key_exists('reference', $value)){
                if ($value['reference'] == $reference){
                    if ($action == 'delete'){
                        unset($panier[$key]);
                        $session->set('panier', $panier);
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
                        $content = $this->renderView('@Front/partials/elements/top-basket.html.twig', array('items'=>$panier, 'nbrItems' => $nbrItems, 'status'=>$status, 'somme'=>$somme));
                        return new JsonResponse($content);
                    }
                    return new JsonResponse(array('status' => 'Done'), 200);
                }
            }
        }
        $item = [
                'name' => $request->get('name'),
                'reference' => $reference,
                'prix' => $request->get('prix'),
                'qte' => $request->get('qte'),
                'totalSingle' => $request->get('prix') * $request->get('qte'),
        ];
        $panier[] = $item;
        $session->set('panier', $panier);
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
        $content = $this->renderView('@Front/partials/elements/top-basket.html.twig', array('items'=>$panier, 'nbrItems' => $nbrItems, 'status'=>$status, 'somme'=>$somme));
        return new JsonResponse($content);
    }

    //This Action Dedicated for Confirm Button
    public function invoicePanierAction (Request $request) {
        //Guard Clause
        if (!($request->isMethod('POST'))){
            return $this->redirectToRoute('dash_homepage');
        }
        //Initialisation Basic Stuff
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        if (!($session->has('client'))){
            $session->set('client', []);
        }
        if (!($session->has('panier'))){
            return $this->redirectToRoute('dash_homepage');
        }
        $panier = $session->get('panier');
        $frmArray = [
            'name'   => $request->get('name'),
            'shipping'   => $request->get('shipping'),
            'phone'  => $request->get('phone'),
            'mf'     => $request->get('mf')
        ];

        //get Client from session
        //get Client form to persist on the db
        $verifClient = $em->getRepository('DashBundle:Client')->findOneBy(array('mfiscal'=> $frmArray['mf']));
        if (empty($verifClient)){
            $newClientDB = new Client();
            $newClientDB->setFullname($frmArray['name']);
            $newClientDB->setAddresse($frmArray['shipping']);
            $newClientDB->setPhone($frmArray['phone']);
            $newClientDB->setMfiscal($frmArray['mf']);
            $em->persist($newClientDB);
            $em->flush();
            $verifClient = $newClientDB;
        }
        $commande = new Commande();
        $commande->setStatus('En Attente');
        $commande->setClient($verifClient);
        $commande->setDcr(new \DateTime());
        foreach ($panier as $key => $value) {
            $articles = new Detcmd();
            $articles->setCommande($commande);
            $articles->setArticle($value['reference']);
            $articles->setPrice($value['prix']);
            $articles->setQte($value['qte']);
            $articles->setTotalprice($value['totalSingle']);
        }
        $em->persist($articles);
        $em->persist($commande);
        $em->flush();
        //send email

        //show invoice page
        $somme = 0;
        foreach ($panier as $keyz => $valuez) {
            $singleArticlePrice = $panier[$keyz]['qte'] * $panier[$keyz]['prix'];
            $somme += $singleArticlePrice;
        }
        $livraison = 20;
        $total = $livraison + $somme;
        $session->clear();
        $viewResult = $this->renderView('@Dash/pages/commerce/invoice.html.twig', array('items' => $panier, 'total' => $total, 'somme' => $somme, 'livraison' => $livraison, 'client' => $frmArray));
        return new JsonResponse($viewResult);
    }

    public function orderListAction (Request $request) {
        $em = $this->getDoctrine()->getManager();
        $commands = $em->getRepository(Commande::class)->findAll();
        return $this->render('@Dash/pages/commerce/order-list.html.twig', array('commands' => $commands));
    }

    public function updateQteArticleAction(Request $request){
        //Guard Clause
        if (!($request->isMethod('POST'))){
            return new JsonResponse('Request Problem');
        }
        //Initialisation Session
        $session = $request->getSession();
        if (!($session->has('panier'))){
            $session->set('panier', []);
        }
        $panier = $session->get('panier');
        $action = $request->request->get('action');
        $paner = $request->get('objects');
        if ($action == 'update') {
        foreach ($panier as $key => $value) {
            if (array_key_exists('reference', $value)) {
                    foreach ($paner as $keya => $valuea) {
                        if ($value['reference'] == $valuea['ref']) {
                            $panier[$key]['qte'] = $valuea['qte'];
                            if (!empty($valuea['qte'])) {
                                $panier[$key]['totalSingle'] = $value['prix'] * $valuea['qte'];
                            }
                        }
                    }
                }
            }
            $session->set('panier', $panier);
            $panier = $session->get('panier');
            $somme = 0;
            foreach ($panier as $keyz => $valuez) {
                $singleArticlePrice = $panier[$keyz]['qte'] * $panier[$keyz]['prix'];
                $somme += $singleArticlePrice;
            }
            $livraison = 20;
            $total = $livraison + $somme;
            $content = $this->renderView('@Front/partials/elements/dynamicBlockPanier.html.twig', array('items' => $panier, 'total' => $total, 'somme' => $somme, 'livraison' => $livraison));
            return new JsonResponse($content);
        }
        return new JsonResponse('not updated');
    }
}