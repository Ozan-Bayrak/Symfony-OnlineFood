<?php

namespace App\Controller\Admin;

use App\Entity\Admin\OrderDetails;
use App\Entity\Shop;
use App\Form\Admin\OrderDetailsType;
use App\Repository\ShopDetailRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class adminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_admin")
     */
    public function index()
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'adminController',
        ]);
    }
    /**
     * @Route("admin/shop/{slug}", name="admin_shop_index")
     */
    public function shop($slug,ShopRepository $shopRepository)
    {
        $shop = $shopRepository->findBy(['status'=>$slug]);

        return $this->render('admin/shop/index.html.twig', [
            'shop'=>$shop,
        ]);
    }

    /**
     * @Route("admin/shop/show/{id}", name="admin_shop_show",methods={"GET"})
     */
    public function show($id,Shop $shop,ShopDetailRepository $shopDetailRepository):Response
    {
        $shopdetail=$shopDetailRepository->findBy(['shopid'=>$id]);

        return $this->render('admin/shop/show.html.twig', [
            'shopdetail'=>$shopdetail,
            'shop'=>$shop,
        ]);
    }

    /**
     * @Route("admin/shop/{id}/update", name="admin_shop_update",methods={"POST"})
     */
    public function shop_update($id,Request $request, Shop $shop):Response
    {

        $em = $this->getDoctrine()->getManager();
        $sql = "UPDATE shop SET note=:note,status=:status WHERE id=:id";
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('note',$request->request->get('note'));
        $statement->bindValue('status',$request->request->get('status'));
        $statement->bindValue('id',$id);
        $statement->execute();

        return $this->redirectToRoute('admin_shop_show',array('id'=>$id));
    }

}
