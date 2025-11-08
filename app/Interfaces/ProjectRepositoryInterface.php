<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function getAllProject();
    public function getProjectById($projectId);
    public function createProject(array $projectDetails);
    public function updateProject($projectId, array $newDataDetails);
    public function deleteProject($projectId);
}
