@extends('base')

@section('content')
<div class="top">
	<h2>Data List PO <span>{{ $fetch->count() }} dari {{ $fetch->total() }}</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Material</th>
				<th>Tgl Order</th>
				<th>Permintaan</th>
				<th>Jml Masuk</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>

		<?php $x = 0; $po_no = ''; ?>
		@foreach($fetch as $row)
			<?php $accepted = countDiterima($row->pos_id) ?>
			@if($po_no != $row->po_no)
			<?php
				$tr_class = 'new-po';
				$po_no = $row->po_no;
			?>
			@else
			<?php $tr_class = ''; ?>
			@endif

			<tr class="{{ $tr_class }}">
				<td class="text-center">{{ ++$x }}.</td>
				<td>{{ $po_no }}</td>
				<td>{{ $row->mat_nama }}</td>
				<td class="text-center">{{ to_indDate($row->po_tgl_buat) }}</td>
				<td>{{ $row->pbs_jml }}</td>
				<td><a class="mat-acceptance" href="{{ url('po/matAcceptanceDetail/' . $row->pos_id) }}" title="Klik untuk lihat detail penerimaan material ini"><i class="fa fa-eye"></i> {{ $accepted }}</a></td>
				<td class="text-center">
					<?php

						$diff = $row->pbs_jml - $accepted;
						if($diff == 0){
							$text['f']['t'] = 'Terpenuhi, ';
							$text['f']['c'] = 'Closed, ';
							$text['f_type'] = 'closed';
						}elseif($diff > 0){
							$text['f']['t'] = 'Kurang ' . $diff . ', ';
							$text['f']['c'] = '-' . $diff . ', ';
							$text['f_type'] = 'min';
						}

						$first = ($row->po_status == 1 ? now() : $row->pener_date);
						$text += poDateDiff($first, $row->po_tgl_kedatangan);

						if($text['f_type'] == 'min' && $text['s_type'] == 'slow'){
							$class = 'pm-reject-vice';
						}elseif($text['f_type'] == 'min' && $text['s_type'] == 'fast'){
							$class = 'pm-reject-ppic';
						}elseif($text['f_type'] == 'min' && $text['s_type'] == 'ontime'){
							$class = 'wait-vice';
						}elseif($text['f_type'] == 'closed' && $text['s_type'] == 'ontime'){
							$class = 'po-done';
						}elseif($text['f_type'] == 'closed' && $text['s_type'] == 'fast'){
							$class = 'vice-approve';
						}elseif($text['f_type'] == 'closed' && $text['s_type'] == 'slow'){
							$class = 'wait-ppic';
						}

						echo '<span class="status '.$class.'" title="'.$text['f']['t'].$text['s']['t'].'">'.$text['f']['c'].$text['s']['c'].'</span>';

					?>
				</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('po/show/' . $row->po_id) }}" class="view-detail"><i class="fa fa-eye"></i>Detail PO</a></li>
								<li><a href="{{ url('') }}"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
								
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('printing/po/' . $row->po_id) }}" target="_blank" ><i class="fa fa-print"></i>Cetak PO</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>

		@endforeach
		</tbody>
	</table>

	<?php echo $fetch->render() ?>
</div>

<!--
<span class="status pm-reject-vice" title="Kurang 200, telat 2 hari">-200, -2D</span>
<span class="status pm-reject-ppic" title="Kurang 200, lebih awal 2 hari">-200, +2D</span>
<span class="status wait-vice" title="Kurang 200, tepat watu">-200, tepat</span>

<span class="status po-done" title="Terpenuhi, tepat waktu">Closed, tepat</span>
<span class="status vice-approve" title="Terpenuhi, lebih awal 3 hari">Closed, +3D</span>
<span class="status wait-ppic" title="Terpenuhi, telat 3 hari">Closed, -3D</span>
-->

@endsection