<?php

namespace app\db_models;

use app\models\AppModel;
use Exception;
use pronajem\libs\PaginationSetParams;

class Post extends AppModel
{


    public function __construct(PaginationSetParams $pagination)
    {

        $this->pagination = $pagination;

        parent::__construct($pagination);

    }

    /**
     * Uploads an image file to the server.
     *
     * If the upload fails, logs the error and returns null.
     *
     * @param array $image The uploaded file data ($_FILES['input_name']).
     * @return string|null The relative path to the uploaded file, or null if the upload fails.
     */
    public function uploadImage(array $image)
    {
        if(empty($image)){
            return null;
        }

        $folder = date('Y-m-d');
        $uploadDir = WWW . "/uploads/{$folder}/";

        try {
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                throw new Exception('Failed to create upload directory.', 500);
            }
            $fileName = basename($image['name']);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $uniqueFileName;

            if (move_uploaded_file($image['tmp_name'], $uploadFilePath)) {
                return strstr($uploadFilePath, 'uploads');
            } else {
                throw new Exception('Error saving the file.');
            }
        }catch(Exception $e) {
            logErrors($e->getMessage(), $e->getFile(), $e->getLine());
            return null;
        }
    }

    /**
     * Deletes an image file from the server.
     *
     * Logs an error if the file cannot be deleted or does not exist.
     * This method does not return a value, as file deletion is not critical
     * for the application workflow.
     *
     * @param string $imageFile The absolute path to the image file.
     */
    public function deleteImage(string $imageFile){

        if(file_exists($imageFile)) {
            try {
                if (!unlink($imageFile)) {
                    throw new Exception("Image $imageFile was not deleted");
                }
            }catch (Exception $e){
                logErrors($e->getMessage(), $e->getFile(), $e->getLine());
            }
        }else{
            logErrors("File $imageFile does not exist.");
        }

    }

    /**
     * Deletes all image files associated with a given post.
     *
     * @param string $postId The ID of the post.
     */
    public function deleteAllPostImages(string $postId){

        $post = $this->getOneRecordById($postId);
        if($post){
            $postContent = $post->content;
            $imagesLinks = $this->extractImagesLinks($postContent);
            foreach ($imagesLinks as $imageLink) {
                if(file_exists($imageLink)) {
                    try {
                        if (!unlink($imageLink)) {
                            throw new Exception("Image $imageLink was not deleted");
                        }
                    }catch (Exception $e){
                        logErrors($e->getMessage(), $e->getFile(), $e->getLine());
                    }
                }else{
                    logErrors("File $imageLink does not exist.");
                }
            }
        }
    }

    /**
     * Extracts all image links from the post content.
     *
     * @param string $content The post content as a string.
     * @return array An array of extracted image links.
     */
    private function extractImagesLinks(string $content): array
    {
        $pattern = '/uploads\/\d{4}-\d{2}-\d{2}\/[a-zA-Z0-9-_]+\.[a-zA-Z]{2,5}/';
        preg_match_all($pattern, $content, $matches);
        return $matches[0];
    }

}