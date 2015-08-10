@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('po') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
					<option value="po_tgl_butuh" <?php echo $isSelected('po_tgl_butuh') ?>>Tanggal Order</option>
					<option value="mat_nama" <?php echo $isSelected('mat_nama') ?>>Nama Material</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
	</div>
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
		<?php $z = 0; $x = $getNumb(); $po_no = ''; ?>
		@foreach($fetch as $row)
		<?php

			$curr_po_no = $row->po_no;
			if($po_no != $curr_po_no){
				$po_no = $row->po_no;
				$x++;
				$y = $x . '.';
				$z = 0;
			}else{
				$curr_po_no = '';
				$y = '';
			}

			$accepted = countDiterima($row->pos_id);

		?>

			@if(! empty($y))
			<tr data-po="{{ $row->po_id }}">
				<td class="text-right">{{ $y }}</td>
				<td><a href="javascript:;" class="expand" data-po="{{ $row->po_id }}" title="Lihat Material"><i class="fa fa-navicon"></i>&nbsp;&nbsp;{{ $curr_po_no }}</a></td>
				<td colspan="5">&nbsp;</td>
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
			@endif

			<tr data-po="{{ $row->po_id }}" class="child">
				<td>&nbsp;</td>
				<td class="text-right">{{ $x . '.' . ++$z . '.' }}</td>
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
				<td class="text-right">&nbsp;</td>
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