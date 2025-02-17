<?php
	class tmdt{
		public function connect()
		{
			$con=mysql_connect("localhost","caulong","123");
			if(!$con)
			{
				echo 'Khong ket noi dc csdl';
				exit();
			}else{
					mysql_select_db("shop_caulong");
					mysql_query("SET NAMES UTF8");
					return $con;
				}
			}
			public function xuatdscty($sql)
			{
				$link=$this->connect();
				$ketqua=mysql_query($sql,$link);
				$i=mysql_num_rows($ketqua);
				if($i>0){
					echo '<table width="600" border="1" align="center">
						  <tbody>
							<tr>
							  <th scope="row">STT</th>
							  <td><strong>Ten cong ty</strong></td>
							  <td><strong>Dia chi</strong></td>
							</tr>';
							$dem=1;
					while($row=mysql_fetch_array($ketqua)){
						$idcty=$row['idcty'];
						$tencty=$row['tencty'];
						$diachi=$row['diachi'];
						echo '<tr>
							  <th scope="row">'.$dem.'</th>
							  <td>'.$tencty.'</td>
							  <td>'.$diachi.'</td>
							</tr>';
							$dem++;
						}
					echo '</tbody>
						</table>
							';
					}else{
						echo 'Khong co du lieu';
					}
			}
			public function uploadfile($name,$tmp_name,$folder)
			{
				
				$newname=$folder."/".$name;
				if(move_uploaded_file($tmp_name,$newname))
				{
					return 1;
				}else
				{
					return 0;
				}
			}
			public function themxoasua($sql)
			{
				$link=$this->connect();
				
				if($ketqua=mysql_query($sql,$link))
				{
					return 1;
				}else
				{
					return 0;	
				}
			}
			public function Laycot($sql)
			{
				$link=$this->connect();
				$ketqua=mysql_query($sql,$link);
				$i=mysql_num_rows($ketqua);
				$giatri='';
				if($i>0)
				{
					while($row=mysql_fetch_array($ketqua))
					{
						$gt=$row[0];
						$giatri=$gt;
					}
				}
				return $giatri;
			}
	
			
}
?>