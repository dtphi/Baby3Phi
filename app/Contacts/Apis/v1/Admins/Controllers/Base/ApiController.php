<?php

namespace App\Contacts\Apis\Admins\Controllers\Base;

interface ApiController
{
    public function getThumbnail($imgOrigin, $thumbSize = 0, $thumbHeight = 0, $force = false);

    public function forceThumbnail($staticThumImg, $thumbSize = 200, $thumbHeight = 0);

    public function getStatusCode();

    public function setStatusCode($statusCode);

    public function getResource();

    public function respondCreated($message, $newId);

    public function respondDeleted($message = 'Deleted');

    public function respondBadRequest($message = 'Invalid request', array $data = null);

    public function respondUpdated($resource = null, $message = 'Updated');

    public function respondWithData($data);

    public function respondWithCollectionPagination(array $data, $pagination, $page);

    public function respondWithError($message, array $data = null);
}
