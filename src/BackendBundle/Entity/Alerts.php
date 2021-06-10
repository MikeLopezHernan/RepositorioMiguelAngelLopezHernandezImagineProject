<?php

namespace BackendBundle\Entity;

/**
 * Alert
 */
class Alerts
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $notiType;

    /**
     * @var integer
     */
    private $notiTypeId;

    /**
     * @var string
     */
    private $isReaded;

    /**
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @var string
     */
    private $misscellaneous;

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
     * Set notiType
     *
     * @param string $notiType
     *
     * @return Alert
     */
    public function setNotiType($notiType)
    {
        $this->notiType = $notiType;

        return $this;
    }

    /**
     * Get notiType
     *
     * @return string
     */
    public function getNotiType()
    {
        return $this->notiType;
    }

    /**
     * Set notiTypeId
     *
     * @param integer $notiTypeId
     *
     * @return Alert
     */
    public function setNotiTypeId($notiTypeId)
    {
        $this->notiTypeId = $notiTypeId;

        return $this;
    }

    /**
     * Get notiTypeId
     *
     * @return integer
     */
    public function getNotiTypeId()
    {
        return $this->notiTypeId;
    }

    /**
     * Set isReaded
     *
     * @param string $isReaded
     *
     * @return Alert
     */
    public function setIsReaded($isReaded)
    {
        $this->isReaded = $isReaded;

        return $this;
    }

    /**
     * Get isReaded
     *
     * @return string
     */
    public function getIsReaded()
    {
        return $this->isReaded;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Alert
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
     * Set misscellaneous
     *
     * @param string $misscellaneous
     *
     * @return Alert
     */
    public function setMisscellaneous($misscellaneous)
    {
        $this->misscellaneous = $misscellaneous;

        return $this;
    }

    /**
     * Get misscellaneous
     *
     * @return string
     */
    public function getMisscellaneous()
    {
        return $this->misscellaneous;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return Alert
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
