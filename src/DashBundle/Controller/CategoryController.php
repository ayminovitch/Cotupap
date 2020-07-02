<?php


namespace DashBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    //Dedicated For Client Dash
    public function indexAction(){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $categorys = $em->findBy(array('parent' => 0));
        return $this->render('@Front/pages/index.html.twig', array('cats' => $categorys));
    }

    public function tableInsideCategoryAction($id){
        return $this->render('@Dash/pages/product/product-list.html.twig', array('id' => $id));
    }

    public function categoryAction($id){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $category = $em->findBy(array('parent' => $id));
        $heading = $em->findBy(array('id' => $id));
        if (empty($category)){
            return $this->redirectToRoute('category_product_result', array('id' => $id));
        }
        return $this->render('@Dash/pages/categorys/single-category.html.twig', array('categorys' => $category, 'heading' => $heading));
    }

    //Dedicated For Admin Dash
    public function adminCategoryListAction($id){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $category = $em->findBy(array('parent' => $id));
        $heading = $em->findBy(array('id' => $id));
        return $this->render('@Dash/pages/categorys/single-category.html.twig', array('categorys' => $category, 'heading' => $heading));
    }
    public function adminCategoryAddAction($id){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $category = $em->findBy(array('parent' => $id));
        $heading = $em->findBy(array('id' => $id));
        return $this->render('@Dash/pages/categorys/single-category.html.twig', array('categorys' => $category, 'heading' => $heading));
    }
    public function adminCategoryEditAction($id){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $category = $em->findBy(array('parent' => $id));
        $heading = $em->findBy(array('id' => $id));
        return $this->render('@Dash/pages/categorys/single-category.html.twig', array('categorys' => $category, 'heading' => $heading));
    }
    public function adminCategoryDeleteAction($id){
        $em = $this->getDoctrine()->getManager()->getRepository('DashBundle:Category');
        $category = $em->findBy(array('parent' => $id));
        $heading = $em->findBy(array('id' => $id));
        return $this->render('@Dash/pages/categorys/single-category.html.twig', array('categorys' => $category, 'heading' => $heading));
    }
}
