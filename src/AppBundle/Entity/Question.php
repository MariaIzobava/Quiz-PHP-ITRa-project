<?php

// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="questions")
 * @ORM\Entity
 */
class Question
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=225, unique=true)
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $variant1;
    
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $variant2;
    
    /**
     * @ORM\Column(type="integer")
     */
    
    private $answer;
    /**
     * @ORM\Column(type="string", length=64)
     */
    
    private $variant3;
    
    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
    
    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getVariant1()
    {
        return $this->variant1;
    }
    
    public function setVariant1($variant1)
    {
        $this->variant1 = $variant1;
    }
    
    public function getVariant2()
    {
        return $this->variant1;
    }
    
    public function setVariant2($variant2)
    {
        $this->variant2 = $variant2;
    }
    
    public function getVariant3()
    {
        return $this->variant3;
    }
    
    public function setVariant3($variant3)
    {
        $this->variant3 = $variant3;
    }

    public function getAnswer()
    {
        return $this->answer;
    }
    
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }
}