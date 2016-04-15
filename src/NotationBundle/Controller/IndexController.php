<?php

namespace NotationBundle\Controller;

use NotationBundle\Entity\Personne;
use NotationBundle\Entity\Session;
use NotationBundle\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IndexController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $liste_session = $em->getRepository('NotationBundle:Session')->findAll();

        $em2 = $this->getDoctrine()->getManager();
        $liste_personne = $em2->getRepository('NotationBundle:Personne')->findAll();

        $em3 = $this->getDoctrine()->getManager();
        $liste_eleve = $em3->getRepository('NotationBundle:Eleve')->findAll();

        return $this->render('NotationBundle:Default:index.html.twig', array(
            'liste_session' => $liste_session,
            'liste_personne' => $liste_personne,
            'liste_eleve' => $liste_eleve,
        ));
    }
}
