<?php

namespace FDA\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;



class UserController extends Controller
{
  public function indexAction()
  {
	$userManager = $this->get('fos_user.user_manager');
	$liste_users = $userManager->findUsers();
	return $this->render('FDAUserBundle:Default:users.html.twig', array('users' => $liste_users));
  }
  
  public function promoteAction($id)
  {
	$userManager = $this->get('fos_user.user_manager');
	$user = $userManager->findUserBy(array('id' => $id));
	$user->addRole("ROLE_EDITOR");
	$userManager->updateUser($user);
	return $this->redirect( $this->generateUrl('fda_user_homepage'));
  }
  
  public function demoteAction($id)
  {
	$userManager = $this->get('fos_user.user_manager');
	$user = $userManager->findUserBy(array('id' => $id));
	$user->removeRole("ROLE_EDITOR");
	$userManager->updateUser($user);
	return $this->redirect( $this->generateUrl('fda_user_homepage'));
  }
}
