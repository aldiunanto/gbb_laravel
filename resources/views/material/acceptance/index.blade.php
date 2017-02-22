<div class="data-list-filter">
	<form action="{{ url('material/acceptance') }}" method="get">
		<select name="field">
			<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
			<option value="sup_nama" <?php echo $isSelected('sup_nama') ?>>Supplier</option>
			<option value="pener_date" <?php echo $isSelected('pener_date') ?>>Tgl Penerimaan Terakhir</option>
		</select>
		<input type="text" name="s" placeholder="Kata pencarian.." value="{{ $search['s'] }}" />
		<button><i class="fa fa-search"></i></button>
	</form>
</div>
<div class="clearfix"></div>

<table class="data-list index">
	<thead>
		<tr>
			<th>No</th>
			<th>Nomor PO</th>
			<th>Supplier</th>
			<th>Tgl Permintaan</th>
			<th>Penerimaan Terakhir</th>
			<th>Keterangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = $getNumb(); ?>
	@foreach($fetch['fetch'] as $row)

		<tr>
			<td class="text-right">{{ ++$x }}.</td>
			<td>{{ $row->po_no }}</td>
			<td>{{ $row->sup_nama }}</td>
			<td class="text-center">{{ to_indDate($row->po_tgl_kedatangan) }}</td>
			<td class="text-center">{{ to_indDate($row->pener_date) }}</td>
			<td class="text-center"><?php echo dateDiff($row->po_tgl_kedatangan, $row->pener_date) ?></td>
			<td class="text-right">
				<ul class="actions">
					<li><span><i class="fa fa-angle-down"></i></span>
						<ul>
							<li><a href="{{ url('material/acceptance/show/' . $row->po_id) }}" class="view-detail"><i class="fa fa-eye"></i>Lihat detail</a></li>
							<li><a href="{{ url('po/acceptanceDetail/' . getPOId($row->pener_id)) }}" class="acceptance-detail"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
						</ul>
					</li>
				</ul>
			</td>
		</tr>

	@endforeach
	</tbody>
</table>

<?php echo $paginator->render() ?>