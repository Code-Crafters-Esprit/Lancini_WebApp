<?php 
namespace App\Locale;

class LocaleResolver
{
    private $defaultLocale;

    public function __construct(string $defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function setDefaultLocale(string $locale)
    {
        // Update the default locale parameter in the environment variables
        putenv("DEFAULT_LOCALE=$locale");

        // Update the local property for the default locale
        $this->defaultLocale = $locale;
    }

    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }
}
