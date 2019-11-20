<?php

namespace app\SQLite;

use Exception;
use SQLite3;

class SQLite
{

    /**
     * SQLite instance
     * 
     * @var SQLite
     */
    public $sqdb;

    /**
     * Database file location
     * 
     * @var string
     * 
     */
    public $filename = "";

    /**
     * Last errror occured
     * @var array
     * 
     */
    public $error = [];


    /**
     * Instance status
     * @var boolean
     * True if there is no error False otherwise
     */
    public $status = true;

    /**
     *  Instantiates an SQLite3 object and opens an SQLite 3 database
     * 
     */
    public function __construct(string $filename = null)
    {
        $default = "mysqlitedb.db";
        if (!empty($filename)) {
            $this->filename = $filename;
        } else {
            $this->filename = $default;
        }

        try {
            $instance = new SQLite3($this->filename, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        } catch (Exception $e) {
            $this->status = false;
            $this->error["error"] = "Instance Creation";
            $this->error["info"] = $e->getMessage();
        }

        $this->sqdb = $instance;

        $this->createTables();
        $this->fill();
    }

    /**
     * Create database structure
     */
    protected function createTables(): void
    {
        $query = <<<SQL
        CREATE TABLE IF NOT EXISTS `param` (
            `id` INTEGER PRIMARY KEY,
            `name` TEXT,
            `type` TEXT DEFAULT 'string',
            `options` TEXT,
            `label` TEXT,
            `order` INT DEFAULT 0)
SQL;
        $this->sqdb->exec($query);
    }

    public function fill(int $value = 10): void
    {
        for ($i = 0; $i < $value; $i++) {
            $query = "INSERT INTO param (name,`label`,`order`) VALUES ('language','label " . $i . "'," . $i . ")";
            $this->sqdb->exec($query);
        }
    }
}
