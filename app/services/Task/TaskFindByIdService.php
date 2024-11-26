<?php
namespace Services\Task;

use Models\Task;
use Exceptions\NotFoundException;

class TaskFindByIdService
{
    protected Task $taskModel;
    protected int $id;

    public function __construct()
    {
        $this->taskModel = new Task();
    }

    /**
     * Set the ID for the task to be fetched.
     *
     * @param int $id The ID of the task.
     * @return self Returns the instance of TaskFindByIdService for method chaining.
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Process the task retrieval by ID.
     *
     * @return Object|null Returns the task object if found, otherwise null.
     * @throws NotFoundException Thrown when the task with the specified ID is not found.
     */
    public function process(): ?Object
    {
        $task = $this->taskModel->find($this->id);
        if (!$task) {
            throw new NotFoundException("Task not found");
        }

        return $task;
    }
}
