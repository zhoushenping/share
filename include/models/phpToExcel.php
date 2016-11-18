<?php
    class Excel{
        var $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?\>
        <Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
         xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
         xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
         xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
        var $footer = "</Workbook>";

        var $lines = array ();
        var $worksheet_title = "Table1";
        function addRow ($array) {

        $cells = "";
        
            foreach ($array as $k => $v):
                
                if(is_numeric($v)) {
                    if(substr($v, 0, 1) == 0) {
                        $cells .= "<Cell><Data ss:Type=\"String\">" . $v . "</Data></Cell>\n";
                    } else {
                        $cells .= "<Cell><Data ss:Type=\"Number\">" . $v . "</Data></Cell>\n";
                    }
                } else {
                    $cells .= "<Cell><Data ss:Type=\"String\">" . $v . "</Data></Cell>\n";
                }

            endforeach;

        $this->lines[] = "<Row>\n" . $cells . "</Row>\n";

        }

        function addArray ($array) {
        // run through the array and add them into rows
        foreach ($array as $k => $v):
            $this->addRow ($v);
        endforeach;

        }   

        function setWorksheetTitle ($title) {

        // strip out special chars first
        $title = preg_replace ("/[\\\|:|\/|\?|\*|\[|\]]/", "", $title);

        // now cut it to the allowed length
        $title = substr ($title, 0, 31);

        // set title
        $this->worksheet_title = $title;

        }

         function generateXML ($filename) {

        // deliver header (as recommended in php manual)
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $filename . ".xls\"");

        // print out document to the browser
        // need to use stripslashes for the damn ">"
        echo stripslashes ($this->header);
        echo "\n<Worksheet ss:Name=\"" . $this->worksheet_title . "\">\n<Table>\n";
        echo "<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" ss:Width=\"110\"/>\n";
        echo implode ("\n", $this->lines);
        echo "</Table>\n</Worksheet>\n";
        echo $this->footer;

       }

    }



?>