<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class RapportType extends AbstractType {
  /**
   * @TODO: Missing description.
   *
   * @param FormBuilderInterface $builder
   *   @TODO: Missing description.
   * @param array $options
   *   @TODO: Missing description.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('version')
      ->add('datering')
      ->add('BaselineEl', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => '﻿kwh/år'
          )
        )
      ))
      ->add('BaselineVarmeGUF', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => '﻿kwh/år'
          )
        )
      ))
      ->add('BaselineVarmeGAF', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => '﻿kwh/år'
          )
        )
      ))
      ->add('BaselineVand', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'm3/år'
          )
        )
      ))
      ->add('BaselineStrafAfkoeling', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr/år'
          )
        )
      ))
      ->add('SamtidighedsFaktor')
      ->add('Energiscreening', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'Kr.'
          )
        )
      ));
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   *
   * @TODO: OptionsResolverInterface er deprecated?
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Rapport'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_rapport';
  }
}
