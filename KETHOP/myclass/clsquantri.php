
<?php
include('clstmdt.php');
class quantri extends tmdt
{
	public function choncongty($sql, $idchon)
	{
		$link = $this->connect();
		$ketqua = mysql_query($sql, $link);
		$i = mysql_num_rows($ketqua);
		if ($i > 0) {
			echo '<select name="congty" id="congty">
						<option>Mời chọn nhà sản xuất</option>';
			while ($row = mysql_fetch_array($ketqua)) {
				$idcty = $row['idcty'];
				$tencty = $row['tencty'];
				if ($idcty == $idchon) {
					echo '<option value="' . $idcty . '" selected>' . $tencty . '</option>';
				} else {
					echo '<option value="' . $idcty . '">' . $tencty . '</option>';
				}
			}
			echo '</select>';
		} else {
			echo 'Khong co du lieu';
		}
	}
	public function danhsachsanpham($sql)
	{
		$link = $this->connect();
		$ketqua = mysql_query($sql, $link);
		$i = mysql_num_rows($ketqua);
		if ($i > 0) {
			echo '<table class="table table-striped" width="745" border="1" align="center">
						  <tbody>
							<tr>
							  <th width="61" align="center" valign="middle" scope="row">STT</th>
							  <td width="240" align="center" valign="middle">TÊN SẢN PHẨM</td>
							  <td width="300" align="center" valign="middle">MÔ TẢ </td>
							  <td width="147" align="center" valign="middle">GIÁ</td>
							  <td width="149" align="center" valign="middle">GIẢM GIÁ </td>
							</tr>';	
			$dem = 1;
			while ($row = mysql_fetch_array($ketqua)) {
				$idsp = $row['id'];
				$tensp = $row['tensp'];
				$gia = $row['gia'];
				$mota = $row['mota'];
				$giamgia = $row['giamgia'];
				echo '<tr>
							  <th align="center" valign="middle" scope="row"><a href=?id=' . $idsp . ' style="text-decoration: none;">' . $dem . '</a></th>
							  <td align="center" valign="middle"><a href=?id=' . $idsp . ' style="text-decoration: none;">' . $tensp . '</a></td>
							  <td align="center" valign="middle"><a href=?id=' . $idsp . ' style="text-decoration: none;">' . $mota . '</a></td>
							  <td align="center" valign="middle"><a href=?id=' . $idsp . ' style="text-decoration: none;">' . $gia . '</a></td>
							  <td align="center" valign="middle"><a href=?id=' . $idsp . ' style="text-decoration: none;">' . $giamgia . '</a></td>
							</tr>';
				$dem++;
			}
			echo '</tbody>
						</table>';
		} else {
			echo 'Khong co du lieu';
		}
	}
	/*public function xoaanh($sql) 
	{
		$link = $this->connect();
		$ketqua = mysql_query($sql,$link);
		$i = mysql_num_rows($ketqua);
		if($i>0) 
		{
			while($row = mysql_fetch_array($ketqua))
			{
				$name = $row['hinh'];
			}
		}
		else
		{
			echo 'khong co du lieu';
		}
			unlink("../hinh/".$name);
	}	*/
}
