<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class MailerService
{
    public function __construct(private MailerInterface $mailer, private UrlGeneratorInterface $router, private string $secret = 'secret')
    {
    }
    public function sendEmail(
        $to = 'ayedy40@gmail.com',
        $content = '<p>Thank you for receiving this email!</p>',
        $subject = 'Time for Symfony Mailer!'
    ): void {
        $email = (new Email())
            ->from('lancini.verify@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            // ->text('Sending emails is fun again!')
            ->html($content);

        $this->mailer->send($email);

        // ...
    }

    public function sendTemplatedEmail(
        $to = 'ayedy40@gmail.com',
        $template = 'emails/template.html.twig',
        $subject = 'Time for Symfony Mailer!',
        string $routeName,
        UserInterface $user
    ): void {
        $signedUrl = $this->generateEmailConfirmationUrl($routeName, $user);

        $email = (new TemplatedEmail())
            ->from('lancini.verify@gmail.com')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context([
                // add any dynamic data to be used in the email template here
                'signedUrl' => $signedUrl,
            ]);

        $this->mailer->send($email);
    }

    public function generateEmailConfirmationUrl(string $routeName, UserInterface $user): string
    {
        $signatureComponents = [
            $user->getEmail(),
            $user->isVerified(),
            $user->getIduser(),
            $this->secret,
        ];

        $signature = hash_hmac('sha256', implode('|', $signatureComponents), $this->secret);
        $url = $this->router->generate($routeName, ['signedUrl' => $signature], UrlGeneratorInterface::ABSOLUTE_URL);

        return $url;
    }

    public function sendEmailConfirmation(
        $to = 'ayedy40@gmail.com',
        string $routeName,
        UserInterface $user,
        $nom
    ): void {
        $signedUrl = $this->generateEmailConfirmationUrl($routeName, $user);
        $email = (new TemplatedEmail())
            ->from('lancini.verify@gmail.com')
            ->to($to)
            ->subject('Please Confirm your Email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
            ->context([
                // add any dynamic data to be used in the email template here
                'name' => $nom,
                'signedUrl' => $signedUrl,
                'expiresAtMessageKey' => '1 hour'
            ]);
        $this->mailer->send($email);
    }
}
