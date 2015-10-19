<div class="material-list">
	<div class="get-po">
		<form method="post" action="{{ url('material/expenditure/searchMaterial') }}">
			<div class="search">
				<input type="text" name="filter" placeholder="Nomor PO.." />
				<button><i class="fa fa-search"></i></button>
			</div>
		</form>

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
						<td>{{ $row->mat_spesifikasi }}</td>
						<td>{{ $row->wrn_nama }}</td>
						<td>{{ $row->mats_nama }}</td>
						<td>{{ $row->mat_stock_akhir }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>