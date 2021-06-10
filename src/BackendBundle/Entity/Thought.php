<?php

namespace BackendBundle\Entity;

/**
 * Thought
 */
class Thought
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $attachment;

    /**
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $videoyt;

    /**
     * @var integer
     */
    private $thoughtpadre;

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
     * Set text
     *
     * @param string $text
     *
     * @return Thought
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Thought
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return Thought
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Thought
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Thought
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set videoyt
     *
     * @param string $videoyt
     *
     * @return Thought
     */
    public function setVideoyt($videoyt)
    {
        $this->videoyt = $videoyt;

        return $this;
    }

    /**
     * Get videoyt
     *
     * @return string
     */
    public function getVideoyt()
    {
        return $this->videoyt;
    }

    /**
     * Set thoughtpadre
     *
     * @param integer $thoughtpadre
     *
     * @return Thought
     */
    public function setThoughtpadre($thoughtpadre)
    {
        $this->thoughtpadre = $thoughtpadre;

        return $this;
    }

    /**
     * Get thoughtpadre
     *
     * @return integer
     */
    public function getThoughtpadre()
    {
        return $this->thoughtpadre;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return Thought
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

