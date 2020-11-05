<?php
namespace CommonBundle\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column\Rule;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;

/*
 * This class is a factory class for PhpSpreadsheet excel reader
 */
class ExcelReaderFactory
{
    /**
     * @var Excel reader type
     */
    protected $readerType;

    /**
     * @var Excel file path
     */
    protected $filePath;

    /**
     * Constructor Function
     *
     * @param $filePath
     * @param $readerType
     */
    public function __construct(string $filePath, string $readerType = 'Xlsx')
    {
        $this->readerType = $readerType;
        $this->filePath = $filePath;

        # Initialize the Excel Reader
        $this->initialize();
    }

    /**
     * This function loads excel file in read mode
     *
     * @return Excel Reader Object
     */
    private function initialize(): ExcelReaderFactory
    {
        $this->reader = IOFactory::createReader($this->readerType);
        $this->reader->setReadDataOnly(TRUE);
        $this->spreadSheet = $this->reader->load($this->filePath);
        return $this;
    }

    /**
     * Wrapper function for PhpSpreadsheet spreadSheet obj
     *
     * @return Excel Spreadsheet
     */
    public function getSpreadSheet(): Spreadsheet
    {
        return $this->spreadSheet;
    }

    /**
     * Wrapper function for PhpSpreadsheet sheet obj
     *
     * @return Excel Sheet
     */
    public function getSheet(): Worksheet
    {
        return $this->getSpreadSheet()->getActiveSheet();
    }

    /**
     * Wrapper function for PhpSpreadsheet AutoFilter obj
     *
     * @return Excel AutoFilter
     */
    public function getAutoFilter(): AutoFilter
    {
        return $this->getSheet()->getAutoFilter();
    }

    /**
     * This function sets the filter dimension
     *
     * @return Class Object
     */
    public function setAutoFilter(string $dimension=Null): ExcelReaderFactory
    {
        $filterDimension = $dimension ? $dimension : $this->getSheet()->calculateWorksheetDimension();
        $this->getSheet()->setAutoFilter($filterDimension);
        return $this;
    }

    /**
     * Wrapper function for PhpSpreadsheet Column obj
     *
     * @return Excel Column
     */
    public function getFilterColumn(string $column): Column
    {
        $autoFilter = $this->getAutoFilter();
        return $autoFilter->getColumn($column);
    }

    /**
     * Wrapper function for PhpSpreadsheet filter type method
     *
     * @return Excel Column Filter
     */
    public function setFilterType(string $column, $filterType): Column
    {
        $columnFilter = $this->getFilterColumn($column);
        return $columnFilter->setFilterType($filterType);
    }

    /**
     * Factory method to set PhpSpreadsheet filter rules
     *
     * @param $column - Excel column name
     * @param $rule - Filter rule
     * @param $value - Value for the applied rule
     * @param $filterType - Excel filter type
     * @param $ruleType - Excel rule type
     * @return Excel obj
     */
    public function setFilterRule(string $column, $rule, string $value, $filterType=Column::AUTOFILTER_FILTERTYPE_CUSTOMFILTER, $ruleType=Rule::AUTOFILTER_RULETYPE_CUSTOMFILTER): Rule
    {
        $columnFilter = $this->setFilterType($column, $filterType);
        return $columnFilter->createRule()
            ->setRule($rule, $value)
            ->setRuleType($ruleType);
    }

    /**
     * Wrapper function for PhpSpreadsheet showHideRows method
     *
     * @return Excel obj
     */
    public function showHideRows()
    {
        $autoFilter = $this->getSheet()->getAutoFilter();
        return $autoFilter->showHideRows();
    }

    /**
     * Wrapper function for PhpSpreadsheet getRowIterator method
     *
     * @return Excel iterator obj
     */
    public function getIteratorData(): RowIterator
    {
        return $this->getSheet()->getRowIterator();
    }
}