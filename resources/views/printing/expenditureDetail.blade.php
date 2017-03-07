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
					<tr>
						<td class="left">{{ $row->pengel_date }}</td>
						<td>{{ $row->pengels_realisasi }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</td>
</tr>