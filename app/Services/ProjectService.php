<?php

namespace App\Services;

use App\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    /**
     * Create a new class instance.
     */

    protected $projectRepository;
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }
    public function getAllProject()
    {

        try {
            $projects = $this->projectRepository->getAllProject();
            return $projects;
        } catch (\Throwable $th) {
            Log::error('Project fetch failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function getProjectById($projectId)
    {

        try {
            $project = $this->projectRepository->getProjectById($projectId);
            return $project;
        } catch (\Throwable $th) {
            Log::error('Project fetch failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function deleteProject($projectId)
    {
        try {
            $this->projectRepository->deleteProject($projectId);
            return true;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Log::error('Project deletion failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function createNewProject(array $projectDetails)
    {
        DB::beginTransaction();
        try {
            $projectDetails['user_id'] = Auth::user()->id;
            $project = $this->projectRepository->createProject($projectDetails);
            DB::commit();

            return $project;
        } catch (\Throwable $th) {
            DB::roleBack();
            Log::error('Project creation failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
    public function updateProject($projectId, array $newDataDetails)
    {
        DB::beginTransaction();

        try {
            $project = $this->projectRepository->updateProject($projectId, $newDataDetails);
            DB::commit();

            return $project;
        } catch (\Throwable $th) {
            DB::roleBack();
            Log::error('Project update failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
}
