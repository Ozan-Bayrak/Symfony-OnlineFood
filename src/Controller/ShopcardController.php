<?php

namespace App\Controller;

use App\Entity\Shopcard;
use App\Form\ShopcardType;
use App\Repository\ShopcardRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopcard")
 */
class ShopcardController extends AbstractController
{
    /**
     * @Route("/", name="shopcard_index", methods={"GET"})
     */
    public function index(ShopcardRepository $shopcardRepository): Response
    {
        $user = $this->getUser();
        //dump($user);
        //die();
        $shopcard=$shopcardRepository->getShopcard($user->getId());

        return $this->render('shopcard/index.html.twig', [
            'shopcard'=>$shopcard,
        ]);
    }

    /**
     * @Route("/new", name="shopcard_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shopcard = new Shopcard();
        $form = $this->createForm(ShopcardType::class, $shopcard);
        $form->handleRequest($request);

        if  ($this->isCsrfTokenValid('add-item', $request->request->get('token'))) {

            if ($form->isSubmitted()){
                $entityManager = $this->getDoctrine()->getManager();
                $user = $this->getUser();

                $shopcard->setUserid($user->getid());

                $entityManager->persist($shopcard);
                $entityManager->flush();

                return $this->redirectToRoute('shopcard_index');
            }
        }
            return $this->render('shopcard/new.html.twig', [
                'shopcard' => $shopcard,
                'form' => $form->createView(),
            ]);

    }

    /**
     * @Route("/{id}", name="shopcard_show", methods={"GET"})
     */
    public function show(Shopcard $shopcard): Response
    {
        return $this->render('shopcard/show.html.twig', [
            'shopcard' => $shopcard,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shopcard_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shopcard $shopcard): Response
    {
        $form = $this->createForm(ShopcardType::class, $shopcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shopcard_index');
        }

        return $this->render('shopcard/edit.html.twig', [
            'shopcard' => $shopcard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopcard_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Shopcard $shopcard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shopcard->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shopcard);
            $entityManager->flush();
        }
        return $this->redirectToRoute('shopcard_index');

    }
}
