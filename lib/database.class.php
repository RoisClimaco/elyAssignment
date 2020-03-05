<?php
//$mysql_link = mysqli_connect("localhost","root","","dbOnboardingStudents");

class MySqlDb
{
    var $m_objConn;
	var $m_strHost;
	var $m_strDbUser;
	var $m_strDbName;
	var $m_strDbPassword;
	var $m_strSqlString;
	var $m_strTableName;
	var $m_strConnect;
	
	function voidInitialize ($strHost, $strDbUser, $strDbPassword, $strDbName)
	{

		$this -> m_strHost   = $strHost;
		$this -> m_strDbUser = $strDbUser;
		$this -> m_strDbPassword = $strDbPassword;
		$this -> m_strDbName = $strDbName;
	}
	
	function voidConnect()
	{
	    
	    $this -> m_objConn = mysqli_connect("localhost","root","","dbOnboardingStudents");
	    //$this -> m_objConn = mysqli_connect($this -> m_strHost, $this -> m_strDbUser, $this -> m_strDbPassword, $this -> m_strDbName);
	    if ($this -> m_objConn)
	    {
	        return $this -> m_objConn;
	    }
	    else
	    {
	        return mysqli_error($this -> m_objConn);
	    }
	}
	
	function voidSetTableName($strTableName)
	{
		$this -> m_strTableName = $strTableName;
	}
	
	function strGetOne($strSql)
	{
		if ($rsSql = mysqli_query($strSql))
		{
			if ($rowSql = mysqli_fetch_assoc($rsSql))
			{
				return $rowSql[0];
			}
		}
		else
		{
			print mysqli_error();
		}
		return false;
	}

 	function strGetOneSql($strSql)
	{
		$arrData = array();
		if ($rsData = mysqli_query($this -> voidConnect(), $strSql))
		{
			if ($rowData = mysqli_fetch_row($rsData))
			{
				return $rowData[0];
			}
		}
		return $rowData[$strGetFieldName];
	}

	function intGetNumRows($strSql)
	{
		if ($rsSql = mysqli_query($strSql))
		{
			return mysqli_num_rows($rsSql);
		}
		return false;
	}


	function arrGetRow($strFieldName, $strValue)
	{
		$arrData = array();
		$sqlData = 'SELECT * FROM '.$this -> m_strTableName.' WHERE '.$strFieldName.' = \''.$strValue.'\'';
		if ($rsData = mysqli_query($this -> voidConnect(), $sqlData))
		{
			if ($rowData = mysqli_fetch_assoc($rsData))
			{
				$arrData = $rowData;
			}
		}
		return $arrData;
	}

	function arrGetRowSql($strSql)
	{	
		$arrData = array();
		if ($rsData = mysqli_query($strSql))
		{
			if ($rowData = mysqli_fetch_assoc($rsData))
			{
				$arrData = $rowData;
			}
		}
		return $arrData;
	}
 	function arrGetAll($strTableName, $strFieldName, $strValue)
	{
		$arrData = array();
		print $sqlData = 'SELECT * FROM '.$this -> strTableName.' WHERE '.$strFieldName.' = \''.$strValue.'\'';
		if ($rsData = mysqli_query($this->voidConnect(),$sqlData))
		{
			while ($rowData = mysqli_fetch_assoc($rsData))
			{
				array_push($arrData, $rowData);
			}
		}
		return $arrData;
	}	
	
	function arrGetAllSql($strSql)
	{		
		$arrData = array();
		if ($rsData = mysqli_query($this->voidConnect(), $strSql))
		{
			while ($rowData = mysqli_fetch_assoc($rsData))
			{
				array_push($arrData, $rowData);
			}
		}
		return $arrData;
	}	
	

	
	function blnExecute($strSql)
	{
		if ($rsSql = mysqli_query($strSql))
		{
			return $rsSql;
		}
		return false;
	}

	function intInsertData($arrValuePairs)
	{
		$strFieldNames 	= '';
		$strValues 		= '';
		foreach($arrValuePairs as $key => $value)
		{
			$strFieldNames 	.= $key.',';
			$strValues		.= '\''.$value.'\',';
		}
		$strFieldNames 	= substr_replace($strFieldNames, '', -1, 1);
		$strValues 		= substr_replace($strValues, '', -1, 1);
		$sqlInsert 		= 'INSERT INTO '.$this -> m_strTableName.'('.$strFieldNames.')
								VALUES('.$strValues.')';
		if (mysqli_query($this -> voidConnect(), $sqlInsert))
		{
		    //return mysqli_insert_id($this -> voidConnect());
		    return true;
		}
		else
		{
			return false;
		}
	}
 
 	function blnUpdateData($arrValuePairs, $strFieldName, $strValue)
	{		
		$sqlUpdate = 'UPDATE '.$this -> m_strTableName.' SET ';
		foreach($arrValuePairs as $key => $value)
		{
			 $sqlUpdate .= $key.' = "'.$value.'",';
		}
		print $sqlUpdate 	= substr_replace($sqlUpdate, '', -1, 1);
		print $sqlUpdate	.= ' WHERE '.$strFieldName .' = \''.$strValue.'\'';
		if ($rsInsert = mysqli_query($this->voidConnect(),$sqlUpdate))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	function strPopulateSelect($strFieldName, $strTableName, $strFieldValue, $strFieldLabel, $strWhere = '', $strFieldOrder = '', $strFieldSort = '', $strSelectedIndex = '', $strInitialValue = '', $strOthers = '')
	{
		$strContent = '';
		$strContent .= '<select name="'.$strFieldName.'" '.$strOthers.'>';
		if ($strInitialValue != '')
		{
			$strContent .= '<option value="">'.$strInitialValue.'</option>';
		}
		if ($strFieldOrder != '')
		{
			$strFieldOrder = ' ORDER BY '.$strFieldOrder;
			if ($strFieldSort == 'DESC' || $strFieldSort == 'ASC')
			{
				$strFieldOrder .= ' '.$strFieldSort;
			}
			else
			{
				$strFieldOrder .= ' ASC';
			}
		}
		$rsData = mysqli_query("SELECT ".$strFieldLabel.", ".$strFieldValue." FROM ".$strTableName." ".$strWhere.$strFieldOrder);
		while ($rowData = mysqli_fetch_assoc($rsData))
		{
			if ($rowData[$strFieldValue] == $strSelectedIndex)
			{
				$strContent .= '<option value="'.$rowData[$strFieldValue].'" selected>'.$rowData[$strFieldLabel].'</option>';
			}
			else
			{
				$strContent .= '<option value="'.$rowData[$strFieldValue].'">'.$rowData[$strFieldLabel].'</option>';
			}
		}
		$strContent .= '</select>';
		return $strContent;
	}
	
	function strPopulateSelectSql($strFieldName, $sqlStatement, $strFieldValue, $strFieldLabel, $strSelectedIndex = '', $strInitialValue = '', $strOthers = '')
	{		
	    //$mysql_link = $this -> voidConnect($this -> m_strDbPassword);
	    $strContent = '';
		$strContent .= '<select name="'.$strFieldName.'" '.$strOthers.'>';
		if ($strInitialValue != '')
		{
			$strContent .= '<option value="">'.$strInitialValue.'</option>';
		}
		
		//$mysql_link = mysqli_connect("localhost","root","","dbJarvis");
		$rsData = mysqli_query($this -> voidConnect() , $sqlStatement);
		while ($rowData = mysqli_fetch_assoc($rsData))
		{
			if ($rowData[$strFieldValue] == $strSelectedIndex)
			{
				$strContent .= '<option value="'.$rowData[$strFieldValue].'" selected>'.$rowData[$strFieldLabel].'</option>';
			}
			else
			{
				$strContent .= '<option value="'.$rowData[$strFieldValue].'">'.$rowData[$strFieldLabel].'</option>';
			}
		}
		$strContent .= '</select>';
		return $strContent;
	}
	function strPopulateSelectArray($strFieldName, $arrData, $strSelectedValue = '', $strInitialValue = '', $strOthers = '')
	{	
		$strContent = '';
		$strContent .= '<select name="'.$strFieldName.'" '.$strOthers.'>';
		if ($strInitialValue != '')
		{
			$strContent .= '<option value="">'.$strInitialValue.'</option>';
		}
		
		$rsData = mysqli_query($sqlStatement);
		foreach($arrData as $strData)
		{
			if ($strData == $strSelectedValue)
			{
				$strContent .= '<option value="'.$strData.'" selected>'.$strData.'</option>';
			}
			else
			{
				$strContent .= '<option value="'.$strData.'">'.$strData.'</option>';
			}
		}
		$strContent .= '</select>';
		return $strContent;
	}
	
	function strPopulateSelectTree($strFieldName, $strTableName, $strFieldValue, $strFieldLabel, $strParentField, $strParentValue, $strWhere = '', $strFieldOrder = '', $strFieldSort = '', $strSelectedIndex = '', $strInitialValue = '', $strJavascriptTag = '', $strDepth = '', $strOthers = '', $intStart = 0) 
	{
		static $s_strContent;
		static $s_intNumRows, $s_intCounter, $s_strParentDefault;
		
		$strDepth 	  .= '&nbsp;&nbsp;';
		$strFieldOrderTag = '';
		$strWhereTag = '';
		if ($intStart == 0)
		{
			$s_strContent  = '';
			$s_strContent = '<select name="'.$strFieldName.'" '.$strJavascriptTag.' '.$strOthers.'>'.$s_strContent;
			if ($strInitialValue != '')
			{
				$s_strContent .= '<option value="">'.$strInitialValue.'</option>';
			}
			$s_intNumRows = 0;
			$s_strParentDefault = $strParentValue;
			$intStart++;
		}
		else
		{
			$intStart++;
		}
		if ($strFieldOrder != '')
		{
			$strFieldOrderTag = ' ORDER BY '.$strFieldOrder;
			if ($strFieldSort == 'DESC' || $strFieldSort == 'ASC')
			{
				$strFieldOrderTag .= ' '.$strFieldSort;
			}
			else
			{
				$strFieldOrderTag .= ' ASC';
			}
		}
		if ($strWhere != '')
		{
			$strWhereTag = $strWhere.' AND '. $strParentField . ' = \''.$strParentValue.'\'';
		}
		else
		{
			$strWhereTag = ' WHERE '. $strParentField . ' = \''.$strParentValue.'\'';
		}
		$strDelimeter = '';
		if (is_array($strFieldLabel))
		{
			$arrFieldLabel = $strFieldLabel;
			$intCount = count($arrFieldLabel);
			$intLastIndex = $intCount - 1;
			$strDelimeter = $arrFieldLabel[$intLastIndex];
			unset($arrFieldLabel[$intLastIndex]);
			$strSqlFieldLabel = implode(',', $arrFieldLabel);
		}
		else
		{
			$strSqlFieldLabel = $strFieldLabel;
		}
		$rsData = $this -> blnExecute("SELECT ".$strSqlFieldLabel.", ".$strFieldValue." FROM ".$strTableName." ".$strWhereTag.$strFieldOrderTag );
		if ($s_intNumRows == 0)
		{
			$s_intNumRows = mysqli_num_rows($rsData);
			$s_intCounter = 0;
		}
		while ($rowData = mysqli_fetch_assoc($rsData))
		{
			$strStyleTag = '';
			if ($s_strParentDefault == $strParentValue)
			{
				$strStyleTag = "style='background-color: #cccccc'";
				
			}
			$strLabel = '';
			if (is_array($strFieldLabel))
			{
				for($i = 0; $i < ($intCount - 1); $i++)
				{
					$strLabel .= $rowData[$arrFieldLabel[$i]];
					if ($i != ($intCount - 2))
					{
						$strLabel .= $strDelimeter;
					}
				}
			}
			else
			{
				$strLabel = $rowData[$strFieldLabel];
			}
			if ($rowData[$strFieldValue] == $strSelectedIndex) 
			{
				$s_strContent .= '<option value="'.$rowData[$strFieldValue].'" '.$strStyleTag.' selected>'.$strDepth.'&raquo; '.$strLabel.'</option>';
			}
		    else 
			{
				$s_strContent .= '<option value="'.$rowData[$strFieldValue].'" '.$strStyleTag.'>'.$strDepth.'&raquo; '.$strLabel.'</option>';
			}
			$this -> strPopulateSelectTree($strFieldName, $strTableName, $strFieldValue, $strFieldLabel, $strParentField, $rowData[$strFieldValue], $strWhere, $strFieldOrder, $strFieldSort, $strSelectedIndex, $strInitialValue, $strJavascriptTag, $strDepth, $strOthers, $intStart);
			if ($s_strParentDefault == $strParentValue)
			{
				$s_intCounter++;
			}
		}
		if ($s_intNumRows == $s_intCounter)
		{
			$s_strContent .= '</select>';
		}
		return $s_strContent;
	}

	function strPopulateArray($strSql, $strArrayName, $strIndex, $arrElements)
	{
		$strContents = '';
		$strContents = $strArrayName." = new Array() \n";
		$arrIndex = array();
		$rsData = $this -> blnExecute($strSql);
		while ($rowData = mysqli_fetch_assoc($rsData))
		{
			if (is_array($arrElements))
			{
				if (!in_array($rowData[$strIndex], $arrIndex))
				{
					$strContents .= $strArrayName."['".$rowData[$strIndex]."'] = new Array() \n";
					array_push($arrIndex, $rowData[$strIndex]);
				}
				foreach($arrElements as $key => $value)
				{
					$strContents .= $strArrayName."['".$rowData[$strIndex]."']['".$key."'] = '".$rowData[$value]."' \n";
				}
			}
			else
			{
				$strContents .= $strArrayName."['".$rowData[$strIndex]."'] = '".$rowData[$arrElements]."'\n";
			}
		}
		return $strContents;
	}
	
	function strSqlPopulateSelect($strFieldName, $strSql, $strFieldValue, $strFieldLabel, $strSelectedIndex = '', $strInitialValue = '', $strOthers = '')
	{	
		$strContent = '';
		$strContent .= '<select name="'.$strFieldName.'" '.$strOthers.'>';
		if ($strInitialValue != '')
		{
			$strContent .= '<option value="">'.$strInitialValue.'</option>';
		}
		
		$rsData = $this -> blnExecute($strSql);
		while ($rowData = mysqli_fetch_assoc($rsData))
		{
			if ($rowData[$strFieldValue] == $strSelectedIndex)
			{
				$strContent .= '<option value="'.$rowData[$strFieldValue].'" selected>'.$rowData[$strFieldLabel].'</option>';
			}
			else
			{
				$strContent .= '<option value="'.$rowData[$strFieldValue].'">'.$rowData[$strFieldLabel].'</option>';
			}
		}
		$strContent .= '</select>';
		return $strContent;
		
		
	}
	
 	function voidPopulateSelect($strSql, $strValue, $strName, $strSelectedIndex = '')
	{
		if ($rsData = mysqli_query($strSql))
		{
			while ($rowData = mysqli_fetch_assoc($rsData))
			{
				if ($strSelectedIndex == $rowData[$strValue])
				{
					print '<option value="'.$rowData[$strValue].'" selected>'.$rowData[$strName].'</option>';
				}
				else
				{
					print '<option value="'.$rowData[$strValue].'">'.$rowData[$strName].'</option>';
				}
			}
		}
	}
	
	function strGetSqlStringTree($strTableName, $strFieldName, $strParentFieldName, $strParentValue, $intCount = 0)
	{
		if ($intCount == 0)
		{
			$this -> m_strSqlString = '';
		}
		$intCount++;
		$sqlData = "SELECT ".$strFieldName." FROM ".$strTableName."
					   WHERE ".$strParentFieldName." = '".$strParentValue."'";
		if ($rsData = mysqli_query($sqlData))
		{
			while ($rowData = mysqli_fetch_assoc($rsData))
			{
				$this -> m_strSqlString .= "'".$rowData[$strFieldName]."',";
				$this -> strGetSqlStringTree($strTableName, $strFieldName, $strParentFieldName, $rowData[$strFieldName], $intCount);
			}
		}
		return substr_replace(trim($this -> m_strSqlString), '', -1, 1);
	}

	function voidSelectDbIrep()
	{
		$connDB = mysqli_connect(AD_DB_HOST, AD_DB_USER, AD_DB_PASSWD) or die('Could not connect!');
		$connDBSelect = mysqli_select_db(AD_DB_NAME, $connDB) or die('Could not select database!');
	}

	function voidSelectDbIrepAdmin()
	{	
		$connDB = mysqli_connect(AD_DB_HOST, AD_DB_USER, AD_DB_PASSWD) or die('Could not connect!');
		$connDBSelect = mysqli_select_db(AD_DB_ADMIN_NAME, $connDB) or die('Could not select database!');
	}

		/**
	 *Function: GetOptionList($strTable,$strIdColumn='',$strNameColumn,$strDefaultValue = '',$strCriteria = '')
	 *Input:	string $strTable
	 *			string $strIdColumn (optional)
	 *			string $strNameColumn
	 *			string $strDefaultValue (optional)
	 *			string $strCriteria (optional)
	 *
	 *Output:	string
	 *
	 *Example:
	 *1. GetOptionList('users','userid','lastname',$_POST['select'])
	 *		-creates a drop down list with the lastname column as the display value, the userid will be the list value, 
	 *		the default value selected will be the userid matching the value of the $_POST['select']
	 *
	 *The GetOptionList function creates an option list for the HTML select input type. It must be enclosed in a <select></select>
	 *tags. The user must explicitly print or echo the string value return by this function. It accepts two required parameters:
	 *the table name and the column for the display values. The id column will be matched to the name column if one is provided.
	 *If a matching value from the id column and default value parameter is found, the row will be automatically displayed. 
	 *The criteria can be used for including a WHERE clause, table joins or a combination of both.
	 */
	function GetOptionList($strTable,$strIdColumn='',$strNameColumn,$strDefaultValue = '',$strCriteria = '')
	{
		$value = '';
		
		$strQuery = 'select ' . (!empty($strIdColumn) ? $strIdColumn . ', '  : '') . $strNameColumn . ' from ' . $strTable;
		if (!empty($strCriteria))
			$strQuery .= ' ' . $strCriteria;
		$result = mysqli_query($strQuery);
		$strError = mysqli_error();
		if (empty($strError) && mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_array($result))
			{
				if (!empty($strIdColumn))
					$id = strpos($strIdColumn,'.') > 0 ? substr($strIdColumn,strpos($strIdColumn,'.')+1) : $strIdColumn;
				
				$name = strpos($strNameColumn,'.') > 0 ? substr($strNameColumn,strpos($strNameColumn,'.')+1) : $strNameColumn;
				
				$value .= '<option ' . (!empty($strIdColumn) ? 'value="' . $row[$id] . '"' . ($strDefaultValue == $row[$id] ? ' selected="selected"' : '') : '') . '>' . htmlentities($row[$name]) . '</option>' . "\n";
			}
		}
		else
		{
			$value = '<option value="0">no item selected</option>' . "\n";
		}
	
		return $value;
	}
	
}
?>