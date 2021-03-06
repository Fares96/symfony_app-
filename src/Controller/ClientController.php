<?php

namespace App\Controller;
use  App\Entity\Client ;

use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;




class ClientController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return $this->render('client/homepage.html.twig') ;
    }
    /**
     * @Route("/client", name="client")
     */
    public function index()
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    /**
     * @Route("/client/show" , name="show")
     */
    public function  show()
    {
        $clients=$this->getDoctrine()->getRepository(Client::class)->findAll() ;
        return $this->render('client/show.html.twig',array('clients'=>$clients)) ;

    }
    /**
     * @Route("/client/new" , name="new")
     * @Method({"GET","POST"})
     */
    public function new(Request $request)
    {
        $client = new Client() ;
        $form = $this->createFormBuilder($client)
            ->add('nom',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('prenom',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('cin',NumberType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('date',DateType::class ,array('attr'=>array( 'widget' => 'choice' )))
            ->add('adresse',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('ville',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('Save',SubmitType::class ,array('label'=>'Create' ,'attr'=>array('class'=>'btn btn-primary mt-3 ')))
            ->getForm() ;
        $form->handleRequest($request) ;
        if($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('show');
        }

        return $this->render('client/new.html.twig',array('form'=>$form->createView())) ;
    }
    /**
     * @Route("/client/delete/{id}" , name="delete")
     * @Method({"DELETE"})
     */
    public function delete( Request $request , $id )
    {

        $client=$this->getDoctrine()->getRepository(Client::class)->find($id) ;
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();
        $response = new Response() ;
        return $response->send() ;
    }
    /**
     *@Route("client/update/{id}",name="update")
     */
    public function  update($id , Request $request)
    {
        $client = new Client() ;
        $client=$this->getDoctrine()->getRepository(Client::class)->find($id) ;
        $form = $this->createFormBuilder($client)
            ->add('nom',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('prenom',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('cin',NumberType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('date',DateType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('adresse',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('ville',TextType::class ,array('attr'=>array('class'=>'form-control')))
            ->add('Save',SubmitType::class ,array('label'=>'Update' ,'attr'=>array('class'=>'btn btn-primary mt-3 ')))
            ->getForm() ;
        $form->handleRequest($request) ;
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('show');
        }
       return $this->render("client/update.html.twig", array('form' => $form->createView())) ;
    }
}
