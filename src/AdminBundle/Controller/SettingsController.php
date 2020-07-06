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
            $data = $request->request->get('data');
            //Les Modules
            $settings->setNewsletter($data['newsletter']);
            $settings->setModal($data['modal']);
            $settings->setSearch($data['search']);
            $settings->setMaintenanceMode($data['maintenance']);
            //Les Reseaux
            $settings->setFacebook($data['facebook']);
            $settings->setTwitter($data['twitter']);
            $settings->setInstagram($data['instagram']);
            $settings->setPinterest($data['pinterest']);

            $em->persist($settings);
            $em->flush();
            return new JsonResponse(array('data' =>$data, 'status' => 'success'));
        }
        return $this->render('@Admin/pages/settings.html.twig', array('parameters' => $settings));
    }

    public function globalParamsAction(Request $request){

    }
}