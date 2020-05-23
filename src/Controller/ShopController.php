<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Entity\ShopDetail;
use App\Form\ShopType;
use App\Repository\ShopcardRepository;
use App\Repository\ShopDetailRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shop")
 */
class ShopController extends AbstractController
{
    /**
     * @Route("/", name="shop_index", methods={"GET"})
     */
    public function index(ShopRepository $shopRepository): Response
    {
        $user = $this->getUser();
        $userid = $user->getid();

        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findBy(['userid'=> $userid],['id'=>'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="shop_new", methods={"GET","POST"})
     */
    public function new(Request $request, ShopcardRepository $shopcardRepository): Response
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        $user = $this->getUser(); //calling Login user data
        $userid = $user->getid();

        $name=$user->getname();
        $surname=$user->getsurname();
        $adress=$user->getadress();
        $phone=$user->getphone();

        $total = $shopcardRepository->getUserShopCartTotal($userid);


        if ($this->isCsrfTokenValid('form-shop', $request->request->get('token'))) {
            if ($form->isSubmitted()) {
                $entityManager = $this->getDoctrine()->getManager();

                $shop->setUserid($userid);
                $shop->setName($name);
                $shop->setSurname($surname);
                $shop->setAdress($adress);
                $shop->setPhone($phone);
                $shop->setAmount($total);
                $shop->setStatus("new");
                $shop->setCreatedAt(new \DateTime());

                $entityManager->persist($shop);
                $entityManager->flush();

                $shopid = $shop->getId(); // get last insert shop data id
                $shopcard = $shopcardRepository->getShopcard($userid);

                foreach ($shopcard as $item){

                    $shopdetail = new ShopDetail();

                    $shopdetail->setShopid($shopid);
                    $shopdetail->setUserid($user->getid());
                    $shopdetail->setOrdersid($item["ordersid"]);
                    $shopdetail->setPrice($item["price"]);
                    $shopdetail->setQuantity($item["quantity"]);
                    $shopdetail->setAmount($item["total"]);
                    $shopdetail->setName($item["food"]);
                    $shopdetail->setStatus("Ordered");
                    $shopdetail->setRestauran($item["rname"]);
                    $shopdetail->setCreatedAt((new\DateTime()));

                    $entityManager->persist($shopdetail);
                    $entityManager->flush();
                }
                $entityManager = $this->getDoctrine()->getManager();
                $query = $entityManager->createQuery('DELETE FROM App\Entity\Shopcard s WHERE s.userid=:userid
                ')
                    ->setParameter('userid',$userid);
                $query->execute();

                return $this->redirectToRoute('shop_index');
            }
        }
        return $this->render('shop/new.html.twig', [
            'shop' => $shop,
            'total'=>$total,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_show", methods={"GET"})
     */
    public function show(Shop $shop,ShopDetailRepository $shopDetailRepository): Response
    {
        $user = $this->getUser();
        $userid = $user->getid();
        $shopid =$shop->getId();

        $shopdetail=$shopDetailRepository->findBy(['shopid'=> $shopid]);

        return $this->render('shop/show.html.twig', [
            'shop' => $shop,
            'shopdetail'=>$shopdetail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shop_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shop $shop): Response
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_index');
        }

        return $this->render('shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Shop $shop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shop->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shop_index');
    }
}
