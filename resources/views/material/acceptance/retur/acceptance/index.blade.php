<div class="data-list-filter">
	<form action="{{ url('material/acceptance/retur/acceptance') }}" method="get">
		<select name="field">
			<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
			<option value="dorp_no" <?php echo $isSelected('dorp_no') ?>>No. Surat Jalan</option>
			<option value="sup_nama" <?php echo $isSelected('sup_nama') ?>>Supplier</option>
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
			<th>No. Surat Jalan</th>
			<th>Supplier</th>
			<th>Tgl Penerimaan</th>
			<th>Tgl Retur</th>
			<th>Tgl Kedatangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)
		<tr>
			<td class="text-right">{{ ++$x }}.</td>
			<td>{{ $row->po_no }}</td>
			<td>{{ $row->dorp_no }}</td>
			<td>{{ $row->sup_nama }}</td>
			<td class="text-center">{{ to_indDate($row->pener_date) }}</td>
			<td class="text-center"><?php $tglRetur = explode(' ', $row->tglRetur); echo to_indDate($tglRetur[0]) ?></td>
			<td class="text-center">{{ to_indDate($row->peneretur_date) }}</td>
			<td class="text-right">
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

<?php echo $fetch->render() ?>