<?php

namespace Vollborn\LocalDB\Classes;

use Vollborn\LocalDB\Classes\Exceptions\LocalDBException;

class Writer
{
    public const FILE_EXTENSION = '.json';

    /**
     * @var \Vollborn\LocalDB\Classes\Table
     */
    protected Table $table;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @param \Vollborn\LocalDB\Classes\Table $table
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     * @throws \Exception
     */
    public function __construct(Table $table)
    {
        $this->table = $table;

        $basePath = LocalDB::getBasePath();
        $this->createDirectoryTree($basePath);
        $this->path = $basePath . DIRECTORY_SEPARATOR . $this->table->getName() . self::FILE_EXTENSION;

        if (!is_file($this->path)) {
            $this->write([]);
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function read(): array
    {
        $content = file_get_contents($this->path);

        if (!$content) {
            throw new LocalDBException("Could not read file: $this->path");
        }

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $rows = [];

        foreach ($data as $item) {
            $rows[] = new Row($item);
        }

        return $rows;
    }

    /**
     * @param array $rows
     * @return array
     * @throws \Exception
     */
    public function write(array $rows): array
    {
        $data = Row::toArray($rows);
        $json = json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);

        if (!file_put_contents($this->path, $json)) {
            throw new LocalDBException("Could not write file: $this->path");
        }

        return $data;
    }

    /**
     * @param string $directory
     * @return void
     * @throws \Vollborn\LocalDB\Classes\Exceptions\LocalDBException
     */
    public function createDirectoryTree(string $directory)
    {
        if (is_dir($directory)) {
            return;
        }

        if (!mkdir($directory, 0777, true)) {
            throw new LocalDBException("Could not create directory: $directory");
        }
    }
}
