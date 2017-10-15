<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\MemberType;
use AppBundle\Entity\Member;

class RegisterationController extends Controller {

    /**
     * @Route("/register", name="registeration")
     */
    public function registerAction()
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);

        return $this->render('registeration/register.html.twig', [
            'registeration_form' => $form->createView()
        ]);
    }

}