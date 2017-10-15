<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('from', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('send', ButtonType::class)
            ->getForm();

        dump($this->container->getParameter('default_email'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            dump($data);
            
            $message = \Swift_Message::newInstance()
                ->setSubject('Symfony Contact Message')
                ->setFrom($data['from'])
                ->setTo($this->container->getParameter('default_email'))
                ->setBody(
                    $data['message'],
                    'text/plain'
                );
            
            $this->get('mailer')->send($message);

        }
        
        // replace this example code with whatever you need
        return $this->render('support/index.html.twig', ['ourForm' => $form->createView()]);
    }
}
