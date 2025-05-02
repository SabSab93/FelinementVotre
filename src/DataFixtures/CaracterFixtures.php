<?php

namespace App\DataFixtures;

use App\Entity\Caractere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CaracterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $caracteres = [
            'Dorme sans honte',
            'Ronron moteur',
            'Chasseur né',
            'Fait le ninja la nuit',
            'Griffeur de canapés',
            'Lèche les cheveux',
            'Fait tomber les objets pour le fun',
            'Miaule à 4h du matin',
            'Se cache dans des cartons',
            'Aime boire au robinet',
            'Surveille les oiseaux par la fenêtre',
            'Ne supporte pas les autres chats',
            'Adore les caresses... parfois',
            'Maître du regard méprisant',
            'Fait pipi hors de la litière par vengeance',
            'Dompteur de chaussettes',
            'Roi des miaulements inutiles',
            'Fait la sieste sur le clavier',
            'Alerte croquettes permanente',
            'Ne répond jamais quand on l’appelle',
        ];

        foreach ($caracteres as $label) {
            $caractere = new Caractere();
            $caractere->setLabel($label);
            $manager->persist($caractere);
        }

        $manager->flush();
    }
}
