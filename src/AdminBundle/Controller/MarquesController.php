<?php


namespace AdminBundle\Controller;


use AdminBundle\Entity\Marques;
use AdminBundle\Form\MarquesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class MarquesController extends Controller
{
    public function marquesManageAction (){
        $em = $this->getDoctrine()->getManager();
        $marques = $em->getRepository('AdminBundle:Marques')->findAll();
        $marque = new Marques();
        $form = $this->createForm(MarquesType::class, $marque);
        return $this->render('@Admin/pages/marques.html.twig', array('uploadForm' => $form->createView(), 'marques' => $marques));
    }
    /**
     * Upload Marques Image(s)
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
        $ref = $request->request->get('ref');
        $name = $request->request->get('name');

        $uploaded = false;
        $message = null;
        $count = $countValid = 0 ;

//        $mimeTypes = array('jpeg','jpg','png','gif','bmp');

        if(!empty($files))
        {
//            for($count; $count < count($files); $count++)
//            {
//                if(in_array($files->guessClientExtension(), $mimeTypes)){
            $uploaded = $this->uploadExec($files, $alt, $name, $ref);
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
    private function uploadExec($args, $alt, $name, $ref)
    {
        /**
         * Make sure this is a new product without images saved yet
         */
        $count = 0;
//        $image_files = [];
        $doctrine = $this->getDoctrine()->getManager();

        $uploadDir = $this->getParameter('marques_images_directory') . DIRECTORY_SEPARATOR ;

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
            $marques = new Marques();
            $marques->setFiles($image_files['file']);
            $marques->setSize($image_files['file_size']);
            $marques->setAlt($alt);
            $marques->setName($name);
            $marques->setRef($ref);

            $doctrine->persist($marques);
            $doctrine->flush();

            if( NULL != $marques->getId() )return TRUE;
        }

        return FALSE;
    }

    public function removeMarquesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $marques = $em->getRepository('AdminBundle:Marques')->findOneBy(array('id'=>$request->request->get('id')));
        $em->remove($marques);
        $em->flush();
        return new JsonResponse('Marques removed');
    }
}