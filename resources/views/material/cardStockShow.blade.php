<?php

	$now = strtotime($req['dEnd']);
	$your_date = strtotime($req['dStart']);
	$datediff = $now - $your_date;

	$count = floor($datediff / (60 * 60 * 24)) + 1;
	for ($i = 0; $i < $count; $i++) {
		$curDate = date('Y-m-d', strtotime($req['dStart'] . ' +' . $i . ' day'));

		$pener 	= array();
		$pengel = array();
		$deptbg = array();
		$nobpb	= array();

		foreach ($Peners->cardStock($req['matId'], $curDate) as $row) {
			$pener[] = $row->peners_jml;
		}

		foreach ($Pengels->cardStock($req['matId'], $curDate) as $row) {
			$pengel[] 	= $row->pengels_realisasi;
			$deptbg[]	= $row->deptbg_nama;
			$nobpb[]	= $row->pengel_bpb;
		}

		$largest = count($pengel) >= count($pener) ? count($pengel) : count($pener);
		if (count($pengel) != 0 || count($pener) != 0) {
			$path = explode('-', $curDate);
			for ($x = 0; $x < $largest; $x++) { 
?>

				<tr>
					<td>{{ ($path[2] . '-' . $path[1] . '-' . $path[0]) }}</td>
					<td><?php echo (!empty($pener[$x]) ? $pener[$x] : '-') ?></td>
					<td><?php echo (!empty($pengel[$x]) ? $pengel[$x] : '-') ?></td>
					<td><?php echo (!empty($deptbg[$x]) ? $deptbg[$x] : '-') ?></td>
					<td><?php echo (!empty($nobpb[$x]) ? $nobpb[$x] : '-') ?></td>
				</tr>

<?php
			}
		}	
	}

?>