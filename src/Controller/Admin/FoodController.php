<?php

namespace App\Controller\Admin;

use App\Entity\Food;
use App\Form\FoodType;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/food")
 */
class FoodController extends AbstractController
{
    /**
     * @Route("/", name="admin_food_index", methods={"GET"})
     */
    public function index(FoodRepository $foodRepository): Response
    {
        $foods=$foodRepository->getAllFoods();
        return $this->render('admin/food/index.html.twig', [
            'foods' => $foods,
        ]);
    }

    /**
     * @Route("/new", name="admin_food_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $food = new Food();
        $form = $this->createForm(FoodType::class, $food);
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
                $food->setImage($fileName);
            }
            //******File upload*******\\
            $entityManager->persist($food);
            $entityManager->flush();

            return $this->redirectToRoute('admin_food_index');
        }

        return $this->render('admin/food/new.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_food_show", methods={"GET"})
     */
    public function show(Food $food): Response
    {
        return $this->render('admin/food/show.html.twig', [
            'food' => $food,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_food_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Food $food): Response
    {
        $form = $this->createForm(FoodType::class, $food);
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
                $food->setImage($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_food_index');
        }

        return $this->render('admin/food/edit.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
        ]);
    }
    private function generateUniqueFileName(){
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="admin_food_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Food $food): Response
    {
        if ($this->isCsrfTokenValid('delete'.$food->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($food);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_food_index');
    }
}
