<?php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
/**
 * @ORM\Entity
 * @ORM\Table(name="Quizzes")
 */
class Quiz
{
    /**
     * @ORM\Column(type="integer", name="id_quiz")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_quiz;
    /**
     * @ORM\Column(type="string", length=100, name="name")
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=800, name="description", nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="date", name="date_of_create")
     */
    private $date_of_create;
    /**
     * @ORM\Column(type="boolean", name="flag_active")
     */
    private $flag_active;
    /**
     * @ORM\ManyToMany(targetEntity="Question")
     * @ORM\JoinTable(name="Quiz_questions",
     *     joinColumns={@ORM\JoinColumn(name="id_quiz", referencedColumnName="id_quiz")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_question", referencedColumnName="id_question")})
     *
     */
    private $questions = array();
    public function __construct()
    {
        $this->date_of_create = new \DateTime('now');
  
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
    public function setDateOfCreate(Date $date)
    {
        $this->date_of_create = $date;
    }
    public function setFlagActive(bool $flag)
    {
        $this->flag_active = $flag;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getId()
    {
        return $this->id_quiz;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getDateOfCreate()
    {
        return $this->date_of_create;
    }
    public function getFlagActive()
    {
        return $this->flag_active;
    }
    public function getQuestions()
    {
        return $this->questions;
    }
    public function setQuestions(array $arr)
    {
        $this->questions = $arr;
    }
    public function getIdQuiz()
    {
        return $this->id_quiz;
    }
    public function addQuestion(Question $question)
    {
        $this->questions[] = $question;
    }
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }
}