<?php

namespace SensioLabs\CeremonyTrackerBundle\Controller;

use SensioLabs\CeremonyTracker\CreateProject;
use SensioLabs\CeremonyTracker\GetManagerProjects;
use SensioLabs\CeremonyTrackerBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ListMyProjectsController
{
    private $useCase;
    private $securityToken;
    private $projectFormView;
    private $templating;

    public function __construct(
        GetManagerProjects $useCase,
        TokenInterface $securityToken,
        FormView $projectFormView,
        EngineInterface $templating
    )
    {
        $this->useCase = $useCase;
        $this->securityToken = $securityToken;
        $this->projectFormView = $projectFormView;
        $this->templating = $templating;
    }

    public function listAction()
    {
        $projects = $this->useCase->getManagerProjects($this->securityToken->getUser());

        return $this->templating->renderResponse('CeremonyTrackerBundle:Projects:list.html.twig', [
            'project_form' => $this->projectFormView,
            'projects'     => array_map([$this, 'prepareProjectView'], $projects),
        ]);
    }

    public function prepareProjectView(Project $project)
    {
        return ['name' => $project->getName()];
    }
}
