<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\ImageProduit;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

class ImageUploadListener
{
    /** @var ImageUploaderInterface */
    private $uploader;

    public function __construct(ImageUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function upload(GenericEvent $event): void
    {
        $subject = $event->getSubject();
        Assert::isInstanceOf($subject, ImageProduit::class);
        if ($subject->hasFile()) {
            $this->uploader->upload($subject);
        }
    }
}