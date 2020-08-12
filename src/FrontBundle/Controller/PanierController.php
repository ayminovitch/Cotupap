<?php


namespace FrontBundle\Controller;


use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function panierAction(Request $request){
        return $this->render('@Front/pages/panier.html.twig');
    }

    //Generate pdf invoice on demande for single commande

    public function generatePdfInvoiceAction(Request $request){
//        if ($request->isMethod('POST')){
            $commandId = $request->query->get('id');
            $em = $this->getDoctrine()->getRepository('DashBundle:Commande');
            $command = $em->findOneBy(array('id'=> $commandId));
            $twig = clone $this->get('twig');
            $twig->setLoader(new \Twig_Loader_String());
            $image = $twig->render(
            '{{ app.request.getSchemeAndHttpHost ~ asset("assets/FrontBundle/images/logo.png") }}'
            );
            $view = $this->renderView('@Front/partials/__pdf_invoice.html.twig', array('command' => $command, 'logo' => ''));
            return new PdfResponse(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($view),
                'facture'.$command->getId().'.pdf'
            );
        }
//    }
}