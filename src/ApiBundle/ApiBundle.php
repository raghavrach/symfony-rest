<?php

namespace ApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use ApiBundle\DependencyInjection\ApiBundleExtension;

class ApiBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ApiBundleExtension();
        }

        return $this->extension;
    }
}
