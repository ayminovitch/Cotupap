<?php


namespace AdminBundle\Controller;


use AdminBundle\Entity\Settings;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    public function settingsAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $preSettings = $em->getRepository('AdminBundle:Settings')->findOneBy(array('id' => 1));
        if (empty($preSettings)){
            $settings = new Settings();
            $settings->setFacebook('cotupap');
            $settings->setInstagram('cotupap');
            $settings->setMaintenanceMode(false);
            $settings->setNewsletter(true);
            $settings->setSearch(true);
            $settings->setSitedescription('Cotupap Description');
            $settings->setLogo('logo.png');
            $settings->setModal(true);
            $settings->setTwitter('cotupap');
            $settings->setPinterest('Cotupap');
            $settings->setSitekeywords('Cotupap');
            $em->persist($settings);
            $em->flush();
        }
        $settings = $em->getRepository('AdminBundle:Settings')->findOneBy(array('id' => 1));
        if ($request->isMethod('POST')){
            $data = $request->request;
            $conditionGeneral = $request->files->get('conditionGeneral');
//            Les Modules
            $settings->setNewsletter($data->get('newsletter') == 'on' ? 'true': 'false');
            $settings->setModal($data->get('modal') == 'on' ? 'true': 'false');
            $settings->setSearch($data->get('search') == 'on' ? 'true': 'false');
            $settings->setMaintenanceMode($data->get('maintenance') == 'on' ? 'true': 'false');
            //Les Reseaux
            $settings->setFacebook($data->get('facebook'));
            $settings->setTwitter($data->get('twitter'));
            $settings->setInstagram($data->get('instagram'));
            $settings->setPinterest($data->get('pinterest'));
            //Les autres params
            $settings->setPhone($data->get('phone'));
            $settings->setFax($data->get('fax'));
            $settings->setCopyright($data->get('copyright'));
            if(!is_null($conditionGeneral)){
                // generate a random name for the file but keep the extension
                $filename = uniqid().".".$conditionGeneral->getClientOriginalExtension();
                $path = $this->getParameter('general_upload_directory');
                $conditionGeneral->move($path,$filename); // move the file to a path
                $settings->setCg($filename);
            }

            $em->persist($settings);
            $em->flush();
            return new JsonResponse(array('data' =>$data, 'status' => 'success'));
        }
        return $this->render('@Admin/pages/settings.html.twig', array('parameters' => $settings));
    }
    public function globalParamsAction(Request $request){

    }
}