<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('from', EmailType::class, ['label' => 'Your E-Mail Address'])
            ->add('message', TextareaType::class, ['attr' => ['rows' => 10]])
            ->add('send', SubmitType::class, ['attr' => ['class' => 'btn btn-primary btn-block']])
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
