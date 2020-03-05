<?php

class AdminUser Extends MySqlDB
{

	var $m_strUsername;
	var $m_strPassword;
	var $m_strUserLevel;
	var $m_strError;
	var $m_intId;
	var $m_strFirstName;
	var $m_strLastName;
	var $m_strMessage;
	var $m_strDate;
	var $m_intIsActive;
	
	
	function voidSetUsername($strValue)
	{
		$this -> m_strUsername = $strValue;
	}
	
	function strGetUsername()
	{
		return $this -> m_strUsername;
	}
	
	function voidSetDate($strValue)
	{
		$this -> m_strDate = $strValue;
	}
	
	function strGetDate()
	{
		return $this -> m_strDate;
	}
	
	function voidSetIsActive($intValue)
	{
		$this -> m_intIsActive = $intValue;
	}
	
	function intGetIsActive()
	{
		return $this -> m_intIsActive;
	}
	
	function voidSetPassword($strValue)
	{
		$this -> m_strPassword = $strValue;
	}
	
	function strGetPassword()
	{
		return $this -> m_strPassword;
	}
	
	function voidSetUserLevel($strValue)
	{
		$this -> m_strUserLevel = $strValue;
	}
	
	function strGetUserLevel()
	{
		return $this -> m_strUserLevel;
	}
	
	function voidSetError($strValue)
	{
		$this -> m_strError = $strValue;
	}
	
	function strGetError()
	{
		return $this -> m_strError;
	}
	
	function voidSetId($intValue)
	{
		$this->m_intId = $intValue;
	}
	
	function intGetId()
	{
		return $this -> m_intId;
	}
	
	function voidSetFirstName($strValue)
	{
		$this -> m_strFirstName = $strValue;
	}
	
	function strGetFirstName()
	{
		return $this -> m_strFirstName;
	}

	function voidSetLastName($strValue)
	{
		$this -> m_strLastName = $strValue;
	}
	
	function strGetLastName()
	{
		return $this -> m_strLastName;
	}
	
	function strGetMessage()
	{
		return $this -> m_strMessage;
	}
	
	
	//note: if array is empty the assumption is the user does not exist
	function blnGetAdminUser()
	{
		    print $sqlData = 'SELECT a.fauId, a.fauUserName, a.fauPassword, a.fauFirstName, a.fauLastName, b.fulId 
						FROM tblAdminUsers a INNER JOIN tblUserLevel b ON a.fulId = b.fulId 
						WHERE a.fauUserName = "'.$this->m_strUsername.'" 
							AND a.fauPassword = "'.md5($this->m_strPassword).'" 
							AND b.fulId = "'.$this -> m_strUserLevel.'"';
		if($rsData = mysqli_query($this -> voidConnect(), $sqlData))
		{
			if (mysqli_num_rows($rsData) > 0)
			{
				if($rowData = mysqli_fetch_array($rsData))
				{
					$this -> m_intId = $rowData['fauId'];
					$this -> m_strUsername = $rowData['fauUserName'];
					$this -> m_strFirstName = $rowData['fauFirstName'];
					$this -> m_strLastName = $rowData['fauLastName'];
					$this -> m_strUserLevel = $rowData['fulId'];
					return true;
				}
			}
		}
		return false;
	}

	//note: if array is empty the assumption is the user does not exist
	function blnGetAdminUserId()
	{
	
		$sqlData = 'SELECT fauId, fulId, fauUserName, fauPassword, fauFirstName, fauLastName 
						FROM tblAdminUsers 
						WHERE fauId = "'.$this->m_intId.'"';
		if($rsData = mysqli_query($this->voidConnect(),$sqlData))
		{
			if (mysqli_num_rows($rsData) > 0)
			{
				if($rowData = mysqli_fetch_array($rsData))
				{
					$this -> m_strUsername = $rowData['fauUserName'];
					$this -> m_strFirstName = $rowData['fauFirstName'];
					$this -> m_strLastName = $rowData['fauLastName'];
					$this -> m_strUserLevel = $rowData['fulId'];
					
					return true;
				}
			}
		}
		return false;
	}
			
	function intInsertAdminUser()
	{
		$arrValuePairs = array(
							'fauUserName' => $this -> m_strUsername, 
							'fauPassword' => md5($this -> m_strPassword), 
							'fauFirstName' => $this -> m_strFirstName, 
							'fauLastName' => $this -> m_strLastName,
							'fauDate' => $this -> m_strDate,
							'fauIsActive' => $this -> m_intIsActive,
							'fulId' => $this -> m_strUserLevel);
		$this -> voidSetTableName('tblAdminUsers');
		if ($this -> blnValidateAdminUsername()) {
		    if ($intId = $this -> intInsertData($arrValuePairs))
		    {
		        $this -> m_strMessage = "Admin User was succesfully added!";
		        return $intId;
		    }
		} else {
		    $this -> m_strMessage = "Username already existing! Registration failed";
		}
		return 0;
	}

	function blnUpdateAdminUser()
	{
		$arrValuePairs = array(
							'fauFirstName' => $this -> m_strFirstName, 
							'fauLastName' => $this -> m_strLastName,
		                    'fulId' => $this -> m_strUserLevel);
		if ($this -> m_strPassword != '') 
		{
			$arrValuePairs['fauPassword'] = md5($this -> m_strPassword);
		}
		$this -> voidSetTableName('tblAdminUsers');
		if ($intId = $this -> blnUpdateData($arrValuePairs, 'fauId', $this -> m_intId))
		{
			$this -> m_strMessage = 'Update Succesful';
			return $intId;
		}
		return 0;
	}

	function void_get_user_information()
		{
			 $strSql = 'SELECT fauFirstName FROM tblAdminUsers WHERE fauId = "'.$_SESSION['intId'].'"';
				if($rs = mysqli_query($strSql))
					{
						while($row = mysqli_fetch_array($rs))
							{
								$this->m_strFirstName = $row['fauFirstName'];
							}
					}
		
		}

	function intDeleteAdminUser()
		{
			 $sqlDelete = 'DELETE FROM tblAdminUsers WHERE fauId = "'.$this -> m_intId.'"';
			 $sqlPermission = 'DELETE FROM tblPermissions WHERE fauId "'.$this -> m_intId.'"';
				if($rsDelete = mysqli_query($sqlDelete) && mysqli_query($sqlPermission))
				{
					$this -> m_strMessage = 'Admin User Deleted!';
				}
				else
				{
					$this -> m_strMessage = 'Delete Unsuccesful!';
				}	
		}

	function blnValidateAdminUsername()
	{
		$sqlValidateUsername = 'SELECT fauUserName FROM tblAdminUsers WHERE fauUserName = "'.$this -> m_strUsername.'"';
		if($rsValidateUsername = mysqli_query($this-> voidConnect(), $sqlValidateUsername))
		{
			if(mysqli_num_rows($rsValidateUsername) > 0)
			{
					//print "<div  style='color: red;'><b>Username already Exist! Select another Username</b></div>";
					return false;
			}
			else
			{
				//print "Username is still available. Please proceed!";
				return true;
			}	 
			
		}	

	}
	
	function arrGetAdminUsers() 
	{
	    $arrAdminUsers = array();
	    $strSql = 'SELECT a.fauId, a.fauUsername, CONCAT(a.fauFirstName," ", a.fauLastName) AS adminName, b.fulName
                   FROM tblAdminUsers a INNER JOIN tblUserLevel b ON a.fulId = b.fulId WHERE a.fauIsActive = 1';
	    $arrAdminUsers = $this->arrGetAllSql($strSql);
	    return $arrAdminUsers;
	}
}
?> 