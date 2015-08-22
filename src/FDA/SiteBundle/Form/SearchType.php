<?php

namespace FDA\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('titre', 'text', array('required' => false))
			->add('categories', 'entity', array(
				'class' => 'FDASiteBundle:Category', 
				'property'=> 'name', 
				'multiple' => true, 
				'expanded' => true, 
				'query_builder' => function(\FDA\SiteBundle\Entity\CategoryRepository $er){
					return $er->createQueryBuilder('u')->orderBy('u.name', 'ASC');
				}
			))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FDA\SiteBundle\Entity\Fiche'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fda_sitebundle_fiche';
    }
}
