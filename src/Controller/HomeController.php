<?php

namespace App\Controller;
use Symfony\Component\Intl\Timezones;
use App\Entity\Admin\Messages;
use App\Entity\Food;
use App\Entity\Setting;
use App\Form\Admin\MessagesType;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\OrdersRepository;
use App\Repository\FoodRepository;
use App\Repository\ImageRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SettingRepository $settingRepository, FoodRepository $foodRepository,OrdersRepository $ordersRepository)
    {
        $setting=$settingRepository->findAll();
        $slider=$ordersRepository->findBy(['status'=>'true'],['title'=>'DESC'],5);
        $foods=$foodRepository->findBy(['status'=>'true'],['title'=>'DESC'],9);
        $yemek=$foodRepository->findBy(['status'=>'true'],['title'=>'DESC'],2);



        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'setting'=>$setting,
            'slider'=>$slider,
            'foods'=>$foods,
            'yemek'=>$yemek,
        ]);
    }
    /**
     * @Route("/food/{id}", name="food_show", methods={"GET"})
     */
    public function show(Food $food,$id,ImageRepository $imageRepository,CommentRepository $commentRepository,OrdersRepository $ordersRepository): Response
    {
        $image=$imageRepository->findBy(['Food'=>$id]);
        $comment=$commentRepository->findBy(['foodid'=>$id, 'status'=>'true']);
        $orderss = $ordersRepository->findBy(['foodid'=>$id, 'status'=>'true']);
        return $this->render('home/foodshow.html.twig', [
            'food' => $food,
            'image'=>$image,
            'orderss'=>$orderss,
            'comment'=>$comment,
        ]);
    }
    /**
     * @Route("/about", name="home_about")
     */
    public function about(SettingRepository $settingRepository): Response
    {
        $setting=$settingRepository->findAll();
        return $this->render('home/aboutus.html.twig', [
            'setting'=>$setting,
        ]);
    }
    /**
     * @Route("/contact", name="home_contact", methods={"GET","POST"})
     */
    public function contact(SettingRepository $settingRepository,Request $request): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');
        $setting=$settingRepository->findAll();


        if ($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('form-messages', $submittedToken)) {

                $entityManager = $this->getDoctrine()->getManager();
                $message->setStatus('new');
                $message->setIp($_SERVER['REMOTE_ADDR']);
                $message->setCreatedAt(new\DateTime());
                $entityManager->persist($message);
                $entityManager->flush();
                $this->addFlash('success','Your message has been sent successfully');

                //***SEND EMAİL*****\\
                $email = (new Email())
                   ->from($setting[0]->getSmtpemail())
                   ->to($form['email']->getData())
                   ->subject('AllFood Your Request')
                   ->html("Dear".$form['name']->getData()."<br>
                            <p>We will evaluate your request and contact you as soon as possible</p>
                            Thank you for your message<br>
                            =========================================
                            <br>".$setting[0]->getCompany()."<br>
                            Address :".$setting[0]->getAddress()."<br>
                            Phone   :".$setting[0]->getPhone()."<br>"
                   );

               $transport = new GmailSmtpTransport($setting[0]->getSmtpemail(),$setting[0]->getSmtppassword());
               $mailer = new Mailer($transport);
               $mailer->send($email);
                //****************************\\
                return $this->redirectToRoute('home_contact');
            }
        }

        $setting=$settingRepository->findAll();
        return $this->render('home/contact.html.twig', [
            'setting'=>$setting,
            'form' => $form->createView(),
        ]);
    }

}
