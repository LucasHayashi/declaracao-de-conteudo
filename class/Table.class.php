<?php

class Table
{
    private $header = '';
    private $body = '';
    private $tableId;

    public function __construct($id)
    {
        $this->tableId = $id;
    }

    public static function createEmptyRows($qtdRows, $numOfFields, $colspanConfig = '')
    {
        $emptyRows = '';
        for ($i = 0; $i < $qtdRows; $i++) {
            $emptyRows .= "<tr>";
            for ($j = 0; $j < $numOfFields; $j++) {
                $colspan = 1;
                if (!empty($colspanConfig[$j])) {
                    $colspan = $colspanConfig[$j];
                }
                $emptyRows .= "<td colspan='$colspan'></td>";
            }
            $emptyRows .= "</tr>";
        }
        return $emptyRows;
    }

    public function addTableHeader($value, $colspan = 1, $class = '')
    {
        $this->header .= "<th colspan='$colspan' class='$class'>$value</th>";
    }

    public function startRowHeader()
    {
        $this->header .= "<tr>";
    }

    public function closeRowHeader()
    {
        $this->header .= "</tr>";
    }

    public function addTableData($value, $colspan = 1, $class = '')
    {
        $this->body .= "<td colspan='$colspan' class='$class'>$value</td>";
    }

    public function startRowBody()
    {
        $this->body .= "<tr>";
    }

    public function closeRowBody()
    {
        $this->body .= "</tr>";
    }

    public function addTableHtmlToBody($html)
    {
        $this->body .= $html;
    }

    public function render()
    {
        $css = "<style>
                    table, div {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                    }
                    
                    div {
                         padding: 10px;
                         margin-bottom: 10px;
                         border: 2px solid black;
                    }
                    
                    table {
                        width: 100%;
                        border: 2px solid black;
                        border-collapse: collapse;
                        margin-bottom: 10px;
                    }
                    
                    table td, table th {
                        border: 1px solid black;
                        padding: 4px;
                    }
                    
                    td {
                        width: 50px;
                        height: 12px;
                        vertical-align: initial;
                    }

                    .center {
                        text-align: center;
                    }
                    
                    .price-cells {
                        background-color: lightgray;
                        font-weight: bold;
                        text-align: right;
                    }
                    
                    h2 {
                        font-size: 20px;
                        text-align: center;
                        margin: 0;
                        padding: 0;
                    }

                    h3 {
                        font-size: 16px;
                        text-align: center;
                        text-decoration: underline;
                        margin: 10px 0 0 0;
                        padding: 0;
                    }
                    
                    #dados {
                        font-weight: bold;
                    }
                                        
                    #obs {
                        text-align: left;
                    }
                </style>";
        $html = $css . "<table id='$this->tableId'>";
        $html .= "<thead>" . $this->header . "</thead>";
        $html .= "<tbody>" . $this->body . "</tbody>";
        $html .= "</table>";

        return $html;
    }
}
