<?php

namespace Controllers;

use Helpers\ApiResponse;
use Exception;
use Services\Auth\UserLoginService;
use Services\Auth\UserRegisterService;
use Exceptions\ValidationException;

class AuthController
{
    use ApiResponse;

    private readonly UserRegisterService $userRegisterService;
    private readonly UserLoginService $userLoginService;

    public function __construct()
    {
        $this->userRegisterService = new UserRegisterService();
        $this->userLoginService = new UserLoginService();
    }


    /**
     * Store the data from the request.
     * @return string|null
     */
    public function register(): ?string
    {
        try {
            $task = $this->userRegisterService
                ->setData($_POST)
                ->process();
            return $this->success($task);
        } catch (ValidationException $exception) {
            return $this->fail($exception->getValidationErrors(), $exception->getCode());
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 500);
        }
    }

    /**
     * Login request.
     * @return string|null
     */
    public function login(): ?string
    {
        try {
            $token = $this->userLoginService
                ->setData($_POST)
                ->process();
            return $this->success(['token' => $token]);
        } catch (ValidationException $exception) {
            return $this->fail($exception->getValidationErrors(), $exception->getCode());
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 500);
        }
    }
}