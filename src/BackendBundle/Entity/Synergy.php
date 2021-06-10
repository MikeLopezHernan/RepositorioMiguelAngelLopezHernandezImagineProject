<?php

namespace BackendBundle\Entity;

/**
 * Synergy
 */
class Synergy
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $thought;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $user;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set thought
     *
     * @param \BackendBundle\Entity\User $thought
     *
     * @return Synergy
     */
    public function setThought(\BackendBundle\Entity\Thought $thought = null)
    {
        $this->thought = $thought;

        return $this;
    }

    /**
     * Get thought
     *
     * @return \BackendBundle\Entity\User
     */
    public function getThought()
    {
        return $this->thought;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return Synergy
     */
    public function setUser(\BackendBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
