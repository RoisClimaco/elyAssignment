<?php
Class General
{
	/***************************************************************************
	 *	redirect_url					                                 		
	 *	Redirects a page to the given URL                                 		
	 *																			
	 *	@param string $strUrl url/address 										
	 *	@param integer $intDelay delay in seconds								
	 *	@param string $strMessage message to be displayed while redirecting		
	 *	@return null                                                           	
	 **************************************************************************/
	function voidRedirectUrl($strUrl, $intDelay = 0, $strMessage = '') 
	{
		print '<html><head>';
		print '<meta http-equiv="Refresh" content="'.$intDelay.'; url='.$strUrl.'">';
		print '</head><body></body></html>';
		print $strMessage;
		exit;
	}
	
	/***************************************************************************
	 *	str_generate_message					                                 		
	 *	Generate status messages after executing a process
	 *																			
	 *	@param string $strMessage  description of the status messages
	 *	@param string $strType type of status message if its either SUCCESS or ERROR
	 *	@param string $strPrefix path to the icons used for displaying an 
	 *	error or success status message
	 *	@return $strMessage The status message to be displayed                                                           	
	 **************************************************************************/
	function strGenerateMessage($strMessage, $strType = 'ERROR', $strPrefix = '') 
	{
		switch ($strType)
		{
			case 'ERROR':
				$strMessage = '<div class="msgerror">ERROR! '.$strMessage.'</div>';
				break;
			case 'SUCCESS':
				$strMessage = '<div class="msgsuccess">SUCCESS! '.$strMessage.'</div>';
				break;
			case 'DISPLAY':
				$strMessage = '<div class="msgsuccess">'.$strMessage.'</div>';
				break;
			default:
				break;
		}
		return $strMessage;
	}
	
	function strFormatDate($strFormat, $strValue)
	{
		$arrDateTime = explode(' ', $strValue);
		return date($strFormat, mktime(substr($arrDateTime[1], 0, 2), substr($arrDateTime[1], 3, 2), substr($arrDateTime[1], 6, 2), substr($arrDateTime[0], 5, 2), substr($arrDateTime[0], 8, 2), substr($arrDateTime[0], 0, 4)));
	}
	
	function strGenerateFileName($strName)
	{
		$strName = str_replace(' ', '', $strName);
		$strName = str_replace(',', '', $strName);
		$strName = str_replace('\'', '', $strName);
		$strName = str_replace('-', '', $strName);
		$strName = str_replace('+', '', $strName);
		$strName = str_replace('%', '', $strName);
		$strName = str_replace(';', '', $strName);
		
		return date('YmdHis') . $strName ;
	}
	
	function strCheckImageSize($strImage, $intWidth, $intHeight)
	{	
		$strError = '';
		$arrDimension = getimagesize($strImage);
		if ($arrDimension[0] != $intWidth || $arrDimension[1] != $intHeight)
		{
			$strError = 'Please enter a '. $intWidth .' x '. $intHeight .' image';
		}			
		return $strError;
	}
	
	
}
?>
