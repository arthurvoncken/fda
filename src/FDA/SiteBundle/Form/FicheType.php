<?php

namespace FDA\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FDA\RessourceBundle\Form\LienType;

class FicheType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text')
            //->add('bio', 'textarea')
			->add('bio', 'ckeditor', array('config_name' => 'my_config', "label" => "Biographie :"))
            //->add('contenu', 'textarea')
			->add('contenu', 'ckeditor', array('config_name' => 'my_config', "label" => "Détails :"))
			->add('image_titre', new ImageType(), array('required' => false))
			->add('image_ref', new ImageType(), array('required' => false))
			->add('image1', new ImageType(), array('required' => false))
			->add('image2', new ImageType(), array('required' => false))
			->add('image3', new ImageType(), array('required' => false))
			->add('categories', 'entity', array(
				'class' => 'FDASiteBundle:Category', 
				'property'=> 'name', 
				'multiple' => true, 
				'expanded' => true, 
				'query_builder' => function(\FDA\SiteBundle\Entity\CategoryRepository $er){
					return $er->createQueryBuilder('u')->orderBy('u.name', 'ASC');
				}
			))
			->add('liens', 'collection', array('type' => new LienType(), 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false))
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
