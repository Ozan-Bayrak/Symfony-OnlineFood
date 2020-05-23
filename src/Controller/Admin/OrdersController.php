<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Orders;
use App\Form\Admin\OrdersType;
use App\Repository\Admin\OrdersRepository;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="admin_orders_index", methods={"GET"})
     */
    public function index(ordersRepository $ordersRepository): Response
    {
        return $this->render('admin/orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="admin_orders_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id,FoodRepository $foodRepository,ordersRepository $ordersRepository): Response
    {
        $orderss=$ordersRepository->findBy(['foodid'=>$id]);
        $food=$foodRepository->findOneBy(['id'=>$id]);
        // echo $food->getTitle();
        $orders = new orders();
        $form = $this->createForm(ordersType::class, $orders);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //******File upload*******\\
            $file = $form['image']->getData();
            if ($file){
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){

                }
                $orders->setImage($fileName);
            }
            //******File upload*******\\
            $orders->setFoodid($food->getId());
            $entityManager->persist($orders);
            $entityManager->flush();

            return $this->redirectToRoute('admin_orders_new',['id'=> $id]);
        }

        return $this->render('admin/orders/new.html.twig', [
            'food' => $food,
            'orders' => $orders,
            'orderss'=>$orderss,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_orders_show", methods={"GET"})
     */
    public function show(orders $orders): Response
    {
        return $this->render('admin/orders/show.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/{id}/edit/{fid}", name="admin_orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,$fid, orders $orders): Response
    {
        $form = $this->createForm(ordersType::class, $orders);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file){
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){

                }
                $orders->setImage($fileName);
            }
            //******File upload*******\\
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_orders_new',['id'=> $fid]);
        }

        return $this->render('admin/orders/edit.html.twig', [
            'orders' => $orders,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{fid}", name="admin_orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request,$fid, orders $orders): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orders->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orders);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_orders_new',['id'=> $fid]);
    }
    private function generateUniqueFileName(){
        return md5(uniqid());
    }
}
