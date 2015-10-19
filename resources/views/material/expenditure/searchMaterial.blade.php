@if($fetch->count() > 0)
	@foreach($fetch as $row)
	<tr>
		<td><a href="javascript:;" data-id="{{ $row->mat_id }}" class="pick-button btn primary"><i class="fa fa-mail-reply"></i></a></td>
		<td>{{ $row->mat_nama }}</td>
		<td>{{ $row->sup_nama }}</td>
		<td class="text-center">{{ $row->mat_spesifikasi }}</td>
		<td>{{ $row->wrn_nama }}</td>
		<td>{{ $row->mats_nama }}</td>
		<td class="text-right">{{ $row->mat_stock_akhir }}</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="7">
			<div class="info warning text-center"><i>Data tidak ditemukan</i></div>
		</td>
	</tr>
@endif