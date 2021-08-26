<?php

namespace LocalDB\Classes;

use Exception;
use LocalDB\Classes\Exceptions\LocalDBException;
use LocalDB\Traits\Helpers;
use LocalDB\Traits\HasTableProperties;

class Table
{
    use Helpers,
        HasTableProperties;

    private string $name;
    private string $filepath;

    /**
     * @throws \Exception
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->filepath = $name . '.json';

        if (!self::createJsonFile($this->filepath)) {
            throw new LocalDBException('File ' . $this->filepath . ' could not be created.');
        };
    }

    /**
     * @return array
     * @throws \LocalDB\Classes\Exceptions\LocalDBException
     */
    public function getAllRows(): array
    {
        try {
            $fileContent = file_get_contents(LocalDB::getPath() . '/' . $this->filepath);
            return json_decode($fileContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $exception) {
            throw new LocalDBException('Cannot read table ' . $this->name . '.');
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }
}
