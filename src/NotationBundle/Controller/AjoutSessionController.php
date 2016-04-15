<?php

namespace NotationBundle\Controller;

use NotationBundle\Entity\Eleve;
use NotationBundle\Entity\Personne;
use NotationBundle\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Form\Type\TaskType;


class AjoutSessionController extends Controller
{
    /**
     * @Route("/session/ajoutSession", name="ajout_session")
     */
    public function ajoutSession(Request $request)
    {
        $session = new Session();

        $form = $this->createFormBuilder($session)
            ->add('intitule', 'text')
            ->add('date_debut', 'datetime')
            ->add('date_fin', 'datetime')
            ->add('enseignant', EntityType::class, array(
                'class' => 'NotationBundle\Entity\Personne',
                'choice_label' => 'nom',))
            ->add('eleve', EntityType::class, array(
                'class' => 'NotationBundle\Entity\Eleve',
                'choice_label' => 'prenom',
                'expanded' => false,
                'multiple' => true))
            ->add('save', 'submit', array('label' =>'ajouter une session'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render(
            'NotationBundle:Default:ajout_session.html.twig',
            array(
                'form' => $form->createView(),

            )
        );
    }
}
