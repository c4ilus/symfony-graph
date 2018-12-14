<?php

namespace App\GraphQL\Mutation;

use App\Entity\Style;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class StyleMutation implements MutationInterface, AliasedInterface
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
    public function addStyle(array $argument): array
    {
        $style = new Style();
        $style->setName($argument['name']);

        $this->em->persist($style);
        $this->em->flush();

        return [
            'id' => $style->getId()
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
            'AddStyle' => 'add_style'
        ];
    }
}
