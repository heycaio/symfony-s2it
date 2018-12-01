<?php

namespace ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PeoplePhone
 *
 * @ORM\Table(name="people_phones")
 * @ORM\Entity(repositoryClass="ModelBundle\Repository\PeoplePhoneRepository")
 */
class PeoplePhone
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
     * @ORM\Column(name="phone", type="string", length=11)
     * @Assert\NotBlank
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="people_id", type="integer")
     * @Assert\NotBlank
     */
    private $peopleId;


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
     * Set phone
     *
     * @param string $phone
     *
     * @return PeoplePhone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set peopleId
     *
     * @param integer $peopleId
     *
     * @return PeoplePhone
     */
    public function setPeopleId($peopleId)
    {
        $this->peopleId = $peopleId;

        return $this;
    }

    /**
     * Get peopleId
     *
     * @return int
     */
    public function getPeopleId()
    {
        return $this->peopleId;
    }
}

