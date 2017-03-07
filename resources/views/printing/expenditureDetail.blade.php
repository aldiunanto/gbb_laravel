<tr id="expenditure-detail">
	<td colspan="14">
		<div class="container">
			<table>
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Realisasi</th>
					</tr>
				</thead>
				<tbody>
					@foreach($fetch as $row)
						<?php $d = explode('-', $row->pengel_date) ?>
					<tr>
						<td class="left">{{ ($d[2] . '-' . $d[1] . '-' . $d[0]) }}</td>
						<td>{{ $row->pengels_realisasi }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</td>
</tr>