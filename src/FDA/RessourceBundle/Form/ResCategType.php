<?php

namespace FDA\RessourceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResCategType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
			->add('liens', 'collection', array('type' => new LienType(), 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FDA\RessourceBundle\Entity\ResCateg'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fda_ressourcebundle_rescateg';
    }
}
