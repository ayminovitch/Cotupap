<?php


namespace DashBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CronArticlesReloadController extends Controller
{

    public function cronArticlesAction(){
        //WSDL Connection
//        $localFilePath = $this->container->getParameter('articles_path');
        $fsObject = new Filesystem();
        $current_dir_path = getcwd();
        $xmlresp = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="urn:CSS:CSS"><SOAP-ENV:Body><ns1:getArticles/></SOAP-ENV:Body></SOAP-ENV:Envelope>';
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "SOAPAction: getArticles",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xmlresp),
        );
        $url = '41.224.242.16:8080/wsa/wsa1/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100000000000);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlresp);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        if (!empty($response)){
//            file_put_contents($localFilePath, $response);
            $new_file_path = $current_dir_path . "../../web/uploads/articles.json";

            if (!$fsObject->exists($new_file_path))
            {
                $fsObject->touch($new_file_path);
                $fsObject->chmod($new_file_path, 0777);
                $fsObject->dumpFile($new_file_path, $response);
            }else{
                $fsObject->remove($new_file_path);
                $fsObject->touch($new_file_path);
                $fsObject->chmod($new_file_path, 0777);
                $fsObject->dumpFile($new_file_path, $response);
            }
            return new JsonResponse('Done');
        }
        return new JsonResponse('Empty Response', Response::HTTP_NO_CONTENT);
    }
    public function cronClientsAction(){
        //WSDL Connection
        $fsObject = new Filesystem();
        $current_dir_path = getcwd();
        $xmlresp = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="urn:CSS:CSS"><SOAP-ENV:Body><ns1:getClients/></SOAP-ENV:Body></SOAP-ENV:Envelope>';
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "SOAPAction: getClients",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xmlresp),
        );
        $url = '41.224.242.16:8080/wsa/wsa1/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100000000000);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlresp);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        if (!empty($response)){
//            file_put_contents($localFilePath, $response);
            $new_file_path = $current_dir_path . "../../web/uploads/clients.xml";

            if (!$fsObject->exists($new_file_path))
            {
                $fsObject->touch($new_file_path);
                $fsObject->chmod($new_file_path, 0777);
                $fsObject->dumpFile($new_file_path, $response);
            }else{
                $fsObject->remove($new_file_path);
                $fsObject->touch($new_file_path);
                $fsObject->chmod($new_file_path, 0777);
                $fsObject->dumpFile($new_file_path, $response);
            }
            return new JsonResponse('Done');
        }
        return new JsonResponse('Empty Response', Response::HTTP_NO_CONTENT);
    }
}