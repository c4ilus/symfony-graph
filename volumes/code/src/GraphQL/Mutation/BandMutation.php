<?php

namespace App\GraphQL\Mutation;

use App\Entity\Band;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BandMutation extends AbstractController implements MutationInterface, AliasedInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $argument
     * @return array
     */
    public function addBand(array $argument): array
    {
        $band = new Band();
        $band->setName($argument['name']);
        $band->setCountry($argument['country']);

        $this->em->persist($band);
        $this->em->flush();

        return [
            'id' => $band->getId()
        ];
    }

    /**
     * Returns methods aliases.
     *
     * For instance:
     * array('myMethod' => 'myAlias')
     *
     * @return array
     */
    public static function getAliases(): array
    {
        return [
            'AddBand' => 'add_band'
        ];
    }
}
