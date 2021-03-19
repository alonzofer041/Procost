<?php


use App\Entity\Procost\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class,[
                'label'=>'Nom'
            ])
            ->add('description', TextareaType::class,[
                'label'=>'Description'])
            ->add('prix', NumberType::class,[
                'label'=>'Coût horaire']);
    }
    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class'=> Projet::class
        ]);
    }
}