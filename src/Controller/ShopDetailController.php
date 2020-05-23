<?php

namespace App\Controller;

use App\Entity\ShopDetail;
use App\Form\ShopDetailType;
use App\Repository\ShopDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shop/detail")
 */
class ShopDetailController extends AbstractController
{
    /**
     * @Route("/", name="shop_detail_index", methods={"GET"})
     */
    public function index(ShopDetailRepository $shopDetailRepository): Response
    {
        return $this->render('shop_detail/index.html.twig', [
            'shop_details' => $shopDetailRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shop_detail_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shopDetail = new ShopDetail();
        $form = $this->createForm(ShopDetailType::class, $shopDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shopDetail);
            $entityManager->flush();

            return $this->redirectToRoute('shop_detail_index');
        }

        return $this->render('shop_detail/new.html.twig', [
            'shop_detail' => $shopDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_detail_show", methods={"GET"})
     */
    public function show(ShopDetail $shopDetail): Response
    {
        return $this->render('shop_detail/show.html.twig', [
            'shop_detail' => $shopDetail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shop_detail_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShopDetail $shopDetail): Response
    {
        $form = $this->createForm(ShopDetailType::class, $shopDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_detail_index');
        }

        return $this->render('shop_detail/edit.html.twig', [
            'shop_detail' => $shopDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_detail_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ShopDetail $shopDetail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shopDetail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shopDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shop_detail_index');
    }
}
