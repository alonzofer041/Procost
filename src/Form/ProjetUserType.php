<?php


use App\Entity\Procost\Projet;
use App\Entity\Procost\ProjetUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('projet', EntityType::class,[
            'class'=> Projet::class,
            'choice_label'=>'nom',
            'label'=>'Projet concerné'])
            ->add('temps_ind', NumberType::class,[
                'label'=>'Nombre d\'heures']);
    }
    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class'=> ProjetUser::class
        ]);
    }
}