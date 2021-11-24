<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('section', EntityType::class,
				[
					'placeholder' => '--',
					'class' => Section::class,
					'choice_label' => 'Name',
					]
				)
            ->add('Name')
            ->add('Description')
            ->add('link', UrlType::class)
            ->add('newTab')
			->add('Speichern', SubmitType::class, ['label' => 'Application speichern'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
