<?php


namespace DashBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use DashBundle\Controller\CronArticlesReloadController;

class AuthController extends Controller
{
    public function loginAction(Request $request){
        if (($request->isMethod('POST'))){
            $em = $this->getDoctrine()->getManager();
            $clients = $em->getRepository('DashBundle:Client');
            $login = $request->get('login');
            $pass = $request->get('pass');
            $clientO = $clients->findOneBy(array('codeClient' => $login));
            $session = $request->getSession();
            if (!($session->has('client'))){
                $session->set('client', []);
            }

            //check If client Exist
            if (empty($clientO)){
                return new JsonResponse('Account Not Exist');
            }elseif ($clientO->getPassword() != $pass){
                return new JsonResponse('Wrong Password');
            }

            $authClient = array();
            $frmArray = [
                'status' =>'in',
                'tclient'   => $clientO->getCodeClient(),
                'tnom'   => $clientO->getFullname(),
                'tadresse'   => $clientO->getAddresse(),
                'tphone'  => $clientO->getPhone(),
                'tfax'  => $clientO->getFax(),
                'tmatFiscale' => $clientO->getMfiscal(),
                'password' => $clientO->getPassword(),
                'verification' => $clientO->getVerified()
            ];
            $session->set('client', $frmArray);
            $client = $session->get('client');
            return new JsonResponse($client);
        }
        return $this->render('@Front/pages/login.html.twig');
    }

    public function logoutAction(Request $request){
        $session = $request->getSession();
        $session->clear();
//        $session->set('client', ['status'=> 'out']);
        return $this->redirectToRoute('dash_homepage');
    }

    public function refreshClientsAction(Request $request){
        //Update Local Client File with new one
        $cronController = $this->get('reload_clients_from_soap');
        $cronController->cronClientsAction();
        //Get Article List From File And Convert From XML To Json Array
        $xmlfile = file_get_contents(dirname($this->get('kernel')->getRootDir()).'/web/uploads/clients.xml');
        $response1 = str_replace("<SOAP-ENV:Body>", "", $xmlfile);
        $response2 = str_replace("</SOAP-ENV:Body>", "", $response1);
        $jsonArray = json_decode(json_encode(simplexml_load_string($response2)), true)['getClientsResponse']['ttclients']['ttclientsRow'];
        $em = $this->getDoctrine()->getManager();
        $element = $em->getRepository('DashBundle:Client');
        $counter = 0;
        foreach ($jsonArray as $row){
            if (empty($element->findOneBy(array('codeClient' => print_r($row['tclient'], true))))){
                $client = new \DashBundle\Entity\Client();
                $client->setCodeClient(empty($row['tclient'])?null:print_r($row['tclient'], true));
                $client->setAddresse(empty($row['tadresse']) || $row['tadresse'][0] == ' '?null:print_r($row['tadresse'], true));
                $client->setPhone(empty($row['tphone'])?null:print_r($row['tphone'], true));
                $client->setFax(empty($row['tfax'])?null:print_r($row['tfax'], true));
                $client->setFullname(empty($row['tnom'])?null:print_r($row['tnom'], true));
                $client->setVerified(0);
                $client->setPassword($this->randomPassword());
                $em->persist($client);
                $counter +=1;
            }
        }
        $em->flush();
        return new JsonResponse($counter.' Client ajouté à la base de données');
    }
    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function getClientsAction(){
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('DashBundle:Client')->findAll();
        return new JsonResponse($clients);
    }

    public function changeClientPasswordAction(Request $request){
        if ($request->isMethod('POST')){
            $password = $request->request->get('password');
            $client = $request->request->get('client');
            $em = $this->getDoctrine()->getManager();
            $clientObj = $em->getRepository('DashBundle:Client')->findOneBy(array('codeClient' => $client));
            $clientObj->setPassword($password);
            $em->persist($clientObj);
            $em->flush();
            return new JsonResponse('Password Changed');
        }
    }

    public function getSingleClientAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $clientReq  = $request->request->get('client');
        $client = $em->getRepository('DashBundle:Client')->findOneBy(array('codeClient' => $clientReq));
        return new JsonResponse($client);
    }
}