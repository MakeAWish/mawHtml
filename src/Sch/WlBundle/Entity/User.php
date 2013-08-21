<?php

namespace Sch\WlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Sch\WlBundle\Entity\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\OneToMany(targetEntity="Wish", mappedBy="user")
     */
    protected $wishes;

    /**
     * @ORM\ManyToMany(targetEntity="Circle", inversedBy="users")
     * @ORM\JoinTable(name="users_circles")
     **/
    protected $circles;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Add circles
     *
     * @param \Sch\WlBundle\Entity\Circle $circles
     * @return User
     */
    public function addCircle(\Sch\WlBundle\Entity\Circle $circles)
    {
        $this->circles[] = $circles;

        return $this;
    }

    /**
     * Remove circles
     *
     * @param \Sch\WlBundle\Entity\Circle $circles
     */
    public function removeCircle(\Sch\WlBundle\Entity\Circle $circles)
    {
        $this->circles->removeElement($circles);
    }

    /**
     * Get circles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCircles()
    {
        return $this->circles;
    }

    /**
     * Add wishes
     *
     * @param \Sch\WlBundle\Entity\Wish $wishes
     * @return User
     */
    public function addWishe(\Sch\WlBundle\Entity\Wish $wishes)
    {
        $this->wishes[] = $wishes;

        return $this;
    }

    /**
     * Remove wishes
     *
     * @param \Sch\WlBundle\Entity\Wish $wishes
     */
    public function removeWishe(\Sch\WlBundle\Entity\Wish $wishes)
    {
        $this->wishes->removeElement($wishes);
    }

    /**
     * Get wishes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWishes()
    {
        return $this->wishes;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
}