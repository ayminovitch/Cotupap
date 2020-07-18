<?php


namespace AdminBundle\Controller;


use AdminBundle\Entity\Ads;
use AdminBundle\Form\AdsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdsController extends Controller
{
    public function adsManageAction (){
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository('AdminBundle:Ads')->findAll();
        $ad = new Ads();
        $form = $this->createForm(AdsType::class, $ad);
        return $this->render('@Admin/pages/ads.html.twig', array('uploadForm' => $form->createView(), 'ads' => $ads));
    }
    /**
     * Upload Ads Image(s)
     *
     *
     * @access public
     * @param Request $request
     * @return Object
     **/
    public function uploadInitAction(Request $request)
    {
        $files = $request->files->get('files');
        $alt = $request->request->get('alt');
        $url = $request->request->get('url');

        $uploaded = false;
        $message = null;
        $count = $countValid = 0 ;

//        $mimeTypes = array('jpeg','jpg','png','gif','bmp');

        if(!empty($files))
        {
//            for($count; $count < count($files); $count++)
//            {
//                if(in_array($files->guessClientExtension(), $mimeTypes)){
            $uploaded = $this->uploadExec($files, $alt, $url);
//                }
//                    $countValid++;
//            if($countValid == count($files))
        }

        if($uploaded)
            $message = "All Images have been uploaded & saved!!";
        else
            $message = "Selected File(s) weren't uploaded!!";


        return $this->json(
            [
                'uploaded' => $uploaded,
                'message' => $message
            ]
        );

    }

    /**
     * Performs Actual File Upload
     *
     * @param array $args
     * @return Boolean
     *
     */
    private function uploadExec($args, $alt, $url)
    {
        /**
         * Make sure this is a new product without images saved yet
         */
        $count = 0;
//        $image_files = [];
        $doctrine = $this->getDoctrine()->getManager();

        $uploadDir = $this->getParameter('ads_images_directory') . DIRECTORY_SEPARATOR ;

        if(!is_dir($uploadDir))
        {
            mkdir($uploadDir, 0775, TRUE);
        }

        if(!empty($args))
        {
//            for($count; $count < count($args); $count++)
//            {
            $randomize = rand();
            $filename =  $randomize . '.' . $args->guessClientExtension();

            if(!file_exists($uploadDir . $filename))
            {
                if($args->move($uploadDir, $filename))
                {
                    $image_files['file'] = $filename;
                    $image_files['file_size'] = $args->getClientSize();
                    //$image_files[$count]['file_location'] = $uploadDir;
                }
            }
//                }

//            $jsonEncodeFiles = json_encode($image_files);
            /*
             * Persist Uploaded Image(s) to the Database
             */
            $ads = new Ads();
            $ads->setFiles($image_files['file']);
            $ads->setSize($image_files['file_size']);
            $ads->setDateCreated(strtotime(date('y-m-d h:i:s a')));
            $ads->setAlt($alt);
            $ads->setUrl($url);

            $doctrine->persist($ads);
            $doctrine->flush();

            if( NULL != $ads->getId() )return TRUE;
        }

        return FALSE;
    }

    public function removeAdsAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $ads = $em->getRepository('AdminBundle:Ads')->findOneBy(array('id'=>$request->request->get('id')));
        $em->remove($ads);
        $em->flush();
        return new JsonResponse('Ads removed');
    }
}