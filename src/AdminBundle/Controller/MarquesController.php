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
        $frontShow = $request->request->get('front-show');

        $uploaded = false;
        $message = null;
        $count = $countValid = 0 ;

//        $mimeTypes = array('jpeg','jpg','png','gif','bmp');

//        if(!empty($files))
//        {
            $uploaded = $this->uploadExec($files, $alt, $name, $ref, $frontShow);
//        }

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
    private function uploadExec($args, $alt, $name, $ref, $front)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $marques = new Marques();
        $uploadDir = $this->getParameter('marques_images_directory') . DIRECTORY_SEPARATOR ;
        if(!is_dir($uploadDir))
        {
            mkdir($uploadDir, 0775, TRUE);
        }

        if(!empty($args))
        {
            $randomize = rand();
            $filename =  $randomize . '.' . $args->guessClientExtension();
            if(!file_exists($uploadDir . $filename))
            {
                if($args->move($uploadDir, $filename))
                {
                    $image_files['file'] = $filename;
                    $image_files['file_size'] = $args->getClientSize();
                }
            }
            $marques->setFiles($image_files['file']);
            $marques->setSize($image_files['file_size']);
        }
            $marques->setAlt($alt);
            $marques->setName($name);
            $marques->setRef($ref);
            $marques->setFront($front == null? 0 : 1);

            $doctrine->persist($marques);
            $doctrine->flush();

            if( NULL != $marques->getId() )return TRUE;

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