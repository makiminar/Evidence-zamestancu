<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $timeTo;

    /**
     * @ORM\Column(type="time")
     */
    private $timeFrom;

    /**
     * @ORM\Column(type="enum_state_type", options={"default": "PENDING"}, length=255, nullable=false)
     */
    private States $state;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Room::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private Room $room;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="reservationsToAttend")
     */
    private Collection $attendees;

    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAttendees(): Collection
    {
        return $this->attendees;
    }

    public function addAttendee(User $attendee): self
    {
        if (!$this->attendees->contains($attendee)) {
            $this->attendees[] = $attendee;
        }

        return $this;
    }

    public function removeAttendee(User $attendee): self
    {
        $this->attendees->removeElement($attendee);

        return $this;
    }

    public function getState(): States
    {
        return $this->state;
    }

    public function setState($state): self
    {
        $this->state = $state;

        return $this;
    }

    public function isPending(): bool
    {
        return $this->state == States::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->state == States::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->state == States::REJECTED;
    }

    public function getDate(): ?string
    {
        if (!$this->date) {
            return null;
        }
        return $this->date->format('Y-m-d');
    }

    public function setDate(string $date): self
    {
        try {
            $this->date = new DateTime($date);
        } catch (\Exception $e) {
            print($e);
        }
        return $this;
    }

    public function getTimeTo(): ?string
    {
        if (!$this->timeTo) {
            return null;
        }
        return $this->timeTo->format('H:i');
    }

    public function setTimeTo(string $timeTo): self
    {
        try {
            $this->timeTo = new DateTime($timeTo);
        } catch (\Exception $e) {
            print($e);
        }
        return $this;
    }

    public function getTimeFrom(): ?string
    {
        if (!$this->timeFrom) {
            return null;
        }
        return $this->timeFrom->format('H:i');
    }

    public function setTimeFrom(string $timeFrom): self
    {
        try {
            $this->timeFrom = new DateTime($timeFrom);
        } catch (\Exception $e) {
            print($e);
        }
        return $this;
    }
}