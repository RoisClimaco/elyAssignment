<?php 
include '../header.php';
$arrStudents = array();
$ObjStudents = new Students();
$arrStudents = $ObjStudents -> arrGetAllStudents();

$tblRow = 'tblrow1';
?>
<form name="frmStudentList" method="post" onSubmit="return confirmDelete(this)">
<table cellspacing="1" cellpadding="5" width="80%" align="center">
	<tr>
	  <td align="center" colspan="5"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" class="formstable2" colspan="2" height="35">&nbsp;</td>
	</tr>	
	<tr>
		<td width="6%" align="center" colspan="2"><table width="100%" align="0" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="left" valign="middle"></td>
				<td align="right" valign="middle" class="editdelete"></td>
			</tr>
			<tr>
				<td height="5" colspan="2" align="left" valign="top"><img src="../images/spacer.gif" width="1" height="1"></td>
			</tr>
				<tr>
					<td colspan="2" align="center" valign="top">
						<table  border="0" width="100%" cellpadding="2" cellspacing="3" class="ltgray">
							<tr ><td width="15%" align="center" class="tbltitle_header">STUDENT NO</td>
							<td width="15%" align="center" class="tbltitle_header">LAST NAME</td>
							<td width="15%" align="center" class="tbltitle_header">FIRST NAME</td>
							<td width="15%" align="center" class="tbltitle_header">COUNTRY OF ORIGIN</td>
							<?php for ($i=0; $i < count($arrStudents); $i++) {
							    
							    print '<tr>
							    <td align="center" class="'.$tblRow.'">'.$arrStudents[$i]['fstStudentNumber'].'</td>
							    <td align="center" class="'.$tblRow.'">'.$arrStudents[$i]['fstLastName'].'</td>
							    <td align="center" class="'.$tblRow.'">'.$arrStudents[$i]['fstFirstName'].'</td>
							    <td align="center" class="'.$tblRow.'">'.$arrStudents[$i]['fstCountryOfBirth'].'</td>
							        </tr>';
							    if ($tblRow == 'tblrow1')
							    {
							        $tblRow = 'tblrow2';
							    }
							    else 
							    {
							        $tblRow = 'tblrow1';
							    }
							}
							?>
						</table>
					</td>
				</tr>
		<tr>
			<td height="5" colspan="2" align="left" valign="top"><img src="../images/spacer.gif" width="1" height="1"></td>
		</tr>
		<tr >
			<td align="left" valign="middle"></td>
			<td align="right" valign="middle" class="editdelete"></td>
		</tr>
	</table></td>
	</tr>
</table>
</form>
