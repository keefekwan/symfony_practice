<?php

namespace General\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 */
class Users
{
    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $userid;


    /**
     * Set userName
     *
     * @param string $userName
     * @return Users
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Users
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
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
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
