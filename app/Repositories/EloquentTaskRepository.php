<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAllTask()
    {
        return Task::all();
    }
    public function getTaskById($taskId)
    {
        return Task::find($taskId);
    }
    public function createTask(array $taskDetails)
    {
        return Task::create($taskDetails);
    }
    public function updateTask($taskId, array $newDataDetails)
    {
        return Task::where('id', $taskId)->update($newDataDetails);
    }
    public function deleteTask($taskId)
    {
        return Task::where('id', $taskId)->delete();
    }
}
