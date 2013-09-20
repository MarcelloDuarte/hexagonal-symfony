<?php

namespace SensioLabs\CeremonyTrackerBundle\Entity;

use Doctrine\ORM\EntityRepository;
use SensioLabs\Ceremonies\Project as BaseProject;
use SensioLabs\Ceremonies\ProjectManager as BaseProjectManager;
use SensioLabs\Ceremonies\ProjectRepositoryInterface;

class ProjectRepository extends EntityRepository implements ProjectRepositoryInterface
{
    public function save(BaseProject $project)
    {
        $this->_em->persist($project);
        $this->_em->flush();
    }

    public function getManagerProjects(BaseProjectManager $manager)
    {
        return $this->findBy(['manager' => $manager]);
    }
}
