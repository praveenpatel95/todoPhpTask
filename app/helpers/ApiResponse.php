<?php

namespace Helpers;
use Core\Response;
trait ApiResponse
{

    /**
     * Send Success response
     * @param mixed $data
     * @param int $statusCode
     * @return void
     */
    public function success($data = null, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        echo Response::json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return void
     */
    public function fail($data = null, int $statusCode = 400): void
    {
        http_response_code($statusCode);
        echo Response::json([
            'success' => false,
            'data' => $data,
        ]);
    }
}
