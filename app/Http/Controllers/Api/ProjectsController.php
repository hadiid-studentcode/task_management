<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    public function index()
    {
        try {
            $project = $this->projectService->getAllProject();
            return response()->json([
                'message' => 'Projects fetched successfully',
                'data' => $project
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to fetch projects.'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {

        $validatedData = $request->validated();

        try {
            $result = $this->projectService->createNewProject($validatedData);
            return response()->json([
                'message' => 'Project created successfully',
                'data' => $result
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create project.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $result = $this->projectService->getProjectById($id);
            return response()->json([
                'message' => 'Project fetched successfully',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to fetch project.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $validatedData = $request->validated();
        try {
            $result = $this->projectService->updateProject($id, $validatedData);
            return response()->json([
                'message' => 'Project updated successfully',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to update project.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->projectService->deleteProject($id);
            return response()->json([
                'message' => 'Project deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to delete project.',
            ]);
        }
    }
}
