<?php

namespace ApiBundle\Service;

use CommonBundle\Service\ExcelReaderFactory;
use ApiBundle\Service\ServerInformationReader;
use Monolog\Logger;

class Filter
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Server Information Data from parameter.yml
     */
    protected $dataServerInformation;

    /**
     * Constructor Function
     *
     * @param dataServerInformation
     * @param Logger $logger
     */
    public function __construct($dataServerInformation, Logger $logger)
    {
        $this->dataServerInformation = $dataServerInformation;

        $this->logger = $logger;
    }

    /**
     * Get storage filter value from parameter.yml
     *
     * @return array $storageFilterValues
     */
    public function getStorageFilter(): Array
    {
        return $this->dataServerInformation["filter_values"]["storage"];
    }

    /**
     * Get ram filter value from parameter.yml
     *
     * @return array $ramFilterValues
     */
    public function getRamFilter(): Array
    {
        return $this->dataServerInformation["filter_values"]["ram"];
    }

    /**
     * Get hard disk type filter value from parameter.yml
     *
     * @return array $hddFilterValues
     */
    public function getHarddiskTypeFilter(): Array
    {
        return $this->dataServerInformation["filter_values"]["harddisk_type"];
    }

    /**
     * Get Filter values
     *
     * @return array $filterInfo - Containing all the filter array
     */
    public function getFilterData(): Array
    {
        # Get Location dropdown from Excel

        # Get Storage, Harddisk & Ram list from parameter
        $filterInfo["storage"] = $this->getStorageFilter();
        $filterInfo["ram"] = $this->getRamFilter();
        $filterInfo["hardDiskType"] = $this->getHarddiskTypeFilter();

        # Get Excel Reader
        try{
            $excelFactory = new ExcelReaderFactory($this->dataServerInformation["file_path"], $this->dataServerInformation["reader_type"]);
            $reader = new ServerInformationReader($excelFactory);
        } catch (Exception $e) {
            $this->logger->error('Caught exception: ',  $e->getMessage());
        }


        # Get Location column data
        # Read Excel and create spreadsheet object
        $filterInfo["location"] = $reader->getLocationData("D");

        return $filterInfo;
    }
}