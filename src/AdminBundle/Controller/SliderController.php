<?php


namespace AdminBundle\Controller;


use AdminBundle\Entity\Slider;
use AdminBundle\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SliderController extends Controller
{
    public function sliderManageAction (){
        $em = $this->getDoctrine()->getManager();
        $sliders = $em->getRepository('AdminBundle:Slider')->findAll();
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        return $this->render('@Admin/pages/slider.html.twig', array('uploadForm' => $form->createView(), 'sliders' => $sliders));
    }
    /**
     * Upload Product Image(s)
     *
     *
     * @access public
     * @param Request $request
     * @return Object
     **/
    public function uploadInitAction(Request $request)
    {
        $files = $request->files->get('files');

        $uploaded = false;
        $message = null;
        $count = $countValid = 0 ;

//        $mimeTypes = array('jpeg','jpg','png','gif','bmp');

        if(!empty($files))
        {
//            for($count; $count < count($files); $count++)
//            {
//                if(in_array($files->guessClientExtension(), $mimeTypes)){
                    $uploaded = $this->uploadExec($files);
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
    private function uploadExec($args)
    {
        /**
         * Make sure this is a new product without images saved yet
         */
        $count = 0;
//        $image_files = [];
        $doctrine = $this->getDoctrine()->getManager();

        $uploadDir = $this->getParameter('products_images_directory') . DIRECTORY_SEPARATOR ;

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
            $slider = new Slider();
            $slider->setFiles($image_files['file']);
            $slider->setSize($image_files['file_size']);
            $slider->setDateCreated(strtotime(date('y-m-d h:i:s a')));

            $doctrine->persist($slider);
            $doctrine->flush();

            if( NULL != $slider->getId() )return TRUE;
        }

        return FALSE;
    }

    public function removeSliderAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $sliders = $em->getRepository('AdminBundle:Slider')->findOneBy(array('id'=>$request->request->get('id')));
        $em->remove($sliders);
        $em->flush();
        return new JsonResponse('slider removed');
    }
}