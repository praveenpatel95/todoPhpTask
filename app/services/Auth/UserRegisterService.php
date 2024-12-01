<?php

namespace Services\Auth;

use Models\User;
use Helpers\Validator;
use Exceptions\ValidationException;

/**
 * Service class for creating new tasks
 */
class UserRegisterService
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
     * Process User creation with validation
     *
     * @throws ValidationException When validation fails, contains validation errors
     * @return bool|null Returns true on successful creation, null on failure
     */
    public function process(): ?bool
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|min:10|max:255',
            'password' => 'required|min:3|max:255',
        ];

        // Validate data
        if (!$this->validator->validate($this->data, $rules)) {
            throw new ValidationException($this->validator->getErrors());
        }

        // Hash password
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);

        return $this->userModel->create($this->data);
    }
}