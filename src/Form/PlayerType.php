<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /**
             * Player's name.
             *
             * Constraints:
             *      -Required (Not Blank)
             *      -Max length: 255
             *
             * @see Player::$name
             */
            ->add('name', TextType::class, [
                'required' => true,

                'attr' => [
                    'placeholder' => 'Name',
                ],
            ])

            /**
             * Player's surname.
             *
             * Constraints:
             *      -Max length: 255
             *
             * @see Player::$surname
             */
            ->add('surname', TextType::class, [
                'required' => false,

                'attr' => [
                    'placeholder' => 'Surname',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
