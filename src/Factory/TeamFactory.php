<?php

namespace App\Factory;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Team>
 *
 * @method        Team|Proxy                     create(array|callable $attributes = [])
 * @method static Team|Proxy                     createOne(array $attributes = [])
 * @method static Team|Proxy                     find(object|array|mixed $criteria)
 * @method static Team|Proxy                     findOrCreate(array $attributes)
 * @method static Team|Proxy                     first(string $sortedField = 'id')
 * @method static Team|Proxy                     last(string $sortedField = 'id')
 * @method static Team|Proxy                     random(array $attributes = [])
 * @method static Team|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TeamRepository|RepositoryProxy repository()
 * @method static Team[]|Proxy[]                 all()
 * @method static Team[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Team[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Team[]|Proxy[]                 findBy(array $attributes)
 * @method static Team[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Team[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TeamFactory extends ModelFactory
{
    public const MIN_PLAYER_COUNT = 10;
    public const MAX_PLAYER_COUNT = 20;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => $this->generateRandomTeamName(),

            // Choose a random country
            'country' => self::faker()->country(),

            // Generate a random balance between 100,000 and 10,000,000 (balance is stored as cents in DB)
            'balance' => self::faker()->numberBetween(100_000_00, 10_000_000_00),

            /**
             * Generate a random number of players (between self::MIN_PLAYER_COUNT and self::MAX_PLAYER_COUNT both included).
             *
             * Each player is populated with:
             *  -A random name
             *  -A random surname
             *
             * See: PlayerFactory::getDefaults() for more details.
            **/
            'players' => PlayerFactory::new()
                ->many(self::MIN_PLAYER_COUNT, self::MAX_PLAYER_COUNT),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Team $team): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Team::class;
    }

    /**
     * Generate a random team name combining sports team names' related adjectives and nouns.
     *
     * @return string
     */
    private function generateRandomTeamName(): string
    {
        $adjectives = [
            'United',
            'City',
            'Real',
            'Athletic',
            'Olympic',
            'Dynamic',
            'Fierce',
            'Mighty',
            'Swift',
            'Spirited',
            'Powerful',
            'Courageous',
            'Tenacious',
            'Relentless',
            'Unstoppable',
        ];

        $nouns = [
            'Lions',
            'Eagles',
            'Tigers',
            'Dragons',
            'Falcons',
            'Titans',
            'Warriors',
            'Gladiators',
            'Chargers',
            'Raptors',
            'Jaguars',
            'Panthers',
            'Phoenix',
        ];

        $randomAdjective = self::faker()->randomElement($adjectives);
        $randomNoun = self::faker()->randomElement($nouns);

        $randomTeamName = $randomAdjective . ' ' . $randomNoun;

        return $randomTeamName;
    }
}