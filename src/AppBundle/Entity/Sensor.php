<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Record;
/**
 * Sensor
 *
 * @ORM\Table(name="sensor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SensorRepository")
 */
class Sensor
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const TREND_NO = 0;
    const TREND_UP = 2;
    const TREND_DOWN = 1;

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
     * @ORM\Column(name="shortname", type="string", length=20, unique=true)
     */
    private $shortname;

    /**
     * @var string
     *
     * @ORM\Column(name="longname", type="text", nullable=true)
     */
    private $longname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = self::STATUS_ON;

    /**
     * @var string
     *
     * @ORM\Column(name="trend", type="smallint")
     */
    private $trend = self::TREND_NO;

    /**
     * @var Record
     *
     * @ORM\OneToOne(targetEntity="Record")
     * @ORM\JoinColumn(name="last_record_id", referencedColumnName="id", nullable=true)
     */
    private $lastRecord;

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
     * Set shortname
     *
     * @param string $shortname
     *
     * @return Sensor
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * Get shortname
     *
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return Sensor
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Sensor
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Sensor
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set trend
     *
     * @param int $trend
     *
     * @return Sensor
     */
    public function setTrend($trend)
    {
        $this->trend = $trend;

        return $this;
    }

    /**
     * Get trend
     *
     * @return int
     */
    public function getTrend()
    {
        return $this->trend;
    }

    /**
     * @return \AppBundle\Entity\Record
     */
    public function getLastRecord()
    {
        return $this->lastRecord;
    }

    /**
     * @param \AppBundle\Entity\Record $lastRecord
     */
    public function setLastRecord($lastRecord)
    {
        $this->lastRecord = $lastRecord;
    }
}

