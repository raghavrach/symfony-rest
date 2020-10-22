<?php
namespace ApiBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints;
use ApiBundle\Service\Filter;

/**
 * Custom validator constraint for search data params
 */
class SearchFilterConstraints extends Constraints\Collection
{
    /**
     * Constructor Function setting constraint rules
     */
    public function __construct()
    {
        parent::__construct([
            'ram' => [
                new Constraints\Type([
                    "type"=>'array'
                ])
            ],
            'hardDiskType' => [
                new Constraints\Type([
                    "type"=>'array'
                ])
            ],
            'location' => [
                new Constraints\Type([
                    "type"=>'array'
                ])
            ],
            'storage' => [
                new Constraints\Type([
                    "type"=>'array'
                ])
            ],
        ]);
    }

    /**
     * Validator validated by override
     */
    public function validatedBy()
    {
        return 'Symfony\Component\Validator\Constraints\CollectionValidator';
    }
}