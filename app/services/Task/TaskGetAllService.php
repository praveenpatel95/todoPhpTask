<?php
namespace Services\Task;

use Models\Task;

class TaskGetAllService
{
    protected Task $taskModel;

    public function __construct()
    {
        $this->taskModel = new Task();
    }

    /**
     * Retrieve the list of all tasks.
     *
     * @return array|null Returns an array of all tasks if available, or null if no tasks are found.
     */
    public function process(): ?array
    {
        $userId = $_REQUEST['user_id'];
        return $this->taskModel->getAllByUserId($userId);
    }
}
