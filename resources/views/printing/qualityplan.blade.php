@extends('printing')
@section('content')

<header>
	<div class="caption">
		<h1>report rencana mutu</h1>
		<h2>{{ $period }}</h2>
	</div>
</header>
<section>
	<h3>ppn</h3>
	<table class="data-list">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nomor PO</th>
				<th>Material</th>
				<th>QTY</th>
				<th>Unit</th>
				<th>Tgl Permintaan</th>
				<th>Tgl Datang</th>
			</tr>
		</thead>
		<tbody>
		@foreach($fetchp as $row)
			<tr>
				<td>{{ to_indDate($row->po_tgl_buat) }}</td>
				<td>{{ $row->po_no }}</td>

			<?php $sub = $Posub::fetchDetail($row->po_id); $x = 1; ?>
			@foreach($sub as $item)
				@if($x > 1)
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
				@endif

						<td class="left">{{ $item->mat_nama }}</td>
						<td class="right">{{ $item->pbs_jml }}</td>
						<td>{{ $item->mats_nama }}</td>
						<td>{{ to_indDate($row->po_tgl_kedatangan) }}</td>
						<td></td>
					</tr>

				<?php $x++; $partial = $Peners::partialForPrint($item->pos_id); ?>
				
				@if($row->po_is_partial == 1)
					@foreach($partial as $each)
						<tr>
							<td colspan="3"></td>
							<td class="right partial">{{ $each->peners_jml }}</td>
							<td class="partial"></td>
							<td class="partial"></td>
							<td class="partial">{{ to_indDate($each->pener_date) }}</td>
						</tr>
					@endforeach
				@endif
			@endforeach

		@endforeach
		</tbody>
	</table>

	<h3 class="h-nppn">non-ppn</h3>
	<table class="data-list">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nomor PO</th>
				<th>Material</th>
				<th>QTY</th>
				<th>Unit</th>
				<th>Tgl Permintaan</th>
				<th>Tgl Datang</th>
			</tr>
		</thead>
		<tbody>
		@foreach($fetchn as $row)
			<tr>
				<td>{{ to_indDate($row->po_tgl_buat) }}</td>
				<td>{{ $row->po_no }}</td>

			<?php $sub = $Posub::fetchDetail($row->po_id); $x = 1; ?>
			@foreach($sub as $item)
				@if($x > 1)
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
				@endif

						<td class="left">{{ $item->mat_nama }}</td>
						<td class="right">{{ $item->pbs_jml }}</td>
						<td>{{ $item->mats_nama }}</td>
						<td>{{ to_indDate($row->po_tgl_kedatangan) }}</td>
						<td></td>
					</tr>

				<?php $x++; $partial = $Peners::partialForPrint($item->pos_id); ?>
				
				@if($row->po_is_partial == 1)
					@foreach($partial as $each)
						<tr>
							<td colspan="3"></td>
							<td class="right partial">{{ $each->peners_jml }}</td>
							<td class="partial"></td>
							<td class="partial"></td>
							<td class="partial">{{ to_indDate($each->pener_date) }}</td>
						</tr>
					@endforeach
				@endif
			@endforeach

		@endforeach
		</tbody>
	</table>
</section>

@endsection