@extends('base')

@section('content')
<div class="top">
	<h2>Data List PO</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('inserted') !!}
	<table class="data-list index">
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
			<?php $accepted = countDiterima($row->pos_id); $isDiterima = isDiterima($row->po_id); $text = null; ?>
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
				<td>
					@if($accepted != 0)
					<a class="mat-acceptance" href="{{ url('po/matAcceptanceDetail/' . $row->pos_id) }}" title="Klik untuk lihat detail penerimaan material ini"><i class="fa fa-eye"></i> {{ $accepted }}</a>
					@else
					0
					@endif
				</td>
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
						}elseif($diff < 0){
							$text['f']['t'] = 'Lebih ' . abs($diff) . ', ';
							$text['f']['c'] = '+' . abs($diff) . ', ';
							$text['f_type'] = 'plus';
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
						}elseif($text['f_type'] == 'plus' && $text['s_type'] == 'slow'){
							$class = 'over-min';
						}elseif($text['f_type'] == 'plus' && $text['s_type'] == 'fast'){
							$class = 'over-plus';
						}elseif($text['f_type'] == 'plus' && $text['s_type'] == 'ontime'){
							$class = 'over-ontime';
						}

						if($accepted != 0 && ! is_null($row->pener_date)){
							$status = '<span class="status '.$class.'" title="'.$text['f']['t'].$text['s']['t'].'">'.$text['f']['c'].$text['s']['c'].'</span>';
						}else{
							$status = '-';
						}

						if($text['f_type'] == 'min' && $row->po_status == 2){
							$status = '<span class="status cuted-po" title="Closed, kurang '.$diff.' qty. (Potong PO)">Closed, -'.$diff.'Q</span>';
						}

						echo $status;

					?>
				</td>
				<td class="text-right">
					@if(! empty($tr_class))
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('po/show/' . $row->po_id) }}" class="view-detail {{ ($role == 3 || $role == 4 ? 'no-print' : '') }}"><i class="fa fa-eye"></i>Detail PO</a></li>
								
								@if($isDiterima > 0)
								<li><a href="{{ url('po/acceptanceDetail/' . $row->po_id) }}" class="acceptance-detail"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
								@endif

								@if(($role == 2 || $role == 1) && $text['f_type'] == 'min' && $row->po_status == 1)
								<li><a href="{{ $row->po_id }}" class="close-po"><i class="fa fa-check-square-o"></i>Close</a></li>
								@endif

								@if($role == 1 || $role == 2)
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('printing/po/' . $row->po_id) }}" target="_blank" ><i class="fa fa-print"></i>Cetak PO</a></li>
								@endif
							</ul>
						</li>
					</ul>
					@endif
				</td>
			</tr>

		@endforeach
		</tbody>
	</table>

	<fieldset class="label-info">
		<legend>Label Info</legend>
		<ul>
			<li><span class="status pm-reject-vice">&nbsp;</span> - Kurang [x], telat [y] hari</li>
			<li><span class="status pm-reject-ppic">&nbsp;</span> - Kurang [x], lebih awal [y] hari</li>
			<li><span class="status wait-vice">&nbsp;</span> - Kurang [x], tepat watu</li>
			<li><span class="status wait-ppic">&nbsp;</span> - Terpenuhi, telat [y] hari</li>
			<li><span class="status vice-approve">&nbsp;</span> - Terpenuhi, lebih awal [y] hari</li>
			<li><span class="status po-done">&nbsp;</span> - Terpenuhi, tepat waktu</li>
			<li><span class="status over-min">&nbsp;</span> - Lebih [x], telat [y] hari</li>
			<li><span class="status over-plus">&nbsp;</span> - Lebih [x], lebih awal [y] hari</li>
			<li><span class="status over-ontime">&nbsp;</span> - Lebih [x], tepat watu</li>
			<li><span class="status cuted-po">&nbsp;</span> - Closed, kurang [x] qty. (Potong PO)</li>
		</ul>
	</fieldset>
</div>


<!-- <span class="status pm-reject-vice" title="Kurang 200, telat 2 hari">-200, -2D</span>
<span class="status pm-reject-ppic" title="Kurang 200, lebih awal 2 hari">-200, +2D</span>
<span class="status wait-vice" title="Kurang 200, tepat watu">-200, tepat</span>

<span class="status po-done" title="Terpenuhi, tepat waktu">Closed, tepat</span>
<span class="status vice-approve" title="Terpenuhi, lebih awal 3 hari">Closed, +3D</span>
<span class="status wait-ppic" title="Terpenuhi, telat 3 hari">Closed, -3D</span>

<span class="status over-min" title="Kurang 200, telat 2 hari">+200, -2D</span>
<span class="status over-plus" title="Kurang 200, lebih awal 2 hari">+200, +2D</span>
<span class="status over-ontime" title="Kurang 200, tepat watu">+200, tepat</span> -->


@endsection