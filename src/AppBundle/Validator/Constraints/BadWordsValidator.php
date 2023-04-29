<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BadWordsValidator extends ConstraintValidator
{
    private $badWords = array(
        'Fuck', 'Shit', 'Bitch', 'Asshole', 'Cock', 'Dick', 'Pussy', 'Whore', 'Slut', 
        'Cum', 'Jizz', 'Masturbate', 'Fap', 'Fellate', 'Cunnilingus', 'Felching', 
        'Golden shower', 'Dirty Sanchez', 'Alabama Hot Pocket', 'Donkey Punch', 'Blumpkin', 
        'Pearl Necklace', 'Teabagging', 'Santorum', 'Motorboating', 'Rusty Trombone', 'Camel Toe',
        'Vajayjay', 'Titty', 'Boob', 'Nipple', 'Jugs', 'Knockers', 'Melons', 'Hooters', 'Bazongas',
        'Sack', 'Balls', 'Testicles', 'Schlong', 'Wiener', 'Pecker', 'Johnson', 'Meatstick', 'Rod',
        'Taint', 'Chode', 'Ass', 'Butt', 'Booty', 'Rump', 'Behind', 'Hiney', 'Derriere', 'Gluteus Maximus',
        'Anus', 'Rectum', 'Colon', 'Fart', 'Flatulence', 'Gas', 'Stool', 'Dookie', 'Poop', 'Crap', 'Dump',
        'Diarrhea', 'Constipation', 'Hemorrhoids', 'Enema', 'Prostate', 'Menstruation', 'Period', 'Tampon',
        'Clitoris', 'Labia', 'Vulva', 'Pubes', 'Bush', 'Muff', 'Beaver', 'Cooter', 'Pussy Lips', 'Gash',
        'Erection', 'Hard-on', 'Boner', 'Wood', 'Stiffy', 'Chubby', 'Turgid', 'Viagra', 'Cialis'
    );

    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value) || empty($value)) {
            return;
        }

        foreach ($this->badWords as $word) {
            if (stripos($value, $word) !== false) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
                return;
            }
        }
    }
}