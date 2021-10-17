<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\Folder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('folder', EntityType::class, [
                'class' => Folder::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Racine',
                'label' => 'Dossier : '
            ])
            ->add('files', CollectionType::class, [
                'entry_type' => FileType::class,
                'allow_add' => true,
                'label' => 'Fichier(s) : ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['id' => 'upload_file']
        ]);
    }
}
