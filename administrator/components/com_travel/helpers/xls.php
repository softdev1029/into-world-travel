<?php
class Excelreader {

   public function info($filePath)
   {
     $objReader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($filePath));
     $spreadsheetInfo = $objReader->listWorksheetInfo($filePath);
     unset($objReader);
     return $spreadsheetInfo[0]['totalRows'];
   
   }
  
  
    public function readFileAndDumpInDB($filePath, $chunkSize) {
        
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($filePath));

         $spreadsheetInfo = $objReader->listWorksheetInfo($filePath);

        /**  Create a new Instance of our Read Filter  * */
        $chunkFilter = new ChunkReadFilter();

        /**  Tell the Reader that we want to use the Read Filter that we've Instantiated  * */
        $objReader->setReadFilter($chunkFilter);
        $objReader->setReadDataOnly(true);
        //$objReader->setLoadSheetsOnly("Sheet1");
        //get header column name
        $chunkFilter->setRows(0, 1);
       
          
            $chunkFilter->setRows($startRow, $chunkSize);
            /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  * */
            $objPHPExcel = $objReader->load($filePath);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, false);

            $startIndex = ($startRow == 1) ? $startRow : $startRow - 1;
            //dumping in database
            if (!empty($sheetData) && $startRow < $totalRows) {
              
     print_R($sheetData);
             
            }
            $objPHPExcel->disconnectWorksheets();
            unset($objPHPExcel, $sheetData);
         }

    /**
     * Insert data into database table 
     * @param Array $sheetData
     * @return boolean
     * @throws Exception
     * THE METHOD FOR THE DATABASE IS NOT WORKING, JUST THE PUBLIC METHOD..
     */
    protected function dumpInDb($sheetData) {

        $con = DbAdapter::getDBConnection();
        $query = "INSERT INTO employe(name,address)VALUES";

        for ($i = 1; $i < count($sheetData); $i++) {
            $query .= "(" . "'" . mysql_escape_string($sheetData[$i][0]) . "',"
                    . "'" . mysql_escape_string($sheetData[$i][1]) . "')";
        }

        $query = trim($query, ",");
        $query .="ON DUPLICATE KEY UPDATE name=VALUES(name),
                =VALUES(address),
               ";
        if (mysqli_query($con, $query)) {
            mysql_close($con);
            return true;
        } else {
            mysql_close($con);
            throw new Exception(mysqli_error($con));
        }
    }

    /**
     * This function returns list of files corresponding to given directory path
     * @param String $dataFolderPath
     * @return Array list of file
     */
    protected function getFileList($dataFolderPath) {
        if (!is_dir($dataFolderPath)) {
            throw new Exception("Directory " . $dataFolderPath . " is not exist");
        }
        $root = scandir($dataFolderPath);
        $fileList = array();
        foreach ($root as $value) {
            if ($value === '.' || $value === '..') {
                continue;
            }
            if (is_file("$dataFolderPath/$value")) {
                $fileList[] = "$dataFolderPath/$value";
                continue;
            }
        }
        return $fileList;
    }

}



?>