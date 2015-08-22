<?php

namespace FDA\RessourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FDA\RessourceBundle\Entity\ResCateg;
use FDA\RessourceBundle\Form\ResCategType;
use FDA\RessourceBundle\Entity\Lien;

class RessourceController extends Controller
{
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$repository_categ = $em->getRepository('FDARessourceBundle:ResCateg');
		$liste_categ = $repository_categ->findBy(array(), array('name' => 'ASC'));
		
        return $this->render('FDARessourceBundle:Ressource:index.html.twig', array('categories' => $liste_categ));
    }
	
	public function ajouterCategAction()
	{
		$categ = new ResCateg();
		$form = $this->createForm(new ResCategType, $categ);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($categ);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'Catégorie bien enregistrée');
				return $this->redirect( $this->generateUrl('fda_ressource_homepage'));
			}

		}
		return $this->render('FDARessourceBundle:form:form_rescateg.html.twig', array('form' => $form->createView(), 'categ' => $categ));
	}
	
	public function modifierCategAction($id, ResCateg $categ)
	{
		$form = $this->createForm(new ResCategType, $categ);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();

				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'Catégorie bien modifiée');
				return $this->redirect( $this->generateUrl('fda_ressource_homepage'));
			}
		
		}
		return $this->render('FDARessourceBundle:form:form_rescateg.html.twig', array('form' => $form->createView(), 'categ' => $categ));
	}
	
	public function supprimerCategAction($id, ResCateg $categ)
	{	
		$em = $this->getDoctrine()->getManager();
		
		$form = $this->createFormBuilder()->getForm();
		
		$request = $this->get('request');
		if ($form->handleRequest($request)->isValid()) 
		{
			$em->remove($categ);
			$em->flush();
			$request->getSession()->getFlashBag()->add('info', "La catégorie a bien été supprimée.");
			return $this->redirect( $this->generateUrl('fda_ressource_homepage'));
		}
		
		return $this->render('FDARessourceBundle:Ressource:supprimer.html.twig', array(
			'categ' => $categ,
			'form'   => $form->createView()
		));
	}
}
