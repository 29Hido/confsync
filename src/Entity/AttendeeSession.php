<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AttendeeSessionRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: AttendeeSessionRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: 'attendee_sessions/{attendeeId}/{sessionId}'),
        new GetCollection(),
        new Post(),
        new Delete(uriTemplate: 'attendee_sessions/{attendeeId}/{sessionId}'),
    ]
)]
#[UniqueEntity(
    fields: ['attendeeId', 'sessionId'],
    message: 'This attendee already exist for the given session.',
)]
#[ApiFilter(SearchFilter::class, properties: ['attendeeId' => 'exact'])]
class AttendeeSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $attendeeId = null;

    #[ORM\Column(length: 255)]
    private ?string $sessionId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttendeeId(): ?string
    {
        return $this->attendeeId;
    }

    public function setAttendeeId(string $attendeeId): static
    {
        $this->attendeeId = $attendeeId;

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }
}
