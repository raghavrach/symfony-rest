<?php

namespace ApiBundle\Service;

use CommonBundle\Service\ExcelReaderFactory;


class ServerInformationReader
{
    /**
     * @var Server data from parameter.yml
     */
    private $dataServerInformation;

    /**
     * @var Excel Reader Obj
     */
    public $reader;

    /**
     * @var Excel Spreadsheet Obj
     */
    public $spreadSheet;

    /**
     * @var Excel Worksheet Obj
     */
     public $worksheet;


    /**
     * Constructor Function
     *
     * @param ExcelReaderFactory $excelReader
     */
    public function __construct(ExcelReaderFactory $excelReader)
    {
        $this->reader = $excelReader;
        $this->sheet = $this->reader->getSheet();
    }

    /**
     * This function returns Location data from Excel
     *
     * @param $column - Excel column name
     * @param $empty - Value for empty data
     * @param $formula - Excel formula
     * @param $formatted - Excel data format
     * @param $indexed - Excel data indexed
     * @return array $locationData - Unique location data from Excel
     */
    public function getLocationData($column, $empty=NULL, $formula=TRUE, $formatted=TRUE, $indexed = FALSE): array
    {
        # Start from 2nd row and till highest row
        $columnRange = $column.'2:'.$column.$this->sheet->getHighestRow();
        $dataArray = $this->sheet->rangeToArray($columnRange, $empty, $formula, $formatted, $indexed);
        return array_values(array_unique(array_map('current', $dataArray), SORT_STRING));
    }

    /**
     * This function sets a custom rule for Excel Reader
     *
     * @param $column - Excel column name
     * @param $rule - Excel rule
     * @param $value - Value for the applied rule
     * @return ServerInformationReader object
     */
    public function setCustomRule($column, $rule, $value): ServerInformationReader
    {
        $this->reader->setFilterRule($column, $rule, $value);

        return $this;
    }

    /**
     * This function formats the search data for post params
     *
     * @return $searchData - Formatted search data
     */
    public function prepareSearchData(): array
    {
        $searchData = [];
        # Print qualified data
        foreach ($this->reader->getIteratorData() as $row) {
            # Skip header row
            if($row->getRowIndex() == 1){ continue; }

            if ($this->reader->getSheet()
                ->getRowDimension($row->getRowIndex())->getVisible()) {
                #echo '    Row number - ' , $row->getRowIndex() , ' ';

                $model = $this->reader->getSheet()->getCell('A'.$row->getRowIndex())->getValue();
                $ram = $this->reader->getSheet()->getCell('B'.$row->getRowIndex())->getValue();
                $hdd = $this->reader->getSheet()->getCell('C'.$row->getRowIndex())->getValue();
                $location = $this->reader->getSheet()->getCell('D'.$row->getRowIndex())->getValue();
                $price = $this->reader->getSheet()->getCell('E'.$row->getRowIndex())->getValue();

                $searchData[] = ['model'=>$model, 'ram'=>$ram, 'hdd'=>$hdd, 'location'=>$location, 'price'=>$price];
            }
        }
        return $searchData;
    }
}