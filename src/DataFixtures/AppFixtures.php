<?php

namespace App\DataFixtures;

use App\Entity\Figures;
use App\Entity\Groups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $listGroupEntity = [];
        $listeGroup = ["Mc Twist", "Jib", "Grabs", "Lipslide", "Air to Fakie"];
        foreach ($listeGroup as $currentGroup){
            $group = new Groups();
            $group->setFigureGroup($currentGroup);
            $listGroupEntity[]=$group;
            $manager->persist($group);
            $manager->flush();
        }
        /*for ($i = 0; $i <20; $i++){
            $figure = new Figures();
            $figure->setDescription("Description $i");
            $figure->setGroups($listGroupEntity[0]);
            $figure->setTitle("Title $i");
            $figure->set
        }*/
    }
}
