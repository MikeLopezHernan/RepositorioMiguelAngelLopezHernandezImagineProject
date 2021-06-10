<?php

namespace BackendBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 */
class User implements UserInterface, \Serializable{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $usernick;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $maildir;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $userimage;

    /**
     * @var string
     */
    private $biography;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $userstatus;
    
     public function getSalt(){
        return null;
    }
    public function getUsername(){
        return $this->maildir;
    }
    public function eraseCedentials(){
        
    }
    public function getRoles(){
        return array('USER','ROLE_ADMIN');
    }
    
    public function _toString(){
        return $this-> name;
    }
    public function serialize(){
        return serialize(array($this->id,$this->maildir,$this->password));
    }
    public function unserialize($serialized){
        list($this->id,$this->maildir,$this->password)= unserialize($serialized);
    }
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
     * Set usernick
     *
     * @param string $usernick
     *
     * @return User
     */
    public function setUsernick($usernick)
    {
        $this->usernick = $usernick;

        return $this;
    }

    /**
     * Get usernick
     *
     * @return string
     */
    public function getUsernick()
    {
        return $this->usernick;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set maildir
     *
     * @param string $maildir
     *
     * @return User
     */
    public function setMaildir($maildir)
    {
        $this->maildir = $maildir;

        return $this;
    }

    /**
     * Get maildir
     *
     * @return string
     */
    public function getMaildir()
    {
        return $this->maildir;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set userimage
     *
     * @param string $userimage
     *
     * @return User
     */
    public function setUserimage($userimage)
    {
        $this->userimage = $userimage;

        return $this;
    }

    /**
     * Get userimage
     *
     * @return string
     */
    public function getUserimage()
    {
        return $this->userimage;
    }

    /**
     * Set biography
     *
     * @param string $biography
     *
     * @return User
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography
     *
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set userstatus
     *
     * @param string $userstatus
     *
     * @return User
     */
    public function setUserstatus($userstatus)
    {
        $this->userstatus = $userstatus;

        return $this;
    }

    /**
     * Get userstatus
     *
     * @return string
     */
    public function getUserstatus()
    {
        return $this->userstatus;
    }

    public function eraseCredentials() {
        
    }

}
