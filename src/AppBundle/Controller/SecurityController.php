<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->render('security/login.html.twig', []);
    }

    /**
     * @Route("/logout")
     * @throws \RuntimeException
     */
    public function logout()
    {
        throw new Exception("Error Processing Request");
    }

}