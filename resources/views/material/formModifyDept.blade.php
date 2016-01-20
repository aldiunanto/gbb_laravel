<div class="modify-dept-form material-detail">
	<div class="base-info">
		<table>
			<tr>
				<td class="field">Material</td>
				<td class="colon">:</td>
				<td>{{ $head->mat_nama }}</td>
			</tr>
			<tr>
				<td class="field">Spesifikasi</td>
				<td class="colon">:</td>
				<td>{{ $head->mat_spesifikasi }}</td>
			</tr>
			<tr>
				<td class="field">Supplier</td>
				<td class="colon">:</td>
				<td>{{ $head->sup_nama }}</td>
			</tr>
			<tr>
				<td class="field">Warna</td>
				<td class="colon">:</td>
				<td>{{ (empty($head->wrn_nama) ? '-' : $head->wrn_nama) }}</td>
			</tr>
			<tr>
				<td class="field">Bagian</td>
				<td class="colon">:</td>
				<td>
					<select name="deptbg_id">
						@foreach($deptbg as $row)
						<option value="{{ $row->deptbg_id }}" <?php echo ($head->deptbg_id == $row->deptbg_id ? 'selected="selected"' : '') ?>>{{ $row->deptbg_nama }}</option>
						@endforeach
					</select>
				</td>
			</tr>
		</table>
	</div>
</div>