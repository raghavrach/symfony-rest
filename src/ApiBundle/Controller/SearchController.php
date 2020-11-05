<?php
namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Kununu\ControllerValidationBundle\Annotation\Validator;
use CommonBundle\Controller\BaseController;
use CommonBundle\Exception\JsonResponseException;
use ApiBundle\Validator\Constraints\SearchFilterConstraints;

class SearchController extends BaseController
{
     /**
     * This Controller Action performs the POST search on Server Information
     *
     *
     * Validator("SearchFilterConstraints")
     */
    public function searchAction(Request $request): array
    {
        # Log started
        $this->logger->info("GET Search Action Starts");

        $postData = $request->query->all();

        # Get Location column data
        $searchObj = $this->get("api.services.search");
        $searchData = $searchObj->searchCustomerInformation($postData);

        if(empty($searchData))
        {
            throw new JsonResponseException("No Data", 204);
        }

        # Log finished
        $this->logger->info("GET Search Action Ends");
        return $searchData;

    }
}