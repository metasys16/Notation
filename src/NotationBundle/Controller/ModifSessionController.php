<?php

namespace NotationBundle\Controller;

use NotationBundle\Entity\Personne;
use NotationBundle\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ModifSessionController extends Controller
{
    /**
     * @Route("/session/{id}/detail", name="detail_session")
     * @ParamConverter("session", class="NotationBundle:Session")
     */

    public function detailSessionAction(Request $request, Session $session)
    {

        $form = $this->createFormBuilder($session)

            ->add('enseignant', EntityType::class, array(
                'class' => 'NotationBundle\Entity\Personne',
                'choice_label' => 'nom',))
            ->add('save', 'submit', array('label' =>'ajouter un enseignant'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()->getManager();
        $liste_session = $em->getRepository('NotationBundle:Session')->findAll();

        return $this->render(
            'NotationBundle:Default:modif_session.html.twig',
            array(
                'form' => $form->createView(),
                'liste_session' => $liste_session,
            )
        );

    }
}
