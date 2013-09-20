<?php

namespace SensioLabs\CeremonyTrackerBundle\Entity;

use SensioLabs\Ceremonies\ProjectManager as BaseProjectManager;
use Symfony\Component\Security\Core\User\UserInterface;

class ProjectManager extends BaseProjectManager implements UserInterface
{
    private $id;
    private $password;
    private $salt;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getUsername()
    {
        return $this->getName();
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_PROJECT_MANAGER'];
    }

    public function eraseCredentials()
    {
    }
}
