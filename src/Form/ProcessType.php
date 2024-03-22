<?php

namespace App\Form;

use App\Entity\Process;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $builder
          ->add('memory_required', null, array(
              'constraints' => new Assert\Positive(
                  array(
                      'message' => 'Данное значение меньше или равно 0, измените это'
                  )
              )
          ))
          ->add('cpu_required', null, array(
              'constraints' => new Assert\Positive(
                  array(
                      'message' => 'Данное значение меньше или равно 0, измените это'
                  )
              )
          ))
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Process::class
        ]);
    }
}