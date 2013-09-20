<?php

namespace SensioLabs\CeremonyTrackerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', ['constraints' => [
            new NotBlank(),
            new Length(['min' => 3, 'max' => 255])
        ]]);
    }

    public function getName()
    {
        return 'create_project';
    }
}
