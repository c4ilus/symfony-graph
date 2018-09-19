<?php
# src/GraphQL/Mutation/BandMutation.php
namespace App\GraphQL\Mutation;

use App\Entity\Band;
use App\Repository\StyleRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class BandMutation implements MutationInterface, AliasedInterface
{
    private $styleRepository;

    public function __construct(StyleRepository $styleRepository)
    {
        $this->$styleRepository = $styleRepository;
    }

    public function createBand(string $name, string $country, int $style)
    {
        $band = new Band($name);
        $style = $this->styleRepository->find($style);
        $band->addStyle($style);
        $band->setCountry($country);

        return [
            'band' => $band,
            'style' => $style,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'mutation' => 'create_band',
        ];
    }
}