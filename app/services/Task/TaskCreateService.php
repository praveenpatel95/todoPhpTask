<?php

namespace Services\Task;

use Models\Task;
use Helpers\Validator;
use Exceptions\ValidationException;

/**
 * Service class for creating new tasks
 */
class TaskCreateService
{
    /**
     * @var Task Task model instance
     */
    protected Task $taskModel;

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
        $this->taskModel = new Task();
        $this->validator = new Validator();
    }

    /**
     * Set the data to be processed
     *
     * @param array|null $data The task data to be validated and created
     *                         Expected format:
     *                         [
     *                             'title' => string,
     *                             'description' => string
     *                         ]
     * @return self Returns the current instance for method chaining
     */
    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Process task creation with validation
     *
     * @throws ValidationException When validation fails, contains validation errors
     * @return bool|null Returns true on successful creation, null on failure
     */
    public function process(): ?bool
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:1000',
        ];

        // Validate data
        if (!$this->validator->validate($this->data, $rules)) {
            throw new ValidationException($this->validator->getErrors());
        }

        return $this->taskModel->create($this->data);
    }
}