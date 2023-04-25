<?php

namespace App\Service;

use App\Entity\Reclamation;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class QrcodeService
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function qrcode(Reclamation $reclamation)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $data = $this->urlGenerator->generate('app_reclamation_show', ['id' => $reclamation->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        $qrCode = $writer->writeString($data);
        $dataUri = 'data:image/png;base64,' . base64_encode($qrCode);

        return $dataUri;
    }
}

