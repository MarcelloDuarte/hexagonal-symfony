<?php

namespace SensioLabs\Ceremonies;

interface ProjectRepositoryInterface
{
    public function save(Project $project);
    public function getManagerProjects(ProjectManager $manager);
}
