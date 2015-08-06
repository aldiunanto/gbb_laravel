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

			<tr data-po="{{ $row->po_id }}" class="hidden child">
				<td>&nbsp;</td>
				<td class="text-right">{{ $x . '.' . ++$z . '.' }}</td>
				<td>{{ $row->mat_nama }}</td>
				<td class="text-center">{{ to_indDate($row->po_tgl_buat) }}</td>
				<td>{{ $row->pbs_jml }}</td>
				<td><a class="mat-acceptance" href="{{ url('po/matAcceptanceDetail/' . $row->pos_id) }}" title="Klik untuk lihat detail penerimaan material ini"><i class="fa fa-eye"></i> {{ countDiterima($row->pos_id) }}</a></td>
				<td class="text-center"><span class="status pm-reject-vice" title="Kurang 200, telat 2 hari">-200, -2D</span></td>
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
<span class="status vice-approve" title="Terpenuhi, tepat waktu">Closed, tepat</span>
-->

@endsection