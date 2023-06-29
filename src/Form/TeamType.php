<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /**
             * Team's name.
             *
             * Constraints:
             *      -Required (Not Blank)
             *      -Max length: 255
             *
             * @see Team::$name
             */
            ->add('name', TextType::class, [
                'required' => true,
            ])

            /**
             * Team's country.
             *
             * Constraints:
             *      -Required (Not Blank)
             *      -Max length: 255
             *
             * @see Team::$country
             */
            ->add('country', TextType::class, [
                'required' => true,
            ])

            /**
             * Team's money balance.
             *
             * This property is stored in the database as an integer (e.g. 123.45$ will be equal to 12345 in DB)
             *
             * Constraints:
             *      -Required (Not Blank)
             *      -Positive or zero
             *
             * @see Team::$balance
             */
            ->add('balance', MoneyType::class, [
                'required' => true,

                'currency' => 'USD',

                // This, is the option that manages internally the balance's decimal to integer conversion.
                'divisor' => 100,
            ])

            /**
             * Team's players.
             *
             * @see Team::$players
             */
            ->add('players', CollectionType::class, [
                'entry_type' => PlayerType::class,

                // This, allows creating dynamically as much player as you want from the new Team form.
                'allow_add' => true,

                'by_reference' => false,

                // Hide the automatically rendered row when the form does contain any player.
                'row_attr' => [
                    'class' => 'd-none',
                ]
            ])

            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
