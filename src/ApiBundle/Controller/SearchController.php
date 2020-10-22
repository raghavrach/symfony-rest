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
     * @Validator("SearchFilterConstraints")
     */
    public function searchAction(Request $request)
    {
        # Log started
        $this->logger->info("POST Search Action Starts");

        $postData = $request->request->all();

        # Get Location column data
        $searchObj = $this->get("api.services.search");
        $searchData = $searchObj->searchCustomerInformation($postData);

        # Log finished
        $this->logger->info("POST Search Action Ends");
        return $searchData;

    }
}