<?php 
class Students extends MySqlDb
{
    
    var $m_intId;
    var $m_intStudentNumber;
    var $m_strFirstName;
    var $m_strLastName;
    var $m_strMiddleName;
    var $m_strPreferredName;
    var $m_strDateOfBirth;
    var $m_strGender;
    var $m_strNationalStudentNumber;
    var $m_strCountryOfBirth;
    var $m_strPreferredContact;
    var $m_strYearOfArrival;
    var $m_intStatus;
    
    function voidSetId($intValue)
    {
        $this -> m_intId = $intValue;
    }
    
    function intGetId() 
    {
        return $this -> m_intId;
    }

    function voidSetStudentNumber($intValue)
    {
        $this -> m_intStudentNumber = $intValue;
    }
    
    function intGetStudentNumber()
    {
        return $this -> m_intStudentNumber;
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
    
    function voidSetMiddleName($strValue)
    {
        $this -> m_strMiddleName = $strValue;
    }
    
    function strGetMiddleName()
    {
        return $this -> m_strMiddleName;
    }
    
    function voidSetPreferredName($strValue)
    {
        $this -> m_strPreferredName = $strValue;
    }
    
    function strGetPreferredName()
    {
        return $this -> m_strPreferredName;
    }
    
    function voidSetDateOfBirth($strValue)
    {
        $this -> m_strDateOfBirth = $strValue;
    }
    
    function strGetDateOfBirth()
    {
        return $this -> m_strDateOfBirth;
    }
    
    function voidSetGender($strValue)
    {
        $this -> m_strGender = $strValue;
    }
    
    function strGetGender()
    {
        return $this -> m_strGender;
    }
    
    function voidSetNationalStudentNumber($strValue)
    {
        $this -> m_strNationalStudentNumber = $strValue;
    }
    
    function strGetNationalStudentNumber()
    {
        return $this -> m_strNationalStudentNumber;
    }
    
    function voidSetCountryOfBirth($strValue)
    {
        $this -> m_strCountryOfBirth = $strValue;
    }
    
    function strGetCountryOfBirth()
    {
        return $this -> m_strCountryOfBirth;
    }
    
    function voidSetPreferredContact($strValue)
    {
        $this -> m_strPreferredContact = $strValue;
    }
    
    function strGetPreferredContact()
    {
        return $this -> m_strPreferredContact;
    }
    
    function voidSetYearOfArrival($strValue)
    {
        $this -> m_strYearOfArrival = $strValue;
    }
    
    function strGetYearOfArrival()
    {
        return $this -> m_strYearOfArrival;
    }

    
    function voidSetStatus($intValue)
    {
        $this -> m_intStatus = $intValue;
    }
    
    function intGetStatus()
    {
        return $this -> m_intStatus;
    }
    function arrGetAllStudents()
    {
        $strSql = 'SELECT fstId, fstStudentNumber, fstFirstName, fstLastName, fstCountryOfBirth FROM tblStudents';
        $arrStudents = array();
        $arrStudents = $this->arrGetAllSql($strSql);
        return $arrStudents;
    }
    
    function insertNewStudent()
    {
        $arrValuePairs = array(
            'fstStudentNumber' => $this -> m_intStudentNumber,
            'fstFirstName' => $this -> m_strFirstName,
            'fstMiddleName' => $this -> m_strMiddleName,
            'fstLastName' => $this -> m_strLastName,
            'fstPreferredName' => $this -> m_strPreferredName,
            'fstDateOfBirth' => $this -> m_strDateOfBirth,
            'fstGender' => $this -> m_strGender,
            'fstNationalStudentNumber' => $this -> m_strNationalStudentNumber,
            'fstCountryOfBirth' => $this -> m_strCountryOfBirth,
            'fstYearOfArrival' => $this -> m_strYearOfArrival,
            'fstaId' => $this -> m_intStatus);
        $this -> voidSetTableName('tblStudents');
        if ($intId = $this -> intInsertData($arrValuePairs))
        {
            $this -> m_strMessage = "A new Student was succesfully added!";
            return true;
        }
        else 
        {
            return 0;
        }
    }
    
    function arrGetStudentInformationById($intStudentId)
    {
        $arrResult = array();
        $this -> voidSetTableName("tblStudents");
        $strSql="SELECT * FROM tblStudents WHERE fstID = '.$intStudentId.'";
        $arrResult = $this -> arrGetRow('fstId',$intStudentId);
        
        return $arrResult;
    }
    
    function updateStudentInformation($intStudentId)
    {
        $arrValuePairs = array(
            'fstStudentNumber' => $this -> m_intStudentNumber,
            'fstFirstName' => $this -> m_strFirstName,
            'fstMiddleName' => $this -> m_strMiddleName,
            'fstLastName' => $this -> m_strLastName,
            'fstPreferredName' => $this -> m_strPreferredName,
            'fstDateOfBirth' => $this -> m_strDateOfBirth,
            'fstGender' => $this -> m_strGender,
            'fstNationalStudentNumber' => $this -> m_strNationalStudentNumber,
            'fstCountryOfBirth' => $this -> m_strCountryOfBirth,
            'fstYearOfArrival' => $this -> m_strYearOfArrival,
            'fstaId' => $this -> m_intStatus);
        $this -> voidSetTableName('tblStudents');
        if ($intId = $this -> blnUpdateData($arrValuePairs,'fstId',$intStudentId))
        {
            $this -> m_strMessage = "A new Student was succesfully added!";
            return true;
        }
        else
        {
            return 0;
        }
    }
}
?>