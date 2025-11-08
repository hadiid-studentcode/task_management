<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAllProject()
    {
        return Project::all();
    }
    public function getProjectById($projectId)
    {
        return Project::find($projectId);
    }
    public function createProject(array $projectDetails)
    {
        return Project::create($projectDetails);
    }
    public function updateProject($projectId, array $newDataDetails){
        return Project::where('id', $projectId)->update($newDataDetails);
    }
    public function deleteProject($projectId){
        return Project::where('id', $projectId)->delete();
    }
}
