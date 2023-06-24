<?php

namespace App\DataFixtures;

use App\Factory\TeamFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const MIN_TEAM_COUNT = 20;
    public const MAX_TEAM_COUNT = 40;

    /**
     * Generate a random number of teams (between self::MIN_TEAM_COUNT and self::MAX_TEAM_COUNT both included).
     *
     * Each team is populated with:
     *  -A random name
     *  -A random country
     *  -A random balance (between 100,000 and 10,000,000)
     *  -A random set of players (between 10 and 20)
     *
     * See: TeamFactory::getDefaults() for more details.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        TeamFactory::new()
            ->many(self::MIN_TEAM_COUNT, self::MAX_TEAM_COUNT)
            ->create();

        $manager->flush();
    }
}