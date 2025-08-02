<?php namespace Metis\ORM;

class MysqlColumn
{
    public $name;
    public $default;
    public $nullable;
    public $type;
    public $maxLength;
    public $octetLength;
    public $precision;
    public $charset;
    public $collation;
    public $indexType;
    public $extra;
    public $comment;
    public $expression;
    public $setList= [];

    public function __construct(array $columnRaw)
    {
        $this->name=        $columnRaw['COLUMN_NAME'] ?? null;
        $this->default=     $columnRaw['COLUMN_DEFAULT'] ?? null;
        $this->nullable=    $columnRaw['IS_NULLABLE'] ?? null;
        $this->type=        $columnRaw['DATA_TYPE'] ?? null;
        $this->maxLength=   $columnRaw['CHARACTER_MAXIMUM_LENGTH'] ?? null;
        $this->octetLength= $columnRaw['CHARACTER_OCTET_LENGTH'] ?? null;
        $this->precision=   $columnRaw['NUMERIC_PRECISION'] ?? null;
        $this->charset=     $columnRaw['CHARACTER_SET_NAME'] ?? null;
        $this->collation=   $columnRaw['COLLATION_NAME'] ?? null;
        $this->indexType=   $columnRaw['COLUMN_KEY'] ?? null;
        $this->extra=       $columnRaw['EXTRA'] ?? null;
        $this->comment=     $columnRaw['COLUMN_COMMENT'] ?? null;
        $this->expression=  $columnRaw['GENERATION_EXPRESSION'] ?? null;

        if ($this->type === 'set') {
            $this->setList= $this->_morphSetList($columnRaw['COLUMN_TYPE']);
        }
    }

    private function _morphSetList(string $columnType)
    {
        $setList= str_replace('set(', '', $columnType);
        $setList= str_replace(')', '', $setList);
        $setList= str_replace("'", '', $setList);
        $setList= explode(',', $setList);

        return $setList;
    }
}