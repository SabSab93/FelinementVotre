<?php
// src/DataFixtures/ConqueteFixtures.php

namespace App\DataFixtures;

use App\Entity\Conquete;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConqueteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // [ nom, description, race, imageId, sexe ]
        $items = [
            ['Georges',
             'Je maîtrise le breakdance sur le tapis du salon et j’adore te défier à toute heure. Sur ce site, je cherche quelqu’un prêt à danser la vie à mes côtés.',
             'Siamois', 1, 'male'],
            ['Minette',
             'Je suis le rayon de soleil qui manquait à ton profil : toujours de bonne humeur et prête à partager mes ronrons. Ici pour trouver une complicité authentique.',
             'Ragdoll', 2, 'female'],
            ['Bernard',
             'Comme un diamant, j’éclaire toute pièce où je passe. Sur cette plateforme, je recherche mon éclat parfait pour illuminer nos journées partagées.',
             'Persan', 3, 'male'],
            ['Lilou',
             'Tu me verras toujours dans tes pattes, car j’adore être près de toi. Je suis ici pour trouver quelqu’un qui appréciera ma présence constante et mes câlins à volonté.',
             'British Shorthair', 4, 'female'],
            // … les 8 autres comme ci-dessous …
            ['Giovanni',
             'Mes miaulements résonnent comme un beat envoûtant. Si tu aimes la bonne musique et les soirées rythmées, rejoins-moi pour vibrer ensemble.',
             'Bengal', 5, 'male'],
            ['Momo',
             'Globe-trotter dans l’âme, je rêve de découvrir le monde à tes côtés. Inscris-toi si tu es prêt(e) pour un road-trip félin plein d’aventures.',
             'Norvégien', 6, 'male'],
            ['Jean-Claude',
             'Ordonné et prévoyant, je classe même tes croquettes par couleur. Je recherche quelqu’un qui apprécie la fiabilité d’un compagnon un peu sérieux.',
             'Chartreux', 7, 'male'],
            ['Œnophile',
             'Amateur de dégustations raffinées, je savoure chaque moment. Si tu aimes les petites bulles et les plaisirs de la vie, faisons connaissance ici.',
             'Sphynx', 8, 'female'],
            ['Chocobo',
             'Gardien intrépide du frigo, je protège tes snacks avec ferveur. Ici pour trouver quelqu’un qui apprécie mon dévouement à la sécurité culinaire.',
             'Maine Coon', 9, 'male'],
            ['Hades',
             'Empathique et tendre, je fonds devant un sourire. Je cherche un cœur à chérir et des câlins sincères sur ce site.',
             'Ragdoll', 10, 'male'],
            ['Hercule',
             'Oui, je suis susceptible… mais un mot doux et tout rentre dans l’ordre. Je recherche quelqu’un de patient pour apaiser mes moues.',
             'Siamois', 11, 'male'],
            ['Christina',
             'Toujours stylée, je défie les tendances avec mon nœud-pap et mes rubans. Je suis ici pour rencontrer un admirateur de mon élégance.',
             'British Shorthair', 12, 'female'],
        ];

        foreach ($items as [$name, $desc, $breed, $img, $gender]) {
            $c = new Conquete();
            $c->setName($name)
              ->setDescription($desc)
              ->setBreed($breed)
              ->setImageId($img)
              ->setGender($gender);
            $manager->persist($c);
        }

        $manager->flush();
    }
}
