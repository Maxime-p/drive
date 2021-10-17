<?php

namespace App\Controller;

use App\Form\FolderType;
use App\Form\UploadFileType;
use App\Repository\DocumentRepository;
use App\Repository\FolderRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/drive')]
class DriveController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/', name: 'drive')]
    public function index(FolderRepository $folderRepository, DocumentRepository $documentRepository): Response
    {

        $uploadForm = $this->createForm(UploadFileType::class);
        $folderForm = $this->createForm(FolderType::class);


        $folders = $folderRepository->findAll();
        $documents = $documentRepository->findBy(['folder' => null]);

        return $this->renderForm('drive/index.html.twig', [
            'uploadForm' => $uploadForm,
            'folderForm' => $folderForm,
            'folders' => $folders,
            'documents' => $documents
        ]);
    }

    #[Route('/upload', name: 'drive_upload', methods: ["POST"])]
    public function upload(Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UploadFileType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileUploader->processData($form->getData());
        }
        return $this->redirectToRoute('drive');
    }

    #[Route('/file/{id}', name: 'file_viewer')]
    public function fileReader($id, DocumentRepository $documentRepository): Response
    {
        $document = $documentRepository->find($id);
        return $this->render('drive/file.html.twig', [
            'document' => $document
        ]);
    }

    #[Route('/{id}', name: 'show_folder')]
    public function showFolderContent($id, FolderRepository $folderRepository, DocumentRepository $documentRepository): Response
    {
        $uploadForm = $this->createForm(UploadFileType::class);
        $folderForm = $this->createForm(FolderType::class);

        $folder = $folderRepository->find($id);
        $documents = $documentRepository->findBy(['folder' => $folder]);

        return $this->renderForm('drive/index.html.twig', [
            'uploadForm' => $uploadForm,
            'folderForm' => $folderForm,
            'folders' => $folder,
            'documents' => $documents
        ]);
    }
}
