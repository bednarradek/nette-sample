<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use ByJG\DbMigration\Database\MySqlDatabase;
use ByJG\DbMigration\Exception\DatabaseDoesNotRegistered;
use ByJG\DbMigration\Exception\DatabaseIsIncompleteException;
use ByJG\DbMigration\Exception\DatabaseNotVersionedException;
use ByJG\DbMigration\Exception\InvalidMigrationFile;
use ByJG\DbMigration\Exception\OldVersionSchemaException;
use ByJG\DbMigration\Migration;
use ByJG\Util\Uri;
use Nette\Http\Request;
use Tracy\ILogger;

class MigrationService
{
    public const
        TYPE_UP = 'up',
        TYPE_DOWN = 'down',
        TYPE_INIT = "init";

    private Migration $migration;

    /**
     * @throws InvalidMigrationFile
     */
    public function __construct(
        private string $token,
        private string $host,
        private int $port,
        private string $user,
        private string $password,
        private string $database,
        private ILogger $logger,
    )
    {
        $connectionUri = new Uri(sprintf(
            'mysql://%s:%s@%s:%s/%s',
            $this->user,
            $this->password,
            $this->host,
            $this->port,
            $this->database,
        ));

        Migration::registerDatabase(MySqlDatabase::class);

        $this->migration = new Migration($connectionUri, __DIR__ . '/../../db_migrations');

        $logger = $this->logger;
        $this->migration->addCallbackProgress(function ($action, $currentVersion, $fileInfo) use ($logger) {
            $logger->log(sprintf("%s, %s, %s", $action, $currentVersion, $fileInfo['description']), "migrations");
        });
    }

    /**
     * @throws UnauthorizedException
     */
    public function auth(Request $request): void {
        if ($request->getHeader("X-Auth") !== $this->token) {
            throw new UnauthorizedException();
        }
    }

    /**
     * @throws DatabaseDoesNotRegistered
     */
    public function init(): void {
        $this->migration->createVersion();
    }

    /**
     * @throws DatabaseDoesNotRegistered
     * @throws DatabaseNotVersionedException
     * @throws InvalidMigrationFile
     * @throws DatabaseIsIncompleteException
     * @throws OldVersionSchemaException
     */
    public function run($version = null, $type = self::TYPE_UP): void {
        if ($type == self::TYPE_UP) {
            $this->migration->update($version);
            return;
        }

        if ($type == self::TYPE_DOWN) {
            if ($version === null) {
                throw new BadRequestException(sprintf("Missing version for migration type %s", $type));
            }
            $this->migration->down($version);
        }
    }
}