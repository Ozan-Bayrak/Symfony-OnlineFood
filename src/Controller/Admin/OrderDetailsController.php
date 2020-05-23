<?php

namespace App\Controller\Admin;

use App\Entity\Admin\OrderDetails;
use App\Entity\ShopDetail;
use App\Form\Admin\OrderDetailsType;
use App\Repository\Admin\OrderDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order/details")
 */
class OrderDetailsController extends AbstractController
{
    /**
     * @Route("/{slug}", name="admin_order_details_index", methods={"GET"})
     */
    public function index($slug,OrderDetailsRepository $orderDetailsRepository): Response
    {
        $orderDetails=$orderDetailsRepository->getUserOrderss($slug);
        return $this->render('admin/order_details/index.html.twig', [
            'order_details' => $orderDetails,
        ]);
    }

    /**
     * @Route("/new", name="admin_order_details_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderDetail = new OrderDetails();
        $form = $this->createForm(OrderDetailsType::class, $orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderDetail);
            $entityManager->flush();

            return $this->redirectToRoute('admin_order_details_index');
        }

        return $this->render('admin/order_details/new.html.twig', [
            'order_detail' => $orderDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="admin_order_details_show", methods={"GET"})
     */
    public function show($id, OrderDetailsRepository $orderDetailsRepository): Response
    {
        $orderDetail=$orderDetailsRepository->getUserOrders($id);
        return $this->render('admin/order_details/show.html.twig', [
            'order_detail' => $orderDetail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_shop_details_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShopDetail $shopDetail): Response
    {
        $form = $this->createForm(OrderDetailsType::class, $orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $status = $form['status']->getData();

            return $this->redirectToRoute('admin_order_details_index',['slug'=>$status]);
        }

        return $this->render('admin/order_details/edit.html.twig', [
            'order_detail' => $orderDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_order_details_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderDetails $orderDetail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderDetail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_order_details_index');
    }
}
