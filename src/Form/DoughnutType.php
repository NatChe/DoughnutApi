<?php
/** Namespace */
namespace App\Form;

/** Usages */
use App\Entity\Doughnut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class DoughntType
 * @package App\Form
 */
class DoughnutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("reference", TextType::class, [
                "constraints" => [new NotBlank(), new NotNull()]
            ])
            ->add("name", TextType::class, [
                "constraints" => [new NotBlank(), new NotNull()]
            ])
            ->add("flavour", TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "csrf_protection" => false,
            "data_class" => Doughnut::class
        ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix(): ?string
    {
        return "";
    }

}