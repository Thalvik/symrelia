<?php

namespace Thalvik\SymreliaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{



	public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('articleName');
        $builder->add('articleSlug');
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Thalvik\SymreliaBundle\Entity\Article',
            'intention'          => 'article',
            'translation_domain' => 'ThalvikSymreliaBundle',
            'cascade_validation' => true,
            'csrf_protection'   => false,
        ));
    }


    public function getName() {
        return 'article';
    }
}
