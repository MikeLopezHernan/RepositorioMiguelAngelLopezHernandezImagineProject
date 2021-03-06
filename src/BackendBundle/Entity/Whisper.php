<?php

namespace BackendBundle\Entity;

/**
 * Whisper
 */
class Whisper
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content;

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
    private $readed;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $receiver;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $sender;


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
     * Set content
     *
     * @param string $content
     *
     * @return Whisper
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Whisper
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
     * @return Whisper
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
     * @return Whisper
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
     * Set readed
     *
     * @param string $readed
     *
     * @return Whisper
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed
     *
     * @return string
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set receiver
     *
     * @param \BackendBundle\Entity\User $receiver
     *
     * @return Whisper
     */
    public function setReceiver(\BackendBundle\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \BackendBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set sender
     *
     * @param \BackendBundle\Entity\User $sender
     *
     * @return Whisper
     */
    public function setSender(\BackendBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \BackendBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }
}

