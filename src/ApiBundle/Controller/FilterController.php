<?php
namespace ApiBundle\Controller;

use CommonBundle\Controller\BaseController;

class FilterController extends BaseController
{
    /**
     * @return array - Filter Data
     */
    public function customerDataFiltersAction()
    {
        # Log started
        $this->logger->info("GET Filter Action Starts");

        # Get Location column data
        $filterObj = $this->get("api.services.filter");
        $filterInfo = $filterObj->getFilterData();

        # Log finished
        $this->logger->info("GET Filter Action Ends");

        return $filterInfo;
    }
}