<?php

namespace Services\Task;

use Models\Task;
use Exceptions\NotFoundException;

/**
 * Service class for deleting tasks by ID
 */
class TaskDeleteByIdService
{
    /**
     * @var Task Task model instance
     */
    protected Task $taskModel;

    /**
     * @var int ID of the task to be deleted
     */
    protected int $id;

    /**
     * Initialize service with its dependencies
     */
    public function __construct()
    {
        $this->taskModel = new Task();
    }

    /**
     * Set the ID of the task to be deleted
     *
     * @param int $id The unique identifier of the task
     * @return self Returns the current instance for method chaining
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Process task deletion with existence check
     *
     * @throws NotFoundException When task with the given ID doesn't exist
     * @return bool|null Returns true on successful deletion, null on failure
     */
    public function process(): ?bool
    {
        $task = $this->taskModel->find($this->id);
        if (!$task) {
            throw new NotFoundException("Task not found");
        }
        return $this->taskModel->delete($this->id);
    }
}