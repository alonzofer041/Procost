<?php


use App\Entity\Procost\Metier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,[
            'label'=>'nom du métier'
        ]);
    }
    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class'=> Metier::class
        ]);
    }
}