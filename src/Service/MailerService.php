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
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;
use Twig\Environment;

class MailerService
{
    private $twig;

    public function __construct(Environment $twig,private MailerInterface $mailer, private UrlGeneratorInterface $router, private string $secret = 'secret')
    {
        $this->twig = $twig;
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
        $transport = new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls');
        $transport->setUsername('lancini.verify@gmail.com');
        $transport->setPassword('jixaahkirmsloywt');
        $mailer = new Swift_Mailer($transport);
        $email = (new Swift_Message())
            ->setFrom('lancini.verify@gmail.com')
            ->setTo($to)
            ->setSubject('Please Confirm your Email')
            ->setBody(
                $this->twig->render(
                    'registration/confirmation_email.html.twig',
                    [
                        'name' => $nom,
                        'signedUrl' => $signedUrl,
                        'expiresAtMessageKey' => '1 hour'
                    ]
                ),
                'text/html'
            );

        $mailer->send($email);
    }
}
