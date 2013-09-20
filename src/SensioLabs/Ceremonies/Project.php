<?php

namespace SensioLabs\Ceremonies;

class Project
{
    protected $name;
    protected $manager;

    public function __construct($name, ProjectManager $manager)
    {
        $this->name = $name;
        $this->manager = $manager;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getManager()
    {
        return $this->manager;
    }
}
