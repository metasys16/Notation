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

class AjoutPersonneController extends Controller
{
    /**
     * @Route("/personne/ajout", name="ajout_personne")
     */
    public function ajoutAction(Request $request)
    {
        $personne = new Personne();
        $form = $this->createFormBuilder($personne)
            ->add('nom', 'text')
            ->add('prenom', 'text')
            ->add('save', 'submit', array('label' =>'ajouter une personne'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('ajout_personne');
        }

        return $this->render(
            'NotationBundle:Default:ajout_personne.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
    
}
