<?php


use App\Entity\Procost\Metier;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prenom', TextType::class,[
            'label'=>'Prénom'
        ])
        ->add('nom',TextType::class,[
            'label'=>'Nom'
        ])
        ->add('email',TextType::class,[
            'label'=>'Email'])
        ->add('metier', EntityType::class,[
            'class'=> Metier::class,
            'choice_label'=>'nom'])
        ->add('cout_horaire', NumberType::class,[
            'label'=>'Coût horaire'])
        ->add('date_embauche', DateType::class,[
            'label'=>'Date d\'embauche']);
    }
    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class'=> User::class
        ]);
    }
}