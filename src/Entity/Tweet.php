<?php

namespace App\Entity;

use App\Repository\TweetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TweetRepository::class)
 */
class Tweet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $body;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Tweet::class, inversedBy="tweets")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Tweet::class, mappedBy="parent")
     */
    private $tweets;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tweets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=TweetArticle::class, mappedBy="tweets")
     */
    private $tweetArticles;

    public function __construct()
    {
        $this->tweets = new ArrayCollection();
        $this->tweetArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTweets(): Collection
    {
        return $this->tweets;
    }

    public function addTweet(self $tweet): self
    {
        if (!$this->tweets->contains($tweet)) {
            $this->tweets[] = $tweet;
            $tweet->setParent($this);
        }

        return $this;
    }

    public function removeTweet(self $tweet): self
    {
        if ($this->tweets->removeElement($tweet)) {
            // set the owning side to null (unless already changed)
            if ($tweet->getParent() === $this) {
                $tweet->setParent(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|TweetArticle[]
     */
    public function getTweetArticles(): Collection
    {
        return $this->tweetArticles;
    }

    public function addTweetArticle(TweetArticle $tweetArticle): self
    {
        if (!$this->tweetArticles->contains($tweetArticle)) {
            $this->tweetArticles[] = $tweetArticle;
            $tweetArticle->addTweet($this);
        }

        return $this;
    }

    public function removeTweetArticle(TweetArticle $tweetArticle): self
    {
        if ($this->tweetArticles->removeElement($tweetArticle)) {
            $tweetArticle->removeTweet($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->body;
    }
}
