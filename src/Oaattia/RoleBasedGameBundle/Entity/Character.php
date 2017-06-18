<?php

namespace Oaattia\RoleBasedGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oaattia\RoleBasedGameBundle\Exceptions\GamePlayException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Character
 *
 * @ORM\Table(name="`character`")
 * @ORM\Entity(repositoryClass="Oaattia\RoleBasedGameBundle\Repository\CharacterRepository")
 */
class Character extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="30")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="attack", type="integer")
     * @Assert\Type(type="numeric")
     * @Assert\Length(max="20")
     */
    private $attack;

    /**
     * @var int
     *
     * @ORM\Column(name="defense", type="integer")
     * @Assert\Type(type="numeric")
     * @Assert\Length(max="20")
     */
    private $defense;


    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="character")
     */
    private $user;


    /**
     * @var string
     *
     * @ORM\Column(name="status", columnDefinition="ENUM('ready', 'paused', 'attacked', 'defeated')")
     */
    private $status;


    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nextTurn;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Character
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set attack
     *
     * @param integer $attack
     *
     * @return Character
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * Get attack
     *
     * @return int
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     *
     * @return Character
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense
     *
     * @return int
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @param mixed $user
     * @return Character
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getNextTurn()
    {
        return $this->nextTurn;
    }

    /**
     * @param mixed $nextTurn
     * @return Character
     */
    public function setNextTurn($nextTurn)
    {
        $this->nextTurn = $nextTurn;

        return $this;
    }


    /**
     * Every character can be attacked by two points
     */
    public function attack()
    {
        if ($this->status == 'attacked' && $this->nextTurn == true) {
            throw new GamePlayException("You can't attack one's character already attacked");
        }

        $this->defense = $this->defense - 2;
        $this->status = 'attacked';
        $this->nextTurn = true;
    }


}

