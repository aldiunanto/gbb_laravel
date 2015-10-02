<table class="data-list index">
	<thead>
		<tr>
			<th>No</th>
			<th>Nomor PO</th>
			<th>No. Surat Jalan</th>
			<th>Supplier</th>
			<th>Tgl Penerimaan</th>
			<th>Tgl Retur</th>
			<th>Tgl Kedatangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $x = 0 ?>
		@foreach($fetch as $row)
		<tr>
			<td>{{ ++$x }}.</td>
			<td>{{ $row->po_no }}</td>
			<td>{{ $row->dorp_no }}</td>
			<td>{{ $row->sup_nama }}</td>
			<td>{{ $row->pener_date }}</td>
			<td>{{ $row->tglRetur }}</td>
			<td>{{ $row->peneretur_date }}</td>
			<td>
				<ul class="actions">
					<li><span><i class="fa fa-angle-down"></i></span>
						<ul>
							<li><a href="{{ url('material/acceptance/retur/acceptance/show/' . $row->peneretur_id) }}" class="view-detail"><i class="fa fa-eye"></i>Lihat detail</a></li>
						</ul>
					</li>
				</ul>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>