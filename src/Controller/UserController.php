<?php

namespace App\Controller;

use App\Entity\Admin\Comment;
use App\Entity\Admin\OrderDetails;
use App\Entity\User;
use App\Form\Admin\CommentType;
use App\Form\Admin\OrderDetailsType;
use App\Form\UserType;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\OrderDetailsRepository;
use App\Repository\Admin\OrdersRepository;
use App\Repository\FoodRepository;
use App\Repository\ShopcardRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('user/show.html.twig');
    }

    /**
     * @Route("/comment", name="user_comment", methods={"GET"})
     */
    public function comment(CommentRepository $commentRepository): Response
    {
        $user = $this->getUser();
        $comments=$commentRepository->getAllCommentsUser($user->getId());

        return $this->render('user/comment.html.twig',[
            'comments'=>$comments,
        ]);

    }

    /**
     * @Route("/orders", name="user_orders", methods={"GET"})
     */
    public function orders(OrderDetailsRepository $orderDetailsRepository): Response
    {
        $user = $this->getUser();
        //$orders=$orderDetailsRepository->findBy(['userid'=>$user->getId()]);
        $orders=$orderDetailsRepository->getUserOrders($user->getId());
        return $this->render('user/orders.html.twig', [
            'orders'=>$orders,
            ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
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
                $user->setImage($fileName);
            }
            //******File upload*******\\
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, $id, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        if ($user -> getId() != '$id'){
            return $this->redirectToRoute('home');
        }


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
                $user->setImage($fileName);
            }
            //******File upload*******\\
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
    private function generateUniqueFileName(){
        return md5(uniqid());
    }
    /**
     * @Route("/newcomment/{id}", name="user_new_comment", methods={"GET","POST"})
     */
    public function newcomment(Request $request, $id): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');

        if ($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('comment', $submittedToken)) {
                $entityManager = $this->getDoctrine()->getManager();
                $comment->setStatus('new');
                $comment->setIp($_SERVER['REMOTE_ADDR']);
                $comment->setFoodid($id);
                $user = $this->getUser();
                $comment->setUserid($user->getId());
                $comment->setCreatedAt(new\DateTime());

                $entityManager->persist($comment);
                $entityManager->flush();

                $this->addFlash('success','Your Comment has been sent successfully');
                return $this->redirectToRoute('food_show', ['id' => $id]);
            }
        }

        return $this->redirectToRoute('food_show', ['id'=> $id]);
    }
    /**
     * @Route("/orderDetails/{fid}/{oid}", name="user_order_details_new", methods={"GET","POST"})
     */
    public function neworderDetails(Request $request,$fid,$oid,FoodRepository $foodRepository,OrdersRepository $ordersRepository): Response
    {
        $amount=$_REQUEST["amount"];

        $food=$foodRepository->findOneBy(['id'=>$fid]);
        $orders=$ordersRepository->findOneBy(['id'=>$oid]);
        $total=$amount * $orders->getPrice();
        //echo $total;
        //die();


        $orderDetail = new OrderDetails();
        $form = $this->createForm(OrderDetailsType::class, $orderDetail);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');

        if ($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('form-order_details', $submittedToken)) {
                $entityManager = $this->getDoctrine()->getManager();

                $orderDetail->setStatus('new');
                $orderDetail->setIp($_SERVER['REMOTE_ADDR']);
                $orderDetail->setFoodid($fid);
                $orderDetail->setOrdersid($oid);
                $user = $this->getUser();
                $orderDetail->setUserid($user->getId());
                $orderDetail->setAmount($amount);
                $orderDetail->setTotal($total);
                $orderDetail->setCreatedAt(new\DateTime());
                $entityManager->persist($orderDetail);
                $entityManager->flush();

                return $this->redirectToRoute('user_orders');
            }
        }

        return $this->render('user/neworder_details.html.twig', [
            'order_detail' => $orderDetail,
            'food' => $food,
            'orders' => $orders,
            'total' => $total,
            'amount' => $amount,
            'form' => $form->createView(),
        ]);
    }
}
