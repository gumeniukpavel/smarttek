<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static $instance = null;

    public function __invoke()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public static function getDB(): Database
    {
        if (!self::$instance) {
            $database = new self();
            $database();
            self::$instance = $database;
        }
        return self::$instance;
    }

    public function applyMigrations()
    {
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $migrations = scandir(APP_ROOT . '/migrations');
        $migrationsToApply = array_diff($migrations, $appliedMigrations);
        foreach ($migrationsToApply as $migration) {
            if ($migration == '.' || $migration == '..') {
                continue;
            }

            require_once APP_ROOT . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying migration $migration" . PHP_EOL;
            $instance->up();
            echo "Applied migration $migration" . PHP_EOL;
            $this->saveMigration($migration);
        }
    }

    public function saveMigration(string $migration)
    {
        Capsule::table('migrations')->insert(['migration' => $migration]);
    }

    public function createMigrationTable()
    {
        if (!Capsule::schema()->hasTable('migrations')) {
            Capsule::schema()->create('migrations', function ($table) {
                $table->increments('id');
                $table->string('migration', 255);
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    public function getAppliedMigrations()
    {
        return Capsule::table('migrations')->get()->pluck('migration')->toArray();
    }
}

Database::getDB();
