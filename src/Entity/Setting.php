<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
class Setting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $siteName = null;

    #[ORM\Column(length: 255)]
    private ?string $siteUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $siteUrlfull = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteLogo = null;

    #[ORM\Column(length: 255)]
    private ?string $siteEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $siteVersion = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $siteAbout = null;

    #[ORM\Column(length: 255)]
    private ?string $siteSubtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $sitePresentation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $siteMentions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): static
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getSiteUrl(): ?string
    {
        return $this->siteUrl;
    }

    public function setSiteUrl(string $siteUrl): static
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }

    public function getSiteUrlfull(): ?string
    {
        return $this->siteUrlfull;
    }

    public function setSiteUrlfull(string $siteUrlfull): static
    {
        $this->siteUrlfull = $siteUrlfull;

        return $this;
    }

    public function getSiteLogo(): ?string
    {
        return $this->siteLogo;
    }

    public function setSiteLogo(?string $siteLogo): static
    {
        $this->siteLogo = $siteLogo;

        return $this;
    }

    public function getSiteEmail(): ?string
    {
        return $this->siteEmail;
    }

    public function setSiteEmail(string $siteEmail): static
    {
        $this->siteEmail = $siteEmail;

        return $this;
    }

    public function getSiteVersion(): ?string
    {
        return $this->siteVersion;
    }

    public function setSiteVersion(string $siteVersion): static
    {
        $this->siteVersion = $siteVersion;

        return $this;
    }

    public function getSiteAbout(): ?string
    {
        return $this->siteAbout;
    }

    public function setSiteAbout(string $siteAbout): static
    {
        $this->siteAbout = $siteAbout;

        return $this;
    }

    public function getSiteSubtitle(): ?string
    {
        return $this->siteSubtitle;
    }

    public function setSiteSubtitle(string $siteSubtitle): static
    {
        $this->siteSubtitle = $siteSubtitle;

        return $this;
    }

    public function getSitePresentation(): ?string
    {
        return $this->sitePresentation;
    }

    public function setSitePresentation(string $sitePresentation): static
    {
        $this->sitePresentation = $sitePresentation;

        return $this;
    }

    public function getSiteMentions(): ?string
    {
        return $this->siteMentions;
    }

    public function setSiteMentions(string $siteMentions): static
    {
        $this->siteMentions = $siteMentions;

        return $this;
    }
}
