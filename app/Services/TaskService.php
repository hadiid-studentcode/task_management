<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Create a new class instance.
     */

    protected $taskRepository;
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function getAllTask()
    {
        try {
            $tasks = $this->taskRepository->getAllTask();
            return $tasks;
        } catch (\Throwable $th) {
            Log::error('Task fetch failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function getTaskById($taskId)
    {
        try {
            $task = $this->taskRepository->getTaskById($taskId);
            return $task;
        } catch (\Throwable $th) {
            Log::error('Task fetch failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function deleteTask($taskId)
    {
        try {
            $this->taskRepository->deleteTask($taskId);
            return true;
        } catch (\Throwable $th) {
            Log::error('Task deletion failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function createNewTask(array $taskDetails)
    {
        DB::beginTransaction();
        try {
            $taskDetails['user_id'] = Auth::user()->id;
            $task = $this->taskRepository->createTask($taskDetails);
            DB::commit();
            return $task;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Task creation failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function updateTask($taskId, array $newDataDetails)
    {
        DB::beginTransaction();
        try {
            $task = $this->taskRepository->updateTask($taskId, $newDataDetails);
            DB::commit();
            return $task;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Task update failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
}
