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
                    table, .declaracao {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        line-height: 1.3;
                    }

                    .declaracao, .declaracao div {
                        padding: 10px;
                        margin-bottom: 10px;
                        border: 2px solid black;
                        box-sizing: border-box;
                    }

                    table {
                        width: 100%;
                        table-layout: fixed;
                        border: 2px solid black;
                        border-collapse: collapse;
                        margin-bottom: 10px;
                    }

                    table td, table th {
                        border: 1px solid black;
                        padding: 4px 6px;
                        vertical-align: top;
                    }

                    td {
                        overflow-wrap: break-word;
                        height: 12px;
                        white-space: normal;
                    }

                    .center {
                        text-align: center;
                    }

                    .price-cells {
                        background-color: #d3d3d3;
                        font-weight: bold;
                        text-align: right;
                        padding-right: 8px;
                    }

                    h2 {
                        font-size: 20px;
                        text-align: center;
                        margin: 0;
                        padding: 0;
                        font-weight: bold;
                    }

                    h3 {
                        font-size: 16px;
                        text-align: center;
                        text-decoration: underline;
                        margin: 10px 0 0;
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
