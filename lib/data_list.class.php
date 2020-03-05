<?php
Class DataList extends MySqlDb
{
	var $m_strSql;
	var $m_strSqlCount;
	
	var $m_arrColumnHeaders = array();
	var $m_arrColumnValues = array();
	var $m_arrColumnIsSort = array();
	var $m_arrColumnOrderVars = array();
	var $m_arrColumnSortIcon = array();
	var $m_strIconAsc = '';
	var $m_strIconDesc = ''; 
	var $m_intMaxPages = 10;
	var $m_arrMainDeleteTables = array();
	var	$m_strDefaultFieldOrder;
	var	$m_strDefaultSqlOrder;
	var	$m_intDisplayLimit;
	var	$m_strStyleHeader;
	var	$m_strStyleHeaderSel;
	var	$m_strStyleHeaderLinks;
	var	$m_strStyleHeaderLinksSel;
	var	$m_strStyleRowData;
	var	$m_strStyleRowDataOver;
	var	$m_strStylePageNumLinks;
	var	$m_strSetStylePage;
	var $m_intDisplayStart = 0;
	var $m_blnIsDelete;
	var $m_strCurrentSort;
	var $m_strUrl;
	var $m_arrColumnHeader;
	var $m_arrColumnOrderSqlField = array();
	var	$m_strFormTagStart;
	var	$m_strFormTagEnd;
	var	$m_strFields;
	var $m_arrDelDependentTables = array();
	var	$m_strMsg;
	var $m_arrTableProps = array();
	var $m_arrColumnWidth = array();	
	var $m_arrColumnHeaderAlignment = array();	
	var $m_arrColumnValueAlignment = array();	
	var $m_strNoEntryText;	
	var $m_strNoEntryStyle;	
	var $m_intPage;
	var $m_intAllData;
	var $m_strUrlPageNumber;
	var $m_strButton;
	var $m_strDropdownTable;
	var $m_strDropdownId;
	var $m_strDropdownName;
	var $m_strSelectTable;
	var $m_strSelectId;
	var $m_strSelectName;
	
	var $m_blnEditEnable = false;
	var $m_strEditFormFieldId;
	var $m_arrEditFormColumnFieldType = array();
	var $m_intPopolateId;
	var $m_intPopulateName;
	
	/***************************************************************************
	 *	voidSetDropdownField					                                 		
	 *	Sets the SQL statement to execute that will populate the data list                                 		
	 *																			
	 *	@param string $strSql - SQL statement to execute										
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetDropdownField($strTable,$strId,$strName)
	{
		$this -> m_strDropdownTable = $strTable;
		$this -> m_strDropdownId = $strId;
		$this -> m_strDropdownName = $strName;

	}

	/***************************************************************************
	 *	voidSetSelectField					                                 		
	 *	Sets the SQL statement to execute that will populate the data list                                 		
	 *																			
	 *	@param string $strSql - SQL statement to execute										
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetSelectField($strTable,$strId,$strName)
	{
		$this -> m_strSelectTable = $strTable;
		$this -> m_strSelectId = $strId;
		$this -> m_strSelectName = $strName;

	}
	
	/***************************************************************************
	 *	voidSetSql					                                 		
	 *	Sets the SQL statement to execute that will populate the data list                                 		
	 *																			
	 *	@param string $strSql - SQL statement to execute										
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetSql($strSql) 
	{
		$this -> m_strSql = $strSql;
	}


	function voidSetSqlCount($strSqlCount) 
	{
		$this -> m_strSqlCount = $strSqlCount;
	}

	/***************************************************************************
	 *	voidSetColumnHeader					                                 		
	 *	Sets the the header name that will appear on each column of the data list                                 		
	 *  																			
	 *	@param array/string $arrColumnHeaders - names to display on each column
	 *  	if array, name is displayed according to the order of values of the array,
	 * 		if string, the name is displayed on the $intColumnIndex position
	 *		column index starts at 0
	 *	@param integer $intColumnIndex what column the name will be displayed
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetColumnHeader($arrColumnHeaders, $intColumnIndex = '0')
	{
		if (is_array($arrColumnHeaders))
		{
			foreach($arrColumnHeaders as $key => $value)
			{
				$this -> m_arrColumnHeaders[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnHeaders) && $intColumnIndex)
		{
			$this -> m_arrColumnHeaders[$intColumnIndex] = $arrColumnHeaders;
 		}  
	}

	/***************************************************************************
	 *	voidSetColumnValues					                                 		
	 *	Sets the the values that will appear on each column of the data list                                 		
	 *  																			
	 *	@param array/string $arrColumnValues - values to display on each column
	 *  	if array, value is displayed according to the order of values of the array,
	 * 		if string, the value is displayed on the $intColumnIndex position
	 *		column index starts at 0
	 *	@param integer $intColumnIndex what column the value will be displayed
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetColumnValues($arrColumnValues, $intColumnIndex = '')
	{
		if (is_array($arrColumnValues))
		{
			foreach($arrColumnValues as $key => $value)
			{				
				$this -> m_arrColumnValues[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnValues) && $intColumnIndex)
		{
			$this -> m_arrColumnValues[$intColumnIndex] = $arrColumnValues;
 		}  
	}

	/***************************************************************************
	 *	voidSetColumnOrderVars					                                 		
	 *	Sets the the basis of sorting of each column of the data list                                 		
	 *  																			
	 *	@param array/string $arrColumnOrderVars - order value of each column
	 *	@param integer $intColumnIndex what column the sorting will be assigned to
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetColumnOrderVars($arrColumnOrderVars, $intColumnIndex = '')
	{
		if (is_array($arrColumnOrderVars))
		{
			foreach($arrColumnOrderVars as $key => $value)
			{
				$this -> m_arrColumnOrderSqlField[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnOrderVars) && $intColumnIndex)
		{
			$this -> m_arrColumnOrderSqlField[$intColumnIndex] = $arrColumnOrderVars;
 		}  
	}


	
	/***************************************************************************
	 *	voidSetEditFormColumnFieldType					                                 		
	 *	Sets the filed type of each column                                 		
	 *  																			
	 *	@param array/string $arrColumnFieldTypes - order value of each column
	 *	@param integer $intColumnIndex what column the field should be applied
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetEditFormColumnFieldType($arrColumnFieldTypes, $intColumnIndex = '')
	{
		if (is_array($arrColumnFieldTypes))
		{
			foreach($arrColumnFieldTypes as $key => $value)
			{
				$this -> m_arrEditFormColumnFieldType[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnFieldTypes) && $intColumnIndex)
		{
			$this -> m_arrEditFormColumnFieldType[$intColumnIndex] = $arrColumnFieldTypes;
 		}  
	}
	
	/***************************************************************************
	 *	voidSetColumnWidth					                                 		
	 *	Sets the the width of each column of the data list                                 		
	 *  																			
	 *	@param array/string $arrColumnWidth - column widths
	 *  	if array, width is in the order of values of the array,
	 * 		if string, the width of the $intColumnIndex position
	 *		column index starts at 0
	 *	@param integer $intColumnIndex what column does the specified width is assigned to 
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetColumnWidth($arrColumnWidth, $intColumnIndex = '0')
	{
		if (is_array($arrColumnWidth))
		{
			foreach($arrColumnWidth as $key => $value)
			{
				$this -> m_arrColumnWidth[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnWidth) && $intColumnIndex)
		{
			$this -> m_arrColumnWidth[$intColumnIndex] = $arrColumnHeaders;
 		}  
	}

	/***************************************************************************
	 *	voidSetColumnHeaderAlignment					                                 		
	 *	Sets the the alignment of each column of the data list                                 		
	 *  																			
	 *	@param array/string $arrColumnAlignment - column alignment
	 *  	if array, alignment is in the order of values of the array,
	 * 		if string, the alignment of the $intColumnIndex position
	 *		column index starts at 0
	 *	@param integer $intColumnIndex what column does the specified alignment is assigned to 
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetColumnHeaderAlignment($arrColumnAlignment, $intColumnIndex = '0')
	{
		if (is_array($arrColumnAlignment))
		{
			foreach($arrColumnAlignment as $key => $value)
			{
				$this -> m_arrColumnHeaderAlignment[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnAlignment) && $intColumnIndex)
		{
			$this -> m_arrColumnHeaderAlignment[$intColumnIndex] = $arrColumnHeaders;
 		}  
	}

	/***************************************************************************
	 *	voidSetColumnValueAlignment					                                 		
	 *	Sets the the alignment of each column of the data list                                 		
	 *  																			
	 *	@param array/string $arrColumnAlignment - column alignment
	 *  	if array, alignment is in the order of values of the array,
	 * 		if string, the alignment of the $intColumnIndex position
	 *		column index starts at 0
	 *	@param integer $intColumnIndex what column does the specified alignment is assigned to 
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetColumnValueAlignment($arrColumnValueAlignment, $intColumnIndex = '0')
	{
		if (is_array($arrColumnValueAlignment))
		{
			foreach($arrColumnValueAlignment as $key => $value)
			{
				$this -> m_arrColumnValueAlignment[$key] = $value;
			}
		}
		elseif (!is_array($arrColumnValueAlignment) && $intColumnIndex)
		{
			$this -> m_arrColumnValueAlignment[$intColumnIndex] = $arrColumnHeaders;
 		}  
	}

	/***************************************************************************
	 *	voidSetIconAsc					                                 		
	 *	Sets the path of the icon to display if the current sorting is ascending                                 		
	 *  																			
	 *	@param string $strIconPath - path of the icon
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetIconAsc($strIconPath)
	{
		$this -> m_strIconAsc = $strIconPath;
	}

	/***************************************************************************
	 *	voidSetIconDesc					                                 		
	 *	Sets the path of the icon to display if the current sorting is descending                                 		
	 *  																			
	 *	@param string $strIconPath - path of the icon
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetIconDesc($strIconPath)
	{
		$this -> m_strIconDesc = $strIconPath;
	}
	
	/***************************************************************************
	 *	voidSetDefaultOrder					                                 		
	 *	Sets the default order of the data list                                 		
	 *  																			
	 *	@param string $strDefaultFieldOrder - the basis of ordering (table field)
	 *	@param string $strDefaultSqlOrder - the default order(ASC or DESC)
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetDefaultOrder($strDefaultFieldOrder, $strDefaultSqlOrder)
	{
		$this -> m_strDefaultFieldOrder = $strDefaultFieldOrder;
		$this -> m_strDefaultSqlOrder = $strDefaultSqlOrder;		
	}

	/***************************************************************************
	 *	voidSetDisplayLimit					                                 		
	 *	Sets the display limit of the data list                                 		
	 *  																			
	 *	@param string $intLimit - the number of rows to display per page
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetDisplayLimit($intLimit)
	{
		$this -> m_intDisplayLimit = $intLimit;
	}

	/***************************************************************************
	 *	voidSetStyleHeader					                                 		
	 *	Sets the stylesheet class name of the column headers
	 *  																			
	 *	@param string $strStyleHeader - the class name to use if header is not selected
	 *	@param string $strStyleHeaderSel - the class name to use if header is selected
	 *		- if not specified it will take the value of $strStyleHeader
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetStyleHeader($strStyleHeader, $strStyleHeaderSel = '')
	{
		$this -> m_strStyleHeader    = $strStyleHeader;
		($strStyleHeaderSel != '')?($this -> m_strStyleHeaderSel = $strStyleHeaderSel):($this -> m_strStyleHeaderSel = $strStyleHeader);
	}

	/***************************************************************************
	 *	voidSetStyleHeaderLinks					                                 		
	 *	Sets the stylesheet class name of the column header links
	 *  																			
	 *	@param string $strSetStyleHeaderLinks - the class name to use if header is not selected
	 *	@param string $strSetStyleHeaderLinksSel - the class name to use if header is selected
	 *		- if not specified it will take the value of $strSetStyleHeaderLinks
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetStyleHeaderLinks($strSetStyleHeaderLinks, $strSetStyleHeaderLinksSel = '')
	{
		$this -> m_strStyleHeaderLinks    = $strSetStyleHeaderLinks;
		($strSetStyleHeaderLinksSel != '')?($this -> m_strStyleHeaderLinksSel = $strSetStyleHeaderLinksSel):($this -> m_strStyleHeaderLinksSel = $strSetStyleHeaderLinks);
	}

	/***************************************************************************
	 *	voidSetStyleRowData					                                 		
	 *	Sets the stylesheet class name of each row 
	 *  																			
	 *	@param string $strSetStyleRowData - the class name on each row
	 *	@param string $strSetStyleRowDataOver - the class name on each alternate row
	 *		- if not specified it will take the value of $strSetStyleRowData
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetStyleRowData($strSetStyleRowData, $strSetStyleRowDataOver = '')
	{
		$this -> m_strStyleRowData = $strSetStyleRowData;
		if ($strSetStyleRowDataOver != '')
		{
			$this -> m_strStyleRowDataOver = $strSetStyleRowDataOver;
		}
	}

	/***************************************************************************
	 *	voidSetStylePage					                                 		
	 *	Sets the stylesheet class name of the paging 
	 *  																			
	 *	@param string $strStylePage - the class name of paging portion
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetStylePage($strStylePage)
	{
		$this -> m_strStylePage = $strStylePage;
	}

	/***************************************************************************
	 *	voidSetStylePageNumLinks					                                 		
	 *	Sets the stylesheet class name of the paging links
	 *  																			
	 *	@param string $strSetStylePageNumLinks - the class name of each page link
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetStylePageNumLinks($strStylePageNumLinks)
	{
		$this -> m_strStylePageNumLinks = $strStylePageNumLinks;
	}

	/***************************************************************************
	 *	voidSetNoEntry					                                 		
	 *	Sets the stylesheet class name of each row 
	 *  																			
	 *	@param string $strSetStyleRowData - the class name on each row
	 *	@param string $strSetStyleRowDataOver - the class name on each alternate row
	 *		- if not specified it will take the value of $strSetStyleRowData
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetNoEntry($strNoEntryText, $strNoEntryStyle = '')
	{
		$this -> m_strNoEntryText = $strNoEntryText;
		$this -> m_strNoEntryStyle = $strNoEntryStyle;
	}

	/***************************************************************************
	 *	voidSetTableProperties					                                 		
	 *	Sets the properties of the table
	 *  																			
	 *	@param array/string $arrProperties - array of table properties
	 *	@param string $strValue - value of given properties, in case $arrProperties
	 *		is string
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetTableProperties($arrProperties, $strValue = '')
	{
		if (is_array($arrProperties))
		{
			foreach($arrProperties as $key => $value)
			{
				$this -> m_arrTableProps[$key] = $value;
			}
		}
		elseif (!is_array($arrProperties) && $intColumnIndex)
		{
  			$this -> m_arrTableProps[$key] = $strValue;
 		}  
	}

	/***************************************************************************
	 *	voidSetForm					                                 		
	 *	Sets form if there is a need for form processing within the data list
	 *		example : delete selected items
	 *																			
	 *	@param string $strFormName - form name
	 *	@param string $strAction - the URL to call upon form submission
	 *	@param string $strMethod - method, default is POST
	 *	@return null                                                           	
	 **************************************************************************/
	function voidSetForm($strFormName, $strAction, $strMethod = 'post')
	{
		$this -> m_strFormTagStart = '<form name="'.$strFormName.'" method="'.$strMethod.'" action="../'.$strAction.'">';
		$this -> m_strFormTagEnd   = '</form>';
	}


	/***************************************************************************
	 *	voidEnableEditForm					                                 		
	 *	Enable the edit form of the list
	 *																			
	 *	@param none
	 *	@return null                                                           	
	 **************************************************************************/
	function voidEnableEditForm()
	{
		$this -> m_blnEditEnable = true;
	}

	function voidDisableEditForm()
	{
		$this -> m_blnEditEnable = false;
	}


	function voidSetEditFormFieldId($strFieldName)
	{
		$this -> m_strEditFormFieldId = $strFieldName;
	}



	/***************************************************************************
	 *	voidAddFormFields					                                 		
	 *	Sets additional form fields
	 *																			
	 *	@param array $arrFields - array of fields
	 *	@return null                                                           	
	 **************************************************************************/
	function voidAddFormFields($arrFields)
	{
		$this -> m_strFields = '';
		if (is_array($arrFields))
		{
			$this -> m_strFields = implode(' ',$arrFields);
		}
		else
		{
			$this -> m_strFields = $arrFields;
		}
	}

	/***************************************************************************
	 *	strGetUrl					                                 		
	 *	Get base URL given the full path
	 *		note : this function used internally
	 *																			
	 *	@param array $arrFields - array of fields
	 *	@return null                                                           	
	 **************************************************************************/
	function strGetUrl($strUrl) 
	{
		$arrUrl = explode('/', $strUrl);
		return $arrUrl[count($arrUrl)-1];
	}

	/***************************************************************************
	 *	voidDisplayDataList					                                 		
	 *	Display the result data listing
	 *																			
	 *	@param none
	 *	@return null                                                           	
	 **************************************************************************/
	function voidDisplayDataList()
	{
		$strContent = '';
		$strPageLinks = '';

		//get base url
		$this -> m_strUrl = $this -> strGetUrl($_SERVER['PHP_SELF']);

		//build query string
		$strRemainingUrl = '';
		if (isset($_SERVER['QUERY_STRING']))
		{
			$strUrl = urldecode($_SERVER['QUERY_STRING']);
			parse_str($strUrl, $arrQueryString);
			foreach($arrQueryString as $key => $value)
			{
				if (!in_array($key, array('srt','ordr','strt', 'pglnk')))
				{
					if (is_array($value))
					{
						$strUrlArray = '';
						foreach($value as $key1 => $value1)
						{
							$strUrlArray .= $key.'%5B%5D='.$value1.'&';
						}
						$strRemainingUrl .= $strUrlArray ;
					}
					else
					{
						$strRemainingUrl .= $key.'='.$value.'&';
					}
				}
			}
		}
		
		(isset($arrQueryString['ordr']))?($strOrder = $arrQueryString['ordr']):($strOrder = $this -> m_strDefaultFieldOrder);
		$strSqlOrder  = $this -> m_arrColumnOrderSqlField[$strOrder];
		if (isset($arrQueryString['srt']))
		{
			$strSort  = $arrQueryString['srt'];
			if ($strSort == 'd')
			{
				$strSqlSort  = 'DESC';
				$strNextSort = 'u';
			} 
			else
			{
				$strSqlSort  = 'ASC';
				$strNextSort = 'd';
			}
		}
		else
		{
			$strSqlSort  = $this -> m_strDefaultSqlOrder;
			if ($strSqlSort == 'DESC')
			{

				$strSqlSort  = 'DESC';
				$strSort     = 'd';
				$strNextSort = 'u';
			} 
			else
			{
				$strSqlSort  = 'ASC';
				$strSort     = 'u';
				$strNextSort = 'd';
			}
		}
		if (isset($arrQueryString['strt'])) 
		{
			$intStart = $arrQueryString['strt'];
			$intSqlStart = $intStart - 1;
		}
		else
		{
			$intStart = 1;
			$intSqlStart = 0;
		}
		if (isset($arrQueryString['pglnk'])) 
		{
			$intPage = $arrQueryString['pglnk'];
		}
		else
		{
			$intPage = 1;
		}
		
		if ($this -> m_strSqlCount != '')
		{
			$rsAllData = mysqli_query($this -> voidConnect(),$this -> m_strSqlCount);
			$rowAllData = mysqli_fetch_row($rsAllData);
			$intAllData = $rowAllData[0];
		}
		else
		{
		    $rsAllData = mysqli_query($this -> voidConnect(), $this -> m_strSql);
			$intAllData = mysqli_num_rows($rsAllData);
		}
		//get total rows without the limit
		$strSql = $this -> m_strSql.' ORDER BY '.$strSqlOrder.' '.$strSqlSort.
							' LIMIT '.$intSqlStart.','.$this -> m_intDisplayLimit;
		$rsData = mysqli_query($this -> voidConnect(),$strSql);
		//get total rows with the limit
		$intLimitedData = mysqli_num_rows($rsData);
		if ($intAllData == 0) 
		{	
			$strContent .= '<table width="0" align="0" border="0" cellpadding="0" cellspacing="0">
				  	<tr>
						<td colspan="2" align="left" valign="bottom">&nbsp;</td>
					</tr>
				  	<tr>
						<td colspan="2" align="left" valign="bottom" class="bold">
							<div class="'.$this -> m_strNoEntryStyle.'">'.$this -> m_strNoEntryText.'</div> 
						</td>
					</tr>
				  	<tr>
						<td height="10" colspan="2" align="left" valign="bottom"><img src="../images/spacer.gif" width="1" height="1"></td>
				  	</tr>
				</table>';
		}
		else
		{	
				if ($this -> m_strFormTagStart != '')
				{
					$strContent .= $this -> m_strFormTagStart;
				}
				$strContent .= '<table width="'.$this -> m_arrTableProps['width'].'" align="0" border="0" cellpadding="0" cellspacing="0">
						<tr>
        					<td align="left" valign="middle">'.$this -> m_strFields.'</td>
        					<td align="right" valign="middle" class="'.$this -> m_strStylePage.'">';
				$strTableProperties = '';
				foreach($this -> m_arrTableProps as $key => $value)
				{
					$strTableProperties .= ' '.$key.'="'.$value.'"';
				}
				$strContent .= $strPageLinks.'</td>
      					</tr>
      					<tr>
        					<td height="5" colspan="2" align="left" valign="top"><img src="../images/spacer.gif" width="1" height="1"></td>
      					</tr>
      					<tr>
        					<td colspan="2" align="left" valign="top">
								<table '.$strTableProperties.'>
									<tr >';
			foreach($this -> m_arrColumnHeaders as $key => $value)
			{
				($strSort == 'u') ? ($strIconSort = $this -> m_strIconAsc) : ($strIconSort = $this -> m_strIconDesc);
				if ($strOrder == $key)
				{
					if ($strIconSort != '')
					{
						$strThisSortIcon        = '<img src="'.$strIconSort.'" border="0" align="absmiddle">';
					}
					$strThisHeaderClassName = $this -> m_strStyleHeaderSel;
					$strThisLinksClassName	= $this -> m_strStyleHeaderLinksSel;
				}
				else
				{
					$strThisSortIcon = '';
					$strThisHeaderClassName = $this -> m_strStyleHeader;
					$strThisLinksClassName	= $this -> m_strStyleHeaderLinks;
				}
				if ($this -> m_arrColumnOrderSqlField[$key] != '')
				{
					$strContent .= '<td width="'.$this -> m_arrColumnWidth[$key].'" align="'.$this -> m_arrColumnHeaderAlignment[$key].'" class="'.$strThisHeaderClassName.'"><a href="'.$this -> m_strUrl.'?'.$strRemainingUrl.'ordr='.$key.'&srt='.$strNextSort.'" class="'.$strThisLinksClassName.'">'.$value.'&nbsp;'.$strThisSortIcon.'</a></td>';
				}
				else
				{
					$strContent .= '<td width="'.$this -> m_arrColumnWidth[$key].'" align="'.$this -> m_arrColumnHeaderAlignment[$key].'" class="'.$strThisHeaderClassName.'">'.$value.'&nbsp;</td>';
				}
			}
			$strContent .= '</tr>';
			$strStyleRowData = $this -> m_strStyleRowData;
			while ($rowData = mysqli_fetch_array($rsData))
			{	
				$strContent .= '<tr>';
				foreach($this -> m_arrColumnHeaders as $key => $value)
				{
				    
				    $arrTokens = explode('|OR|', $this -> m_arrColumnValues[$key]);
					/*$strValue = preg_replace("/(MYSQL_DATA::)([a-zA-Z0-9_]*)([^(::)]*)(::)/", 
					                       "\$rowData['\\2']", 
	              				 $this -> m_arrColumnValues[$key]); */
					$strValue = preg_replace_callback("/(MYSQL_DATA::)([a-zA-Z0-9_]*)([^(::)]*)(::)/",
					    function ($matches) { return  "\$rowData[$matches[2]]"; }, $this -> m_arrColumnValues[$key]);
					//aids to
					
					//if form edit is enable wrap value with span
					if ($this -> m_blnEditEnable)					
					{
						$strField = $this -> strGetEditFormField($this -> m_arrEditFormColumnFieldType[$key], $key, $rowData[$this -> m_strEditFormFieldId], $strValue);
						$strContent .= '<td align="'.$this -> m_arrColumnValueAlignment[$key].'" class="'.$strStyleRowData.'"><span id="lyr_'.$key.'_'.$rowData[$this -> m_strEditFormFieldId].'">'.$strValue.'</span>'.$strField.'</td>';
					}
					else
					{
						$strContent .= '<td align="'.$this -> m_arrColumnValueAlignment[$key].'" class="'.$strStyleRowData.'">'.$strValue.'</td>';					
					}
					
				}
				($strStyleRowData == $this -> m_strStyleRowData)?($strStyleRowData = $this -> m_strStyleRowDataOver):($strStyleRowData = $this -> m_strStyleRowData);
				$strContent .= '</tr>';
			}
			$strContent .= '</table>
					</td>
      			</tr>
      			<tr>
        			<td height="5" colspan="2" align="left" valign="top"><img src="../images/spacer.gif" width="1" height="1"></td>
      			</tr>
      			<tr >
   					<td align="left" valign="middle">'.$this -> m_strFields.'</td>
        			<td align="right" valign="middle" class="'.$this -> m_strStylePage.'">';
			$strContent .= $strPageLinks.'</td>
      			</tr>
    		</table>';
			if ($this -> m_strFormTagStart != '')
			{
				$strContent .= $this -> m_strFormTagEnd;
			}
		}
		print $strContent;
	}
	
	/***************************************************************************
	 *	voidDisplayPageNumber					                                 		
	 *	Display the page numbering
	 *																			
	 *	@param integer $intNumEntries - no of entries per pge
	 *	@param integer $intPage - number of page
	 *	@param integer $intStart - start number
	 *	@param integer $strUrl - url to of page links
	 *	@return null                                                           	
	 **************************************************************************/
	function voidDisplayPageNumber() 
	{
		//get base url
		$this -> m_strUrl = $this -> strGetUrl($_SERVER['PHP_SELF']);

		//build query string
		$strRemainingUrl = '';
		if (isset($_SERVER['QUERY_STRING']))
		{
			$strUrl = urldecode($_SERVER['QUERY_STRING']);
			parse_str($strUrl, $arrQueryString);
			foreach($arrQueryString as $key => $value)
			{
				if (!in_array($key, array('srt','ordr','strt', 'pglnk')))
				{
					if (is_array($value))
					{
						$strUrlArray = '';
						foreach($value as $key1 => $value1)
						{
							$strUrlArray .= $key.'%5B%5D='.$value1.'&';
						}
						$strRemainingUrl .= $strUrlArray ;
					}
					else
					{
						$strRemainingUrl .= $key.'='.$value.'&';
					}
				}
			}
		}
		
		(isset($arrQueryString['ordr']))?($strOrder = $arrQueryString['ordr']):($strOrder = $this -> m_strDefaultFieldOrder);
		if (isset($arrQueryString['srt']))
		{
			$strSort  = $arrQueryString['srt'];
		}
		else
		{
			$strSqlSort  = $this -> m_strDefaultSqlOrder;
			if ($strSqlSort == 'DESC')
			{
				$strSort     = 'd';
			} 
			else
			{
				$strSort     = 'u';
			}
		}
		$this -> m_strUrlPageNumber = $this -> m_strUrl.'?'.$strRemainingUrl.'ordr='.$strOrder.'&srt='.$strSort.'&';
		
		if (isset($arrQueryString['strt'])) 
		{
			$this -> m_intStart = $arrQueryString['strt'];
		}
		else
		{
			$this -> m_intStart = 1;
		}
		if (isset($arrQueryString['pglnk'])) 
		{
			$this -> m_intPage = $arrQueryString['pglnk'];
		}
		else
		{
			$this -> m_intPage = 1;
		}
 		if ($this -> m_strSqlCount != '')
 		{
			$rsAllData = mysqli_query($this -> voidConnect(),$this -> m_strSqlCount);
			$rowAllData = mysqli_fetch_row($rsAllData);
			$this -> m_intAllData = $rowAllData[0];
		}
		else
		{
			$rsAllData = mysqli_query($this -> m_strSql);
			$this -> m_intAllData = mysqli_num_rows($rsAllData);
		}
 	
		$strContents = '';
		//number of pages
		$intNumPages  = ceil($this -> m_intAllData / $this -> m_intDisplayLimit);
		//$intMidPage = ceil($this -> m_intMaxPages/2);
		$intIntervalPage = ceil($this -> m_intMaxPages/4);
		$intCurrPage = $this -> m_intPage;
		if ($this -> m_intStart== 1)
		{	
			$intStartPage = 1;
			$intLastNum   = 0;
		}
		else
		{
			($intCurrPage >= $intIntervalPage)?($intStartPage = $intCurrPage - ($intIntervalPage - 1)):($intStartPage = $intIntervalPage - $intCurrPage);
			($intStartPage == 1)?($intLastNum = 0):($intLastNum = (($intStartPage - 1) * $this -> m_intDisplayLimit));
		}
		//previous starting number
		$intPrevStart = $this -> m_intStart - $this -> m_intDisplayLimit;
		//initialize variables
		$intCurrStart = 1;
		$intCurrEnd   = $this -> m_intDisplayLimit;
		//if display is not on page 1, display First
		if ($intPrevStart > 0) 
		{
			$strContents .= '<a href="'.$this -> m_strUrlPageNumber.'pglnk=1&strt=1" class="'.$this -> m_strStylePageNumLinks.'">First</a>';
			$strContents .= ' ';
		}
		//set maximum page display, default is 10
		if ($this -> m_intMaxPages < $intNumPages)
		{			
			$intMaxPage = $intStartPage + $this -> m_intMaxPages - 1;
			if ($intMaxPage > $intNumPages)
			{
				$intMaxPage = $intNumPages;
				$intStartPage = $intMaxPage - $this -> m_intMaxPages + 1;
				$intLastNum = ($intStartPage - 1) * $this -> m_intDisplayLimit;			
			}
		}
		else
		{  
			$intMaxPage = $intNumPages;
		}
		for ($i = $intStartPage; $i <= $intMaxPage; $i++) 
		{
			//start number
			$intCurrStart = $intLastNum + 1;
			//end number
			$intCurrEnd = $intCurrStart + $this -> m_intDisplayLimit - 1;
			//if total no. of entries is less than the current end number, 
			//end number is the number of entries. ex: num of entries = 110, last num = 119 then end num = 110
			if ($this -> m_intAllData < $intCurrEnd) 
			{
				$intCurrEnd = $this -> m_intAllData;
			}
			//last number, to be used on the next start number. next start num = last num - 1
			$intLastNum = $intCurrEnd;
			//if we're on the page itself, display number without link
			if ($i == $this -> m_intPage) 
			{
				$strContents .= $i.' ';
			}
			else
			{
				//else display number as link
				if ($i == $intStartPage)
				{
					$intThisFirstStart = $this -> m_intStart - $this -> m_intDisplayLimit;
					$strContents .= '<a href="'.$this -> m_strUrlPageNumber.'pglnk='.($this -> m_intPage-1).'&strt='.$intThisFirstStart.'" class="'.$this -> m_strStylePageNumLinks.'">< </a> </b>';
				}
				$strContents .= '<a href="'.$this -> m_strUrlPageNumber.'pglnk='.$i.'&strt='.$intCurrStart.'" class="'.$this -> m_strStylePageNumLinks.'">'.$i.'</a> </b>';
				if ($i == $intMaxPage)
				{
					$intThisEndStart = $this -> m_intStart + $this -> m_intDisplayLimit;
					$strContents .= '<a href="'.$this -> m_strUrlPageNumber.'pglnk='.($this -> m_intPage-1).'&strt='.$intThisEndStart.'" class="'.$this -> m_strStylePageNumLinks.'">> </a> </b>';
				}
			}
		}
		$intEnd 	  = $this -> m_intStart + $this -> m_intDisplayLimit - 1;
		$intLastStart = (($intNumPages - 1) * $this -> m_intDisplayLimit) + 1;
		if ($intEnd < $this -> m_intAllData) 
		{
			$intCurrEnd = $intEnd;
			$strContents .= '<a href="'.$this -> m_strUrlPageNumber.'pglnk='.$intNumPages.'&strt='.$intLastStart.'" class="'.$this -> m_strStylePageNumLinks.'">Last</a>';
		}
		else
		{
			$intCurrEnd = $this -> m_intAllData;
		}
		$strContents = $this -> m_intStart.'-'.$intCurrEnd.' of '.$this -> m_intAllData.' &nbsp; '.$strContents;
		
		if ($this -> m_intAllData > 0)
		{
			print $strContents;
		}
	}

 	function strGetQueryString()
	{
		if (isset($_SERVER['QUERY_STRING']))
		{
			$strUrl = urldecode($_SERVER['QUERY_STRING']);
			parse_str($strUrl, $arrQueryString);
			foreach($arrQueryString as $key => $value)
			{
				if (!in_array($key, array('srt','ordr','strt', 'pglnk')))
				{
					if (is_array($value))
					{
						$strUrlArray = '';
						foreach($value as $key1 => $value1)
						{
							$strUrlArray .= $key.'%5B%5D='.$value1.'&';
						}
						$strRemainingUrl .= $strUrlArray ;
					}
					else
					{
						$strRemainingUrl .= $key.'='.$value.'&';
					}
				}
			}
		}
		return $strRemainingUrl;
	}
	
	function intGetNumberOfRows()
	{
		if (!$this -> m_intAllData)
		{
			if ($this -> m_strSqlCount != '')
			{
				$rsAllData = mysqli_query($this -> m_strSqlCount);
				$rowAllData = mysqli_fetch_row($rsAllData);
				$this -> m_intAllData = $rowAllData[0];
			}
			else
			{
				$rsAllData = mysqli_query($this -> m_strSql);
				$this -> m_intAllData = mysqli_num_rows($rsAllData);
			}
		}
		return $this -> m_intAllData;
	}
	
	function strGetEditFormField($strType, $strLayer, $strId, $strValue)
	{
		$strFormField = '';
		switch ($strType)
		{
			case 'textbox':
				$strFormField = '<input type="text" id="fld_'.$strLayer.'_'.$strId.'" name="fld_'.$strLayer.'_'.$strId.'" value="'.$strValue.'" style="display:none;">';
				break;
			case 'file':
					$strFormField = '<input type="file" id="fld_'.$strLayer.'_'.$strId.'" name="fld_'.$strLayer.'_'.$strId.'" value="'.$strValue.'" style="display:none;">';
				break;
			case 'dropdown':
			$sqlPopulate = 'SELECT * FROM '.$this -> m_strDropdownTable.'';
			if($rsPopulate = mysqli_query($sqlPopulate))
			{
					$strFormField = '<select id="fld_'.$strLayer.'_'.$strId.'" name="fld_'.$strLayer.'_'.$strId.'" style="display:none;"><option>::Select Position::</option>';
				while($rowPopulate = mysql_fetch_array($rsPopulate))
				{
				 $strFormField .= '<option value="'.$rowPopulate[$this -> m_strDropdownId].'">'.$rowPopulate[$this -> m_strDropdownName].'</option>';
				}					 
									$strFormField .= ' </select>';
			}						 
				break;

			case 'select':
			$sqlPopulate = 'SELECT * FROM '.$this -> m_strSelectTable.'';
			if($rsPopulate = mysqli_query($sqlPopulate))
			{
					$strFormField = '<select id="fld_'.$strLayer.'_'.$strId.'" name="fld_'.$strLayer.'_'.$strId.'" style="display:none;"><option>::Select Group::</option>';
				while($rowPopulate = mysql_fetch_array($rsPopulate))
				{
				 $strFormField .= '<option value="'.$rowPopulate[$this -> m_strSelectId].'">'.$rowPopulate[$this -> m_strSelectName].'</option>';
				}					 
									$strFormField .= ' </select>';
			}						 
				break;

		}
		
		return $strFormField;		
	}
	
	function voidDisplayEditFormJavascript()
	{
		print $javascript = "<script language=\"javascript\"> \n
					function voidShowEditForm(intId) \n
					{ \n";

		//hide all
		if (isset($arrQueryString['strt'])) 
		{
			$intStart = $arrQueryString['strt'];
			$intSqlStart = $intStart - 1;
		}
		else
		{
			$intStart = 1;
			$intSqlStart = 0;
		}	
			
		$strSql = $this -> m_strSql.' LIMIT '.$intSqlStart.','.$this -> m_intDisplayLimit;
		$rsData = mysqli_query($strSql);				
		while ($rowData = mysql_fetch_array($rsData))
		{
			foreach($this -> m_arrEditFormColumnFieldType as $key => $value)
			{
				print "this_layer = document.getElementById('lyr_".$key."_".$rowData[$this -> m_strEditFormFieldId]."') \n";
				print "this_layer.style.display = 'block' \n";
			
				print "this_field = document.getElementById('fld_".$key."_".$rowData[$this -> m_strEditFormFieldId]."') \n";
				print "this_field.style.display = 'none' \n";

				print "edit = document.getElementById('icon_edit_".$rowData[$this -> m_strEditFormFieldId]."')\n";
				
				print "edit.style.display = 'block'\n";				
				
				print "save = document.getElementById('icon_save_".$rowData[$this -> m_strEditFormFieldId]."')\n";
				
				print "save.style.display = 'none'\n";										
					
			}
		}

		//display selected
		foreach($this -> m_arrEditFormColumnFieldType as $key => $value)
		{
			print "lyr_".$key." = document.getElementById('lyr_".$key."_' + intId) \n";
			print "fld_".$key." = document.getElementById('fld_".$key."_' + intId) \n";
			print "icon_edit_".$key." = document.getElementById('icon_edit_' + intId) \n";			
			print "icon_save_".$key." = document.getElementById('icon_save_' + intId) \n";						
				
			
			print "lyr_".$key.".style.display = 'none'; \n";
			print "fld_".$key.".style.display = 'block'; \n";

			print "icon_edit_".$key.".style.display = 'none'; \n";
			print "icon_save_".$key.".style.display = 'block'; \n";
			
			
			
		}
		print '}
				</script>';
	}
	
/*	function voidSetDropdownField($strId,$strName)
	{
		$this -> m_strDropdownId = $strId;
		$this -> m_strDropdownName = $strName;
	}*/
	
}

?>