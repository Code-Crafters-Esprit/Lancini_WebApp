<?php

namespace App\Service;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{
    public function transform($value): ?string
    {
        if ($value instanceof File) {
            return $value->getPathname();
        }

        return null;
    }

    public function reverseTransform($value): ?File
    {
        if (null === $value) {
            return null;
        }

        try {
            return new File($value);
        } catch (\Exception $e) {
            throw new TransformationFailedException(sprintf(
                'Unable to transform the string "%s" into a File object: %s',
                $value,
                $e->getMessage()
            ));
        }
    }
}