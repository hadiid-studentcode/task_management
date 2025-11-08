<?php

namespace App\Interfaces;

interface TaskRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAllTask();
    public function getTaskById($taskId);
    public function createTask(array $taskDetails);
    public function updateTask($taskId, array $newDataDetails);
    public function deleteTask($taskId);
}
