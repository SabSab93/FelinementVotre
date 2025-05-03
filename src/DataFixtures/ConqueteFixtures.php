<?php

namespace App\DataFixtures;

use App\Entity\Conquete;
use App\Entity\Caractere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class ConqueteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    
        $items = [
            // [ name, description, breed, imageId, gender ]
            ['Georges',
             'Je maîtrise le breakdance sur le tapis du salon et j’adore te défier à toute heure. Ici pour danser la vie à tes côtés.',
             'Siamois', 1, 'male'],
            ['Minette',
             'Rayon de soleil à chaque ronron, je cherche une complicité authentique et des câlins sans fin.',
             'Ragdoll', 2, 'female'],
            ['Bernard',
             'Brillant comme une pierre précieuse, je cherche mon éclat parfait pour illuminer nos journées partagées.',
             'Persan', 3, 'male'],
            ['Lilou',
             'Tu me verras toujours dans tes pattes : je suis là pour que tu ne manques jamais un câlin.',
             'British Shorthair', 4, 'female'],
            ['Giovanni',
             'Mes miaulements résonnent comme un drop de basses : si tu aimes la fête, swipe à droite !',
             'Bengal', 5, 'male'],
            ['Momo',
             'Globe-trotter dans l’âme, je rêve de road-trips croquettes incluses… prêt(e) pour l’aventure ?',
             'Norvégien', 6, 'male'],
            ['Jean-Claude',
             'Organisé à l’extrême, j’équilibre tes croquettes comme un vrai comptable de l’amour.',
             'Chartreux', 7, 'male'],
            ['Œnophile',
             'Amateur de petits plaisirs raffinés, je savoure la vie une gorgée à la fois. Santé ! 🍷',
             'Sphynx', 8, 'female'],
            ['Chocobo',
             'Gardien intrépide des snacks, je protège tes goûters avec ferveur (et un peu de jalousie !).',
             'Maine Coon', 9, 'male'],
            ['Hades',
             'Empathique et tendre, j’adore les gros câlins – prépare les mouchoirs et l’amour !',
             'Ragdoll', 10, 'male'],
            ['Hercule',
             'Oui, je suis susceptible, mais un mot doux et je fonds comme neige au soleil.',
             'Siamois', 11, 'male'],
            ['Christina',
             'Toujours stylée, je défile sur le tapis rouge et je cherche un admirateur de mon élégance féline.',
             'British Shorthair', 12, 'female'],
        ];


        $traitMap = [
            0  => [4, 7],       // Georges : ninja + fait tomber objets
            1  => [2, 13],      // Minette : ronron + adore caresses
            2  => [14, 20],     // Bernard : regard méprisant + ne répond jamais
            3  => [16, 13],     // Lilou : dompteur de chaussettes + adore caresses
            4  => [8, 17],      // Giovanni : miaule à 4h + roi des miaulements
            5  => [9, 11],      // Momo : cartons + surveille oiseaux
            6  => [19, 20],     // Jean-Claude : alerte croquettes + ne répond jamais
            7  => [10, 2],      // Œnophile : boit au robinet + ronron moteur
            8  => [3, 19],      // Chocobo : chasseur + alerte croquettes
            9  => [2, 13],      // Hades : ronron moteur + adore caresses
            10 => [14, 20],     // Hercule : regard méprisant + susceptible(ne répond jamais)
            11 => [14, 16],     // Christina : regard méprisant + dompteur chaussettes
        ];


        /** @var ObjectRepository|Caractere[] $carRepo */
        $carRepo = $manager->getRepository(Caractere::class);

        foreach ($items as $i => [$name, $desc, $breed, $img, $gender]) {
            $conq = new Conquete();
            $conq->setName($name)
                 ->setDescription($desc)
                 ->setBreed($breed)
                 ->setImageId($img)
                 ->setGender($gender);
        
            foreach ($traitMap[$i] ?? [] as $traitId) {
                if ($trait = $carRepo->find($traitId)) {
                    $conq->addCaractere($trait);
                }
            }
        
            $manager->persist($conq);
        }
        
        $manager->flush();
    }
}
