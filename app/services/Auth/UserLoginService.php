<?php

namespace Services\Auth;

use Models\User;
use Helpers\Validator;
use Exceptions\ValidationException;
use Exception;

/**
 * Service class for creating new tasks
 */
class UserLoginService
{
    /**
     * @var User Task model instance
     */
    protected User $taskModel;

    /**
     * @var Validator Validator instance
     */
    protected Validator $validator;

    /**
     * @var array|null Data to be processed
     */
    protected ?array $data;

    /**
     * Initialize service with its dependencies
     */
    public function __construct()
    {
        $this->userModel = new User();
        $this->validator = new Validator();
    }

    /**
     * Set the data to be processed
     * @return self Returns the current instance for method chaining
     */
    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Process User login with validation
     *
     * @throws ValidationException When validation fails, contains validation errors
     * @return string Returns token on successful login on failure
     */
    public function process(): ?string
    {
        $rules = [
            'email' => 'required|min:10|max:255',
            'password' => 'required|min:3|max:255',
        ];

        // Validate data
        if (!$this->validator->validate($this->data, $rules)) {
            throw new ValidationException($this->validator->getErrors());
        }

        $user = $this->userModel->findByEmail($this->data['email']);
        if (!$user || !password_verify($this->data['password'], $user->password)) {
            throw new Exception('Invalid credentials', 401);
        }

        // Generate token
        $token = bin2hex(random_bytes(16));

        // Ensure the directory exists
        $tokenDirectory = "tokens/";
        if (!is_dir($tokenDirectory)) {
            mkdir($tokenDirectory, 0777, true); // Create directory if it doesn't exist
        }

        // Save the token with user ID
        file_put_contents($tokenDirectory . "{$token}.txt", $user->id);

        return $token;
    }
}