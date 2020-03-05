<?php
require_once ('database.class.php');

Class Filters Extends MySqlDb
{
	var $m_strQueryStringFilter;
	var $m_arrFilter = array();
	var $m_arrSelectedFilter = array();
	var $m_arrSelectedFilterChoices = array();
	var $m_strNoFilterChecked = 'checked';
	var $m_strDefaultFilter;
	var $m_strDefaultFilterChoice;
	var $m_strFilterUrl;


	function voidSetFilterField($strFieldName, $strValue, $strLabel)
	{
		$this -> m_arrFilter[$strFieldName] = array();			
		$this -> m_arrFilter[$strFieldName]['value']   = $strValue;			
		$this -> m_arrFilter[$strFieldName]['label']   = $strLabel;			
		$this -> m_arrFilter[$strFieldName]['layer']   = '';			
	}

	function voidSetFilterChoices()
	{
		$arrArgs = func_get_args();
		$strFieldName = $arrArgs[0];
		$strType = $arrArgs[1];
		if (isset($arrArgs[2]))
		{
			$arrKeyValues[0] = $arrArgs[2];
		}
		if (isset($arrArgs[3]))
		{
			$arrKeyValues[1] = $arrArgs[3];
		}
		switch($strType)
		{
			case 'radio':
				$strDisplay = '';
				$strChecked = '';
				($this -> m_strDefaultFilter == $strFieldName)?($strDisplay = 'display'):($strDisplay = 'none');
				$this -> m_arrFilter[$strFieldName]['layer'] = '<span id="lyr_'.$strFieldName.'">';
				foreach($arrKeyValues[0] as $key => $value)
				{
					($key == $this -> m_arrSelectedFilterChoices[$strFieldName])?($strChecked = 'checked'):($strChecked = '');
					$this -> m_arrFilter[$strFieldName]['layer'] .= '<input type="radio" name="'.$strFieldName.'Choice" value="'.$key.'" '.$strChecked.'> '.$value.'&nbsp; ';
				}
				break;				
			case 'select':
				$strDisplay = '';
				$strSelected = '';
				($this -> m_strDefaultFilter == $strFieldName)?($strDisplay = 'display'):($strDisplay = 'none');
				$this -> m_arrFilter[$strFieldName]['layer'] = '<span id="lyr_'.$strFieldName.'">';
				$this -> m_arrFilter[$strFieldName]['layer'] .= '<select name="'.$strFieldName.'Choice" style="width: 200px">';
				foreach($arrKeyValues[0] as $key => $value)
				{
					($key == $this -> m_arrSelectedFilterChoices[$strFieldName])?($strSelected = 'selected'):($strSelected = '');
					$this -> m_arrFilter[$strFieldName]['layer'] .= '<option value="'.$key.'" '.$strSelected.'> '.$value.'</option>';
				}
				$this -> m_arrFilter[$strFieldName]['layer'] .= '</select>';
				break;				
			case 'fullsqlselect':
				$strDisplay = '';
				($this -> m_strDefaultFilter == $strFieldName)?($strDisplay = 'display'):($strDisplay = 'none');
				$this -> m_arrFilter[$strFieldName]['layer'] = '<span id="lyr_'.$strFieldName.'">';
				$this -> m_arrFilter[$strFieldName]['layer'] .= $this -> strSqlPopulateSelect($strFieldName.'Choice', $arrKeyValues[0][0], $arrKeyValues[0][1], $arrKeyValues[0][2], $this -> m_arrSelectedFilterChoices[$strFieldName], $arrKeyValues[0][3]);				
				break;				
			case 'sqlselect':
				$strDisplay = '';
				($this -> m_strDefaultFilter == $strFieldName)?($strDisplay = 'display'):($strDisplay = 'none');
				$this -> m_arrFilter[$strFieldName]['layer'] = '<span id="lyr_'.$strFieldName.'">';
				$this -> m_arrFilter[$strFieldName]['layer'] .= $this -> strPopulateSelect($strFieldName.'Choice', $arrKeyValues[0][0], $arrKeyValues[0][1], $arrKeyValues[0][2], $arrKeyValues[0][3], $arrKeyValues[0][4], $arrKeyValues[0][5], $this -> m_arrSelectedFilterChoices[$strFieldName], $arrKeyValues[0][6], ' style="width: 200px"');				
				break;				
			case 'sqlselecttree':
				$strDisplay = '';
				($this -> m_strDefaultFilter == $strFieldName)?($strDisplay = 'display'):($strDisplay = 'none');
				$this -> m_arrFilter[$strFieldName]['layer'] = '<span id="lyr_'.$strFieldName.'">';
				$this -> m_arrFilter[$strFieldName]['layer'] .= $this -> strPopulateSelectTree($strFieldName.'Choice', $arrKeyValues[0][0], $arrKeyValues[0][1], $arrKeyValues[0][2], $arrKeyValues[0][3], $arrKeyValues[0][4], $arrKeyValues[0][5], $arrKeyValues[0][6], $arrKeyValues[0][7], $this -> m_arrSelectedFilterChoices[$strFieldName], $arrKeyValues[0][8], ' style="width: 200px"');				
				break;
			case 'daterange':
				$strDisplay = '';
				($this -> m_strDefaultFilter == $strFieldName)?($strDisplay = 'display'):($strDisplay = 'none');
				$this -> m_arrFilter[$strFieldName]['layer'] = '<span id="lyr_'.$strFieldName.'">';
				$this -> m_arrFilter[$strFieldName]['layer'] .= $this -> strGetDateRange($strFieldName.'Choice');				
				break;
			default:
				break;			
		}
	}
	
	function strGetDateRange($strFieldName)
	{
		$strContent = '<input name="'.$strFieldName.'[]" value="'.$this -> m_arrSelectedFilterChoices[$strFieldName][0].'" size="11" onfocus="this.blur()" readonly>
                       <a href="javascript:void(0)" onclick="gfPop.fStartPop(document.frmFilter.elements[\''.$strFieldName.'[]\'][0], document.frmFilter.elements[\''.$strFieldName.'[]\'][1]);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/button_calendar.gif" width="34" height="22" border="0" alt=""></a> 
						to 
						<input name="'.$strFieldName.'[]" value="'.$this -> m_arrSelectedFilterChoices[$strFieldName][1].'" size="11" onfocus="this.blur()" readonly>
						<a href="javascript:void(0)" onclick="gfPop.fEndPop(document.frmFilter.elements[\''.$strFieldName.'[]\'][0], document.frmFilter.elements[\''.$strFieldName.'[]\'][1]);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/button_calendar.gif" width="34" height="22" border="0" alt=""></a>';
		return $strContent;
	}
	
	function voidSetFilterSelectedChoices($arrVars)
	{
		foreach($arrVars['chkFilter'] as $key => $value)
		{
			array_push($this -> m_arrSelectedFilter, $value);
			$strChoiceName = $value.'Choice';
			$strChoice = $arrVars[$strChoiceName];
			$this -> m_arrSelectedFilterChoices[$value] = $strChoice;
		}
	}
	
	function voidSetAddQueryString($strAdd)
	{
		$this -> m_strQueryStringAdd = $strAdd;
	}

	function voidSetListQueryString($strList)
	{
		$this -> m_strQueryStringList = $strList;
	}

	function voidSetFilterQueryString($strFilter)
	{
		$this -> m_strQueryStringFilter = $strFilter;
	}
	
	function voidDisplayFilterField()
	{
		$intCounter = 0;
		$strChecked = '';
		$strNoFilterChecked = 'checked';
		print '<table border="0" cellpadding="2" cellspacing="1">';
		print '<tr>';
		foreach($this -> m_arrFilter as $key => $value)
		{
			if (in_array($key, $this -> m_arrSelectedFilter))
			{
				$strChecked = 'checked';
				$strNoFilterChecked = '';
			}
			else
			{
				$strChecked = '';
			}
			print '<td valign="top">';
			print '<input type="checkbox" name="chkFilter[]" value="'.$key.'"'.$strChecked.'>'.$this -> m_arrFilter[$key]['label'];
			print '</td><td valign="top">';
			print $this -> m_arrFilter[$key]['layer'];
			print '</td><td width="10"></td>';
			$intCounter++;
			if ($intCounter == 2)
			{
				print '</tr><tr>';
				$intCounter = 0;
			}
		}
		print '</table>';
	}

	function intSaveFilters($arrVars, $intModuleId)
	{
		$sqlFilters = 'INSERT INTO tblFilters (femEmployeeNo, fmoId, ffiName) VALUES(\''.$_SESSION['strEmpNo'].'\',\''.$intModuleId.'\',\''.$arrVars['txtFilterName'].'\')';
		$rsFilters = mysql_query($sqlFilters);
		$intFilterId = mysql_insert_id();
		foreach($arrVars['chkFilter'] as $key => $value)
		{
			$strChoice = trim($value).'Choice';
			$strChoiceValue = $arrVars[$strChoice];
			$sqlSubFilters = 'INSERT INTO tblSubFilters (ffiId, fsfFilterChoice, fsfFilterChoiceValue) VALUES(\''.$intFilterId.'\',\''.$value.'\',\''.$strChoiceValue.'\')';
			$rsSubFilters = mysql_query($sqlSubFilters);
		}
		return $intFilterId;
	}

	function arrLoadFilters($intFilterId)
	{
		$arrFilters = array(); 
		$arrFilters['chkFilter'] = array();
		$sqlFilters = 'SELECT * FROM tblSubFilters WHERE ffiId = \''.$intFilterId.'\'';
		if ($rsFilters = mysql_query($sqlFilters))
		{
			while ($rowFilters = mysql_fetch_array($rsFilters))
			{
				array_push($this -> m_arrSelectedFilter, $rowFilters['fsfFilterChoice']);
				array_push($arrFilters['chkFilter'], $rowFilters['fsfFilterChoice']);
				$this -> m_arrSelectedFilterChoices[$rowFilters['fsfFilterChoice']] = $rowFilters['fsfFilterChoiceValue'];
				$strChoice = $rowFilters['fsfFilterChoice'].'Choice';
				$arrFilters[$strChoice] = $rowFilters['fsfFilterChoiceValue'];
			}
		}
		return $arrFilters;
	}

}	
?>