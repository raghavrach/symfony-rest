<?php

namespace ApiBundle\Service;

use CommonBundle\Service\ExcelReaderFactory;
use ApiBundle\Service\ServerInformationReader;
use Monolog\Logger;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column\Rule;

class Search
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
     * Set Excel Filter Rule for Storage Column
     *
     * @param &$reader - Referenced excel reader
     * @param $values - Post values
     */
    public function setRamFilterRules(&$reader, $values)
    {
        foreach($values as $ramValue)
        {
            $reader->setCustomRule('B', Rule::AUTOFILTER_COLUMN_RULE_EQUAL, $ramValue.'*');
        }
    }

    /**
     * Set Excel Filter Rule for HardDisk Column
     *
     * @param &$reader - Referenced excel reader
     * @param $values - Post values
     */
    public function setHDDFilterRules(&$reader, $values)
    {
        foreach($values as $hddValue)
        {
            $reader->setCustomRule('C', Rule::AUTOFILTER_COLUMN_RULE_EQUAL, '*'.$hddValue.'*');
        }
    }

    /**
     * Set Excel Filter Rule for Location Column
     *
     * @param &$reader - Referenced excel reader
     * @param $values - Post values
     */
    public function setLocationFilterRules(&$reader, $values)
    {
        foreach($values as $lValue)
        {
            $reader->setCustomRule('D', Rule::AUTOFILTER_COLUMN_RULE_EQUAL, $lValue);
        }
    }

    /**
     * This function applies filter Rules to Excel Reader and returns data based on Post params
     *
     * @param $postData - Post values from filter
     * @return $searchData - Filtered data
     */
    public function searchCustomerInformation($postData)
    {
        # Get Excel Reader
        try{
            $excelFactory = new ExcelReaderFactory($this->dataServerInformation["file_path"], $this->dataServerInformation["reader_type"]);
            $reader = new ServerInformationReader($excelFactory);
        } catch (Exception $e) {
            $this->logger->error('Caught exception: ',  $e->getMessage());
        }
        $reader->reader->setAutoFilter();

        if(!empty($postData['ram']))
        {
            $this->logger->info("Applying RAM Filter to Excel");

            $this->setRamFilterRules($reader, $postData['ram']);
        }

        if(!empty($postData['storage']) && !empty($postData['hardDiskType']))
        {
            $this->logger->info("Applying Storage & Hard Disk Type Filter to Excel");

            $storageHdd = [];
            foreach($postData['storage'] as $storageValue)
            {
                foreach($postData['hardDiskType'] as $hddValue)
                {
                    $storageHdd[] = $storageValue.$hddValue;
                }
            }

            $this->setHDDFilterRules($reader, $storageHdd);
        } else if (!empty($postData['storage']))
        {
            $this->logger->info("Applying Storage Filter to Excel");

            $this->setHDDFilterRules($reader, $postData['storage']);
        } else if (!empty($postData['hardDiskType']))
        {
            $this->logger->info("Applying Hard Disk Type Filter to Excel");

            $this->setHDDFilterRules($reader, $postData['hardDiskType']);
        }

        if(!empty($postData['location']))
        {
            $this->logger->info("Applying Location Filter to Excel");

            $this->setLocationFilterRules($reader, $postData['location']);
        }

        # Set show hide rows for Excel
        $reader->reader->showHideRows();
        $searchData = $reader->prepareSearchData();



        return $searchData;
    }
}