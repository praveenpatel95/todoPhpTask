<?php

namespace Controllers;

use Exceptions\NotFoundException;
use Helpers\ApiResponse;
use Exception;
use Services\Task\TaskCreateService;
use Services\Task\TaskDeleteByIdService;
use Services\Task\TaskGetAllService;
use Exceptions\ValidationException;
use Services\Task\TaskFindByIdService;
use Services\Task\TaskUpdateService;

class TaskController
{
    use ApiResponse;

    private readonly TaskGetAllService $taskGetAllService;
    private readonly TaskCreateService $taskCreateService;
    private readonly TaskFindByIdService $taskFindByIdService;
    private readonly TaskUpdateService $taskUpdateService;
    private readonly TaskDeleteByIdService $taskDeleteByIdService;

    public function __construct()
    {
        $this->taskGetAllService = new TaskGetAllService();
        $this->taskCreateService = new TaskCreateService();
        $this->taskFindByIdService = new TaskFindByIdService();
        $this->taskUpdateService = new TaskUpdateService();
        $this->taskDeleteByIdService = new TaskDeleteByIdService();
    }

    /**
     * Get all to-do's data.
     * @return array|null
     */
    public function index(): ?array
    {
        $tasks = $this->taskGetAllService->process();
        return $this->success($tasks);
    }

    /**
     * Store the data from the request.
     * @return string|null
     */
    public function store(): ?string
    {
        try {
            $task = $this->taskCreateService
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
     * Get To-Do detail by id
     * @param int $id
     * @return string|null
     */
    public function show(int $id): ?string
    {
        try {
            $task = $this->taskFindByIdService
                ->setId($id)
                ->process();
            return $this->success($task);
        } catch (NotFoundException $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode());
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 500);
        }
    }

    /**
     * Update the specified task
     * @param int $id
     * @return string|null
     */
    public function update(int $id): ?string
    {
        try {
            $task = $this->taskUpdateService
                ->setData($_POST)
                ->setId($id)
                ->process();
            return $this->success($task);
        } catch (ValidationException $exception) {
            return $this->fail($exception->getValidationErrors(), $exception->getCode());
        }catch (NotFoundException $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode());
        }catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 500);
        }
    }

    /**
     * Delete the specified task
     * @param int $id
     * @return string|null
     */
    public function destroy(int $id): ?string
    {
        try {
            $task = $this->taskDeleteByIdService
                ->setId($id)
                ->process();
            return $this->success($task);
        } catch (NotFoundException $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode());
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 500);
        }
    }
}