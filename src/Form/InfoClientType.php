<?php

namespace App\Form;
use App\Repository\UserRepository;
use App\Entity\Categories;
use App\Entity\InfoClient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mail_pro')
            ->add('nom_societe')
            ->add('adresse')
            ->add('num_pro')
            ->add('num')
            ->add('cp')
            ->add('ville')
            ->add('siret')
            ->add('id_user', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->createQueryBuilder('a')
                        ->andWhere('a.roles LIKE :role')
                        ->setParameter('role', '%ROLE_COMPTABLE%')
                        ->orderBy('a.email');
                }

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoClient::class,
        ]);
    }
}
