<?php
namespace Lucio\FileProcessor\Api\Data;

interface FileInterface
{
    const DB_MAIN_TABLE = "lucio_fileprocessor";
    const ENTITY_ID = "entity_id";
    const KEY = "key";
    const NAME = "name";
    const FILE_TYPE = "file_type";
    const DESCRIPTION = "description";
    const ORIGIN_LOCATION = "origin_location";
    const CREATED_AT = "created_at";

    public function getEntityId();
    public function setEntityId($entity_id);

    public function getKey();
    public function setKey($key);

    public function getName();
    public function setName($name);

    public function getFileType();
    public function setFileType($file_type);

    public function getDescription();
    public function setDescription($description);

    public function getOriginLocation();
    public function setOriginLocation($origin_location);

    public function getCreatedAt();
    public function setCreatedAt($created_at);


}
