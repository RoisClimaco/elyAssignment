<?php
class Session
{
	var $m_arrSessionVars = array();
	var $m_arrSessionValues = array();
	var $m_strHashKey;
	var $m_strHashVariable;
	
	/*function Session()
	{
		 //session_start();
	}*/
	
	function blnRegisterVariable($arrVarNames) 
	{
		if (is_array($arrVarNames))
		{
			foreach($arrVarNames as $key => $value)
			{
				if(!isset($_SESSION[$value]))
				{
					$_SESSION[$value];
				}
				if (!in_array($value, $this -> m_arrSessionVars))
				{
					array_push($this -> m_arrSessionVars, $value);
					$this -> m_arrSessionValues[$value] = '';					
				}
			}
			return true;
		}
		elseif (!is_array($arrVarNames))
		{
			if(!isset($_SESSION[$arrVarNames]))
			{
				$_SESSION[$arrVarNames];
			}
			if (!in_array($arrVarNames, $this -> m_arrSessionVars))
			{
				array_push($this -> m_arrSessionVars, $arrVarNames);
				$this -> m_arrSessionValues[$arrVarNames] = '';					
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function blnSetVariable($arrVarNames, $arrValues) 
	{
		if (is_array($arrVarNames) && is_array($arrValues))
		{
			foreach($arrVarNames as $key => $value)
			{
				if(!isset($_SESSION[$value]))
				{
					$_SESSION[$value];
				}
				if (!in_array($value, $this -> m_arrSessionVars))
				{
					array_push($this -> m_arrSessionVars, $value);
				}
				$this -> m_arrSessionValues[$value] = $arrValues[$key];					
				$_SESSION[$value] = $arrValues[$key];
			}
			return true;
		}
		elseif (!is_array($arrVarNames) && !is_array($arrValues))
		{
			if(!isset($_SESSION[$arrVarNames]))
			{
				$_SESSION[$arrVarNames];
			}
			if (!in_array($arrVarNames, $this -> m_arrSessionVars))
			{
				array_push($this -> m_arrSessionVars, $arrVarNames);
			}
			$this -> m_arrSessionValues[$arrVarNames] = $arrValues;					
			$_SESSION[$arrVarNames] = $arrValues;
			return true;
		}
		else
		{
			return false;
		}
	}

	function voidUnregisterVariable($arrVarNames = '') 
	{
		if (is_array($arrVarNames))
		{
			foreach($arrVarNames as $key => $value)
			{
				unset($value);
			}
			unset($arrVarNames);
		}
		elseif (!is_array($arrVarNames) && $arrVarNames != '')
		{
			unset($arrVarNames);
		}
		else
		{
			foreach($this -> m_arrSessionVars as $key => $value)
			{
				$_SESSION[$value] = '';
				unset($value);
			}
			unset($this -> m_arrSessionVars);
			session_destroy();
		}
	}

	function blnIsVariableSet($arrVarName)
	{
		$blnIsRegister = true;
		if (is_array($arrVarName))
		{
			foreach($arrVarName as $key => $value)
			{
				if (!isset($_SESSION[$value]) || $_SESSION[$value] == '')
				{
					$blnIsRegister = false;
				}
			}
		}
		elseif (!isset($_SESSION[$strVarName]) || $_SESSION[$strVarName] == '')
		{
			$blnIsRegister = false;
		}
		else
		{
			$blnIsRegister = false;
		}
		return $blnIsRegister;
	}
	
	function blnRegisterSessionKey($srtHashKey, $srtHashVariable)
	{
		$this -> m_strHashKey = $srtHashKey;
		$this -> m_srtHashVariable = $srtHashVariable;
		$_SESSION['strSessionKey'];
		$_SESSION['strSessionKey'] = md5($srtHashKey.$srtHashVariable).session_id();
	}

	function blnIsSessionKeyRegistered($srtHashKey, $srtHashVariable)
	{
		if ($_SESSION['strSessionKey'] == md5($srtHashKey.$srtHashVariable).session_id())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
?>