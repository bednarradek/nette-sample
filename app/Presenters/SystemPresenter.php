<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use App\Helpers\HttpHelper;
use App\Services\MigrationService;
use ByJG\DbMigration\Exception\DatabaseDoesNotRegistered;
use ByJG\DbMigration\Exception\DatabaseIsIncompleteException;
use ByJG\DbMigration\Exception\DatabaseNotVersionedException;
use ByJG\DbMigration\Exception\InvalidMigrationFile;
use ByJG\DbMigration\Exception\OldVersionSchemaException;
use Nette\Application\AbortException;
use Nette\Application\Responses\JsonResponse;

final class SystemPresenter extends BasePresenter
{

    public function __construct(private MigrationService $migrationService)
    {
        parent::__construct();
    }

    /**
     * @throws AbortException
     * @throws DatabaseDoesNotRegistered
     * @throws DatabaseIsIncompleteException
     * @throws DatabaseNotVersionedException
     * @throws InvalidMigrationFile
     * @throws OldVersionSchemaException
     */
    public function actionMigrate(): void {
        try {
            if ($this->getHttpRequest()->getMethod() !== HttpHelper::HTTP_METHOD_POST) {
                $this->sendCustomResponse(HttpHelper::HTTP_STATUS_METHOD_NOT_ALLOWED, 'Method Not Allowed');
            }

            $this->migrationService->auth($this->getHttpRequest());

            $type = $this->getHttpRequest()->getHeader("X-Migration-Type");
            if (!in_array(
                $type,
                [MigrationService::TYPE_INIT, MigrationService::TYPE_UP, MigrationService::TYPE_DOWN]
            )) {
                $this->sendCustomResponse(HttpHelper::HTTP_STATUS_BAD_REQUEST, "Missing X-Migration-Type");
            }

            $version = $this->getHttpRequest()->getHeader("X-Migration-Version");
            if ($version !== null && !is_numeric($version)) {
                $this->sendCustomResponse(HttpHelper::HTTP_STATUS_BAD_REQUEST, "Version have to be numeric");
            }
            if (is_numeric($version)) {
                $version = intval($version);
            }
            if ($type === MigrationService::TYPE_INIT) {
                if ($this->getHttpRequest()->getHeader("X-Migration-Confirm") == 'confirmed') {
                    $this->migrationService->init();
                } else {
                    $this->sendCustomResponse(HttpHelper::HTTP_STATUS_BAD_REQUEST, "Init have to be confirmed");
                }
            } else {
                $this->migrationService->run($version, $type);
            }
            $this->sendCustomResponse(HttpHelper::HTTP_STATUS_OK, "Ok");
        } catch (UnauthorizedException) {
            $this->sendCustomResponse(HttpHelper::HTTP_STATUS_UNAUTHORIZED, "Unauthorized");
        } catch (BadRequestException $e) {
            $this->sendCustomResponse($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @throws AbortException
     */
    private function sendCustomResponse(int $code, string $message): void {
        $this->getHttpResponse()->setCode($code);

        $this->sendResponse(new JsonResponse([
            "code" => $code,
            "message" => $message,
        ]));
    }
}