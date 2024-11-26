<?php

namespace Services\Task;

use Exceptions\NotFoundException;
use Models\Task;
use Helpers\Validator;
use Exceptions\ValidationException;

class TaskUpdateService
{
    protected Task $taskModel;
    protected Validator $validator;
    protected ?array $data;
    protected int $id;

    public function __construct()
    {
        $this->taskModel = new Task();
        $this->validator = new Validator();
    }

    /**
     * Set the data for updating the task.
     *
     * @param array|null $data The data to update the task with.
     * @return self Returns the instance of TaskUpdateService for method chaining.
     */
    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the ID of the task to be updated.
     *
     * @param int $id The ID of the task.
     * @return self Returns the instance of TaskUpdateService for method chaining.
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Process the task update.
     *
     * @return bool|null Returns true if the update was successful, false otherwise, or null if no update occurred.
     * @throws ValidationException Thrown if the provided data fails validation.
     * @throws NotFoundException Thrown if the task with the specified ID is not found.
     */
    public function process(): ?bool
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:1000',
        ];

        // Validate the input data
        if (!$this->validator->validate($this->data, $rules)) {
            throw new ValidationException($this->validator->getErrors());
        }

        // Check if the task exists
        $task = $this->taskModel->find($this->id);
        if (!$task) {
            throw new NotFoundException("Task not found");
        }

        // Update the task
        return $this->taskModel->update($this->id, $this->data);
    }
}
