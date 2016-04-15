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

class AjoutEleveController extends Controller
{
    /**
     * @Route("/eleve/ajout", name="ajout_eleve")
     */
    public function ajoutEleve(Request $request)
    {
        $eleve = new Eleve();
        $form = $this->createFormBuilder($eleve)
            ->add('prenom', 'text')
            
            ->add('save', 'submit', array('label' =>'ajouter un eleve'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eleve);
            $em->flush();
            return $this->redirectToRoute('ajout_eleve');
        }

        return $this->render(
            'NotationBundle:Default:ajout_eleve.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

}
