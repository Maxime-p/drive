<?php

namespace App\Service;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private string $targetDirectory;
    private SluggerInterface $slugger;
    private EntityManagerInterface $em;

    public function __construct(string $targetDirectory, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function upload(UploadedFile $file, string $name): string
    {
        try {
            $file->move($this->targetDirectory, $name);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $file;
    }

    public function processData($formData)
    {
        $folder = $formData['folder'];
        $files = $formData['files'];
        foreach ($files as $file){

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $extension = $file->guessExtension();
            $fileName = $safeFilename.'-'.uniqid().'.'.$extension;

            $document = new Document();
            $document->setFolder($folder);
            $document->setName($fileName);
            $document->setExtension($extension);
            $document->setSize(filesize($file));

            if($this->upload($file, $fileName)){
                $this->em->persist($document);
            }
        }
        $this->em->flush();
    }
}