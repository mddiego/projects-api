<?php

use MongoDB\Client;

class Database
{
    private static $instance = null;
    private $db;

    private function __construct()
    {
        $client = new Client(getenv('MONGODB_URI') ?? $_ENV['MONGODB_URI']);
        // For MongoDB Atlas:
        // $client = new Client("mongodb+srv://<user>:<pass>@cluster.mongodb.net");

        $this->db = $client->selectDatabase(getenv('DB') ?? $_ENV['DB']);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getCollection(string $name)
    {
        return $this->db->selectCollection($name);
    }
}
