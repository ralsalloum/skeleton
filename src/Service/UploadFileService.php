<?php


namespace App\Service;


use App\Request\SettingRequest;
use App\Response\SettingResponse;
use DateTime;
use Exception;
use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToWriteFile;
use Liip\ImagineBundle\Service\FilterService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileService
{
    private $filterService;
    private $fileSystem;
    private $params;
    private $settingService;

    public function __construct(Filesystem $fileSystem, FilterService $filterService, ParameterBagInterface $params, SettingService $settingService)
    {
        $this->filterService = $filterService;
        $this->fileSystem = $fileSystem;
        $this->params = $params;
        $this->settingService = $settingService;
    }

    public function uploadImage(UploadedFile $uploadedFile, ?string $existingFileName): string
    {
        $subFolder = $this->subFolder();

        $path = $this->getImageDestinationPath().'/'.$subFolder.'/';

        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $newFileName = Urlizer::urlize($originalFileName) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        $stream = fopen($uploadedFile->getPathname(), 'r');

        try {
            $this->fileSystem->writeStream($path . $newFileName, $stream);
            // it is ok!
        } catch (UnableToWriteFile | FilesystemException $exception) {
            throw new Exception(sprintf('Could not write uploaded file "%s"', $newFileName));
        }

        if (is_resource($stream))
        {
            fclose($stream);
        }

        if ($existingFileName)
        {
            try {
                $this->fileSystem->delete($path . $existingFileName);
            } catch (FileNotFoundException $e) {
                throw new Exception(sprintf('Could not delete old file "%s"', $existingFileName));
            }
        }

        //$resolve = $this->filterService->getUrlOfFilteredImage($subFolder.'/'.$newFileName, 'basic');

        return $path . $newFileName;
    }

    public function getImageDestinationPath(): string
    {
        $imageFolder = $this->params->get('image_folder');
        $originalImageFolder = $this->params->get('original_image');

        $destination = $imageFolder.'/'.$originalImageFolder;

        return $destination;
    }

    public function subFolder(): string
    {
        $count = random_int(1, 10);

        if ($count == 10)
        {
            $newFolderName = $this->newFolderName();

            $this->updateCurrentSubFolder($newFolderName);

            return $newFolderName;
        }
        else
        {
            return $this->getCurrentSubFolder();
        }
    }

    public function getCurrentSubFolder(): string
    {
        $subFolder = $this->settingService->getSetting();

        /* @var $subFolder SettingResponse */
        if ($subFolder)
        {
            return $subFolder->uploadSubFolder;
        }
        else
        {
            $result = $this->newFolderName();
            $this->createSetting($result);

            return $result;
        }
    }

    public function newFolderName(): string
    {
        $datetime = new DateTime();
        return $datetime->format('Y-m-d_H-i-s');
    }

    public function updateCurrentSubFolder($newFolderName)
    {
        $request = new SettingRequest();

        $request->setUploadSubFolder($newFolderName);

        $this->settingService->saveSetting($request);
    }

    public function createSetting($newFolderName)
    {
        $request = new SettingRequest();

        $request->setUploadSubFolder($newFolderName);

        $this->settingService->createSetting($request);
    }

}
