<div class="material-list">
	<form method="post" action="{{ url('material/expenditure/searchMaterial') }}">
		<div class="search">
			<select name="field">
				<option value="mat_nama">Material</option>
				<option value="sup_nama">Supplier</option>
				<option value="mat_spesifikasi">Spesifikasi</option>
			</select>
			<input type="text" name="s" placeholder="Kata Pencarian" />
			<button><i class="fa fa-search"></i></button>
		</div>
	</form>

	<div class="info warning text-center"><i>Satuan yang digunakan adalah satuan <strong>Gudang</strong>.</i></div>
	<div class="list">
		<table>
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Material</th>
					<th>Supplier</th>
					<th>Spesifikasi</th>
					<th>Warna</th>
					<th>Satuan</th>
					<th>Stok Akhir</th>
				</tr>
			</thead>
			<tbody>
				@foreach($materials as $row)
				<tr>
					<td><a href="javascript:;" data-id="{{ $row->mat_id }}" class="pick-button btn primary"><i class="fa fa-mail-reply"></i></a></td>
					<td>{{ $row->mat_nama }}</td>
					<td>{{ $row->sup_nama }}</td>
					<td class="text-center">{{ $row->mat_spesifikasi }}</td>
					<td>{{ $row->wrn_nama }}</td>
					<td>{{ $row->mats_nama }}</td>
					<td class="text-right">{{ ($row->mat_stock_akhir * $row->mat_perbandingan) }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>