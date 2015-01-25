<?php

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use SensioLabs\Ceremonies;
use SensioLabs\CeremonyTracker;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

/**
 * Behat context class.
 */
class ProjectManagerContext implements ContextInterface
{
    private $lastNotification;
    private $projectManager;
    private $project;
    private $specification;
    private $sprint;
    private $result;

    private $createProjectCase;
    private $getProjectsCase;
    private $scheduleSprintCase;
    private $createSpecificationCase;

    public function recordNotification(Event $event)
    {
        $this->lastNotification = $event->getName();
    }

    /**
     * @BeforeScenario
     */
    public function prepareUseCases()
    {
        $dispatcher = new EventDispatcher;
        $projectRepo = new CeremonyTracker\Ceremonies\InMemoryProjectRepository;
        $sprintRepo = new CeremonyTracker\Ceremonies\InMemorySprintRepository;
        $specRepo = new CeremonyTracker\Ceremonies\InMemorySpecificationRepository;

        $this->getProjectsCase = new CeremonyTracker\GetManagerProjects($projectRepo);
        $this->createProjectCase = new CeremonyTracker\CreateProject($projectRepo, $dispatcher);
        $this->createSpecificationCase = new CeremonyTracker\CreateSpecification($specRepo, $dispatcher);
        $this->getSprintsCase = new CeremonyTracker\GetProjectSprints($sprintRepo);
        $this->scheduleSprintCase = new CeremonyTracker\ScheduleSprint(
            $sprintRepo, $specRepo, $dispatcher
        );

        $dispatcher->addListener(CeremonyTracker\CreateProject::SUCCESS,
            [$this, 'recordNotification']);
        $dispatcher->addListener(CeremonyTracker\CreateProject::FAILURE,
            [$this, 'recordNotification']);

        $dispatcher->addListener(CeremonyTracker\ScheduleSprint::SUCCESS,
            [$this, 'recordNotification']);
        $dispatcher->addListener(CeremonyTracker\ScheduleSprint::FAILURE,
            [$this, 'recordNotification']);

        $specification = new Ceremonies\Specification(10, array(
            array('ceremony', 'day of sprint', 'hours'),
            array('sprint planning', '1', '2')
        ));
        $this->createSpecificationCase->createSpecification($specification);
        $specification = new Ceremonies\Specification(15, array(
            array('ceremony', 'day of sprint', 'hours'),
            array('sprint planning', '1', '3')
        ));
        $this->createSpecificationCase->createSpecification($specification);
    }

    /**
     * @Given /^I am a project manager$/
     */
    public function iAmAProjectManager()
    {
        $this->projectManager = new Ceremonies\ProjectManager('everzet');
    }

    /**
     * @Given /^I have no projects$/
     * @Given /^I have (\d+) projects$/
     */
    public function iHaveProjects($number = 1)
    {
        foreach (range(1, $number) as $i) {
            $this->iCreateTheProject('Project#'.$i);
        }
    }

    /**
     * @Given /^I have a "([^"]*)" project$/
     * @When /^I create the project$/
     * @When /^I create the "([^"]*)" project$/
     */
    public function iCreateTheProject($name = null)
    {
        $this->project = new Ceremonies\Project($name, $this->projectManager);

        $this->createProjectCase->createProject($this->project);
    }

    /**
     * @When /^I list my projects$/
     */
    public function iListMyProjects()
    {
        $this->result = $this->getProjectsCase->getManagerProjects($this->projectManager);
    }

    /**
     * @Then /^the "([^"]*)" project should be saved$/
     */
    public function theProjectShouldBeSaved($name)
    {
        $projects = $this->getProjectsCase->getManagerProjects($this->projectManager);

        foreach ($projects as $project) {
            if ($project->getName() === $name) {
                return;
            }
        }

        throw new RuntimeException('Project has not been saved');
    }

    /**
     * @Then /^the project should not be saved$/
     */
    public function theProjectShouldNotBeSaved()
    {
        $projects = $this->getProjectsCase->getManagerProjects($this->projectManager);

        if (count($projects)) {
            throw new RuntimeException('Project has created!');
        }
    }

    /**
     * @Then /^I should get an empty list of projects$/
     * @Then /^I should get a list of (\d+) projects$/
     */
    public function iShouldGetAListOfProjects($number = 1)
    {
        if (intval($number) !== count($this->result)) {
            throw new RuntimeException(count($this->result).' projects found');
        }
    }

    /**
     * @Then /^I should be notified about the project creation success$/
     */
    public function iShouldBeNotifiedAboutTheProjectCreationSuccess()
    {
        if (CeremonyTracker\CreateProject::SUCCESS !== $this->lastNotification) {
            throw new RuntimeException('No notification received');
        }
    }

    /**
     * @Then /^I should be notified about the project creation failure$/
     */
    public function iShouldBeNotifiedAboutTheProjectCreationFailure()
    {
        if (CeremonyTracker\CreateProject::FAILURE !== $this->lastNotification) {
            throw new RuntimeException('No notification received');
        }
    }

    /**
     * @When /^I schedule a (\d+) day sprint for this project starting (.*)$/
     */
    public function iScheduleADaySprintForThisProjectStarting($days, $date)
    {
        $this->sprint = new Ceremonies\Sprint(new DateTime($date), intval($days), $this->project);

        $this->scheduleSprintCase->scheduleSprint($this->sprint);
    }

    /**
     * @Given /^I have not yet scheduled any sprints for this project$/
     * @Given /^I have scheduled (\d+) sprints for this project$/
     */
    public function iHaveScheduledSprintsForThisProject($number = 1)
    {
        foreach (range(1, intval($number)) as $i) {
            $this->iScheduleADaySprintForThisProjectStarting(10, 'today');
        }
    }

    /**
     * @Then /^the new sprint should be scheduled starting (.*)$/
     */
    public function theNewSprintShouldBeScheduledStartingOn($date)
    {
        $sprints = $this->getSprintsCase->getProjectSprints($this->project);
        if ($sprints[0]->getStartDate()->format('d.m.Y') != date('d.m.Y', strtotime($date))) {
            throw new RuntimeException(sprintf('Sprint does not start on %s.', $date));
        }
    }

    /**
     * @Given /^I should be notified about the sprint scheduling success$/
     */
    public function iShouldBeNotifiedAboutTheSprintSchedulingSuccess()
    {
        if (CeremonyTracker\ScheduleSprint::SUCCESS !== $this->lastNotification) {
            throw new RuntimeException('No notification received');
        }
    }

    /**
     * @Then /^the sprint should not be scheduled$/
     */
    public function theSprintShouldNotBeScheduled()
    {
        $sprints = $this->getSprintsCase->getProjectSprints($this->project);
        if (count($sprints)) {
            throw new RuntimeException('Sprint has been scheduled.');
        }
    }

    /**
     * @Given /^I should be notified about the sprint scheduling failure$/
     */
    public function iShouldBeNotifiedAboutTheSprintSchedulingFailure()
    {
        if (CeremonyTracker\ScheduleSprint::FAILURE !== $this->lastNotification) {
            throw new RuntimeException('No notification received');
        }
    }

    /**
     * @When /^I list this project sprints$/
     */
    public function iListThisProjectSprints()
    {
        $this->result = $this->getSprintsCase->getProjectSprints($this->project);
    }

    /**
     * @Then /^I should get an empty list of sprints$/
     * @Then /^I should get a list of (\d+) sprints$/
     */
    public function iShouldGetAListOfSprints($number = 1)
    {
        if (intval($number) != count($this->result)) {
            throw new RuntimeException(count($this->result).' sprints found.');
        }
    }

    /**
     * @Given /^there is no specification for a (\d+) day sprint$/
     */
    public function thereIsNoSpecificationForADaySprint($days)
    {
    }

    /**
     * @Given /^the ceremony specification for a (\d+) day sprint is:$/
     */
    public function theCeremonySpecificationForADaySprintIs($days, TableNode $table)
    {
        $ceremonies = [];
        foreach ($table->getHash() as $hash) {
            $ceremonies[] = new Ceremonies\Ceremony(
                $hash['ceremony'],
                intval($hash['day of sprint']),
                intval($hash['hours'])
            );
        }

        $this->specification = new Ceremonies\Specification(intval($days), $ceremonies);
        $this->createSpecificationCase->createSpecification($this->specification);
    }

    /**
     * @Given /^this sprint ceremonies schedule should follow the specification$/
     */
    public function thisSprintCeremoniesScheduleShouldFollowTheSpecification()
    {
        if ($this->specification->getCeremonies() !== $this->sprint->getCeremonies()) {
            throw new RuntimeException('Ceremonies are different.');
        }
    }
}
