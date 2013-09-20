<?php

namespace SensioLabs\CeremonyTrackerBundle\Controller;

use SensioLabs\CeremonyTracker\CreateProject;
use SensioLabs\CeremonyTracker\Event;
use SensioLabs\CeremonyTrackerBundle\Entity\Project;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;

class CreateProjectController
{
    private $useCase;
    private $securityToken;
    private $projectForm;
    private $flashBag;
    private $router;

    public function __construct(
        CreateProject $useCase,
        TokenInterface $securityToken,
        FormInterface $projectForm,
        FlashBagInterface $flashBag,
        RouterInterface $router
    )
    {
        $this->useCase = $useCase;
        $this->securityToken = $securityToken;
        $this->projectForm = $projectForm;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    public function createAction(Request $request)
    {
        $this->projectForm->handleRequest($request);

        if (!$this->projectForm->isValid()) {
            $this->onFailure(new Event(['reason' => 'Invalid project values provided.']));

            return new RedirectResponse($this->router->generate('list_my_projects'));
        }

        $project = $this->instantiateProjectFromFormData($this->projectForm->getData());
        $this->useCase->createProject($project);

        return new RedirectResponse($this->router->generate('list_my_projects'));
    }

    public function onSuccess(Event $event)
    {
        $this->flashBag->add('success', 'Project has been created.');
    }

    public function onFailure(Event $event)
    {
        $this->flashBag->add('failure', 'Failed to create project.' . PHP_EOL . $event->get('reason'));
    }

    private function instantiateProjectFromFormData(array $data)
    {
        return new Project($data['name'], $this->securityToken->getUser());
    }
}
