<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Taks\TaksRequest;
use App\Http\Resources\Task\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        try {
            $tasks = $this->taskService->getAllTask();
            return response()->json([
                'message' => 'Tasks fetched successfully',
                'data' => TaskResource::collection($tasks)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to fetch tasks.'
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaksRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $result = $this->taskService->createNewTask($validatedData);
            return response()->json([
                'message' => 'Task created successfully',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create task.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $task = $this->taskService->getTaskById($id);
            return response()->json([
                'message' => 'Task fetched successfully',
                'data' => TaskResource::collection($task)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to fetch task.'
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(TaksRequest $request, string $id)
    {
        $validatedData = $request->validated();
        try {
            $result = $this->taskService->updateTask($id, $validatedData);
            return response()->json([
                'message' => 'Task updated successfully',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to update task.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->taskService->deleteTask($id);
            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to delete task.'
            ], 500);
        }
    }
}
