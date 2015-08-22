<?php

namespace FDA\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FDA\SiteBundle\Entity\Fiche;
use FDA\SiteBundle\Form\FicheType;
use FDA\SiteBundle\Form\SearchType;
use FDA\SiteBundle\Form\ReaffectType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{

    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$repository_fiche = $em->getRepository('FDASiteBundle:Fiche');
		
		$mySelec = $repository_fiche->get3RandFiches();
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST')
		{
			$fiche = new Fiche("anonyme");
			$form = $this->createForm(new SearchType, $fiche);
			$form->bind($request);
			/*if ($form->isValid())
			{*/
				$search = $fiche->getTitre();
				$list_categ = $fiche->getCategories();
				$liste_fiches = $repository_fiche->findByCateg($list_categ, $search);
				return $this->render('FDASiteBundle:Default:index.html.twig', array('fiches' => $liste_fiches, 'mySelec' => $mySelec, 'form' => $form->createView(), 'my_search' => $fiche));
			//}
		}
		
		if ($this->get('security.context')->isGranted('ROLE_EDITOR')) 
			$liste_fiches = $repository_fiche->findBy(array(), array('titre' => 'ASC'));
		else
			$liste_fiches = $repository_fiche->findBy(array('published' => true), array('titre' => 'ASC'));
		
        return $this->render('FDASiteBundle:Default:index.html.twig', array('fiches' => $liste_fiches, 'mySelec' => $mySelec));
    }
	
	//Symfony contient un outil appelé paramconverter qui, avec l'aide de doctrine, permet de récupérer l'entité qui va bien grace à l'id passé en url en le déclarant simplement dans le prototype de la fonction
	public function voirFicheAction($id, Fiche $fiche)
	{
		//Les liges commentées ci dessous sont gérées par symfony
		/*$em = $this->getDoctrine()->getManager();
		$repository_fiche = $em->getRepository('FDASiteBundle:Fiche');
		$fiche = $repository_fiche->find($id);
		
		if ($fiche == null) 
			throw $this->createNotFoundException('Article[id='.$id.'] inexistant');*/
		
		if (($fiche->getpublished() == false) && (!$this->get('security.context')->isGranted('ROLE_EDITOR')))
			throw new AccessDeniedException("Vous n'avez pas la permission de consulter la fiche");
		
        return $this->render('FDASiteBundle:Default:fiche.html.twig', array('fiche' => $fiche));
	}
	
	public function ajouterFicheAction()
	{
		if (!$this->get('security.context')->isGranted('ROLE_EDITOR'))
			throw new AccessDeniedException('Accès limité aux auteurs.');
	
		$user = $this->getUser();
		$fiche = new Fiche($user->getUsername());
		$form = $this->createForm(new FicheType, $fiche);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($fiche);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'Fiche bien enregistré');
				$strip = $this->container->get("fda_site.stripaccent");
				return $this->redirect( $this->generateUrl('fda_site_fiche', array('id' => $fiche->getId(), 'slug' => urlencode($strip->stripFilter($fiche->getTitre())))));
			}

		}
		return $this->render('FDASiteBundle:Default:ajouter.html.twig', array('form' => $form->createView(), 'fiche' => $fiche));
	}
	
	public function modifierFicheAction($id, Fiche $fiche)
	{
		$user = $this->getUser();
		$list_auteurs = explode(";", $fiche->getAuteur());
		if ((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ((!in_array($user->getUsername(), $list_auteurs)) || (!$this->get('security.context')->isGranted('ROLE_EDITOR'))))
			throw new AccessDeniedException('Cette fiche ne vous appartient pas.');
	
		$form = $this->createForm(new FicheType, $fiche);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();
				$fiche->setpublished(false);

				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'Fiche bien modifiée');
				$strip = $this->container->get("fda_site.stripaccent");
				return $this->redirect( $this->generateUrl('fda_site_fiche', array('id' => $fiche->getId(), 'slug' => urlencode($strip->stripFilter($fiche->getTitre())))));
			}
		
		}
		return $this->render('FDASiteBundle:Default:modifier.html.twig', array('form' => $form->createView(), 'id' => $id, 'fiche' => $fiche));
	}
	
	public function reaffectAction($id, Fiche $fiche)
	{
		$user = $this->getUser();
	
		$form = $this->createForm(new ReaffectType, $fiche);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();

				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'Fiche bien réaffectée');
				$strip = $this->container->get("fda_site.stripaccent");
				return $this->redirect( $this->generateUrl('fda_site_fiche', array('id' => $fiche->getId(), 'slug' => urlencode($strip->stripFilter($fiche->getTitre())))));
			}
		
		}
		return $this->render('FDASiteBundle:Default:form_reaffect.html.twig', array('form' => $form->createView(), 'id' => $id, 'fiche' => $fiche));
	}
	
	public function publierFicheAction($id, Fiche $fiche)
	{
		$em = $this->getDoctrine()->getManager();
		$fiche->setPublished(true);
		$em->flush();
		$this->get('session')->getFlashBag()->add('info', 'Fiche bien mise à jour');
		$strip = $this->container->get("fda_site.stripaccent");
		return $this->redirect( $this->generateUrl('fda_site_fiche', array('id' => $fiche->getId(), 'slug' => urlencode($strip->stripFilter($fiche->getTitre())))));
	}
	
	public function depublierFicheAction($id, Fiche $fiche)
	{
		$em = $this->getDoctrine()->getManager();
		$fiche->setPublished(false);
		$em->flush();
		$this->get('session')->getFlashBag()->add('info', 'Fiche bien mise à jour');
		$strip = $this->container->get("fda_site.stripaccent");
		return $this->redirect( $this->generateUrl('fda_site_fiche', array('id' => $fiche->getId(), 'slug' => urlencode($strip->stripFilter($fiche->getTitre())))));
	}
	
	public function SupprimerFicheAction($id, Fiche $fiche)
	{	
		$em = $this->getDoctrine()->getManager();
		
		$form = $this->createFormBuilder()->getForm();
		
		$request = $this->get('request');
		if ($form->handleRequest($request)->isValid()) 
		{
			$em->remove($fiche);
			$em->flush();
			$request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
			return $this->redirect( $this->generateUrl('fda_site_homepage'));
		}
		
		return $this->render('FDASiteBundle:Default:supprimer.html.twig', array(
			'fiche' => $fiche,
			'form'   => $form->createView()
		));
	}
	
	public function searchAction($fiche)
	{
		if ($fiche == null)
			$fiche = new Fiche("anonyme");
			
		$form = $this->createForm(new SearchType, $fiche);
		
		return $this->render('FDASiteBundle:Default:form_search.html.twig', array('form' => $form->createView(), 'fiche' => $fiche));
	}
	
	public function askPublishAction(Fiche $fiche)
	{
		$username = $this->getUser()->getUsername();

		if ((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($username != $fiche->getAuteur()))
			throw new AccessDeniedException('Accès limité aux auteurs.');
		
		$message = \Swift_Message::newInstance()
		->setContentType('text/html')
        ->setSubject('Demande de publication fiche '. $fiche->getTitre())
		->setFrom($this->getUser()->getEmail())
        ->setTo($this->container->getParameter('mail_admin'))
        ->setBody($this->renderView('FDASiteBundle:Mail:ask_publish.html.twig', array('fiche' => $fiche, 'username' => $username)))
		;
		
		$this->get('mailer')->send($message);
		$this->get('session')->getFlashBag()->add('info', 'Message bien envoyé, il sera traité dès que possible');
		$strip = $this->container->get("fda_site.stripaccent");
		return $this->redirect( $this->generateUrl('fda_site_fiche', array('id' => $fiche->getId(), 'slug' => urlencode($strip->stripFilter($fiche->getTitre())))));
	}
	
	public function contactAction()
	{
		return $this->render('FDASiteBundle:Default:contact.html.twig');
	}
	
		public function faqAction()
	{
		return $this->render('FDASiteBundle:Default:FAQ.html.twig');
	}
}
