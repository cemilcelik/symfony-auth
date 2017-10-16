<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Form\MemberType;
use AppBundle\Entity\Member;

class RegisterationController extends Controller {

    /**
     * @Route("/register", name="registeration")
     */
    public function registerAction(Request $request)
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this
                ->get('security.password_encoder')
                ->encodePassword(
                    $member,
                    $member->getPlainPassword()
                )
            ;

            $member->setPassword($password);

            $em = $this->getDoctrine()->getManager();

            $em->persist($member);
            $em->flush();

            $token = new UsernamePasswordToken(
                $member,
                $password,
                'main',
                $member->getRoles()
            );
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            $this->addFlash('success', 'You are now successfully registered!');

            return $this->redirectToRoute('homepage');

        }

        return $this->render('registeration/register.html.twig', [
            'registeration_form' => $form->createView()
        ]);
    }

}