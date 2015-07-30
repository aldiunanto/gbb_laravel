@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('po') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
					<option value="pb_no" <?php echo $isSelected('pb_no') ?>>Nomor PM</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
	</div>
	<h2>Data List PO <span>0 dari 0</span></h2>
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
			<tr>
				<td class="text-right">1.</td>
				<td>P/001/VII/JIU/2015</td>
				<td>Kaos</td>
				<td class="text-center">24-07-15</td>
				<td>200</td>
				<td><a class="mat-acceptance no-print" href="{{ url('po/matAcceptanceDetail/the_id') }}" title="Klik untuk lihat detail penerimaan material ini"><i class="fa fa-eye"></i> 150</a></td>
				<td class="text-center"><span class="status pm-reject-vice" title="Kurang 200, telat 2 hari">-200, -2D</span></td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('po/show/po_id') }}" class="view-detail"><i class="fa fa-eye"></i>Detail PO</a></li>
								<li><a href="{{ url('') }}"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
								
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('printing/po/po_id') }}" target="_blank" ><i class="fa fa-print"></i>Cetak PO</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="text-right">2.</td>
				<td>NP/001/VII/JIU/2015</td>
				<td>Kaos</td>
				<td class="text-center">04-06-15</td>
				<td>121</td>
				<td><a class="mat-acceptance no-print" href="{{ url('po/matAcceptanceDetail/the_id') }}" title="Klik untuk lihat detail penerimaan material ini"><i class="fa fa-eye"></i> 150</a></td>
				<td class="text-center"><span class="status pm-reject-ppic" title="Kurang 200, lebih awal 2 hari">-200, +2D</span></td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('po/show/po_id') }}" class="view-detail"><i class="fa fa-eye"></i>Detail PO</a></li>
								<li><a href="{{ url('') }}"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
								
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('printing/po/po_id') }}" target="_blank"><i class="fa fa-print"></i>Cetak PO</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="text-right">3.</td>
				<td>P/002/VII/JIU/2015</td>
				<td>Kutang</td>
				<td class="text-center">26-07-15</td>
				<td>230</td>
				<td><a class="mat-acceptance no-print" href="{{ url('po/matAcceptanceDetail/the_id') }}" title="Klik untuk lihat detail penerimaan material ini"><i class="fa fa-eye"></i> 150</a></td>
				<td class="text-center"><span class="status vice-approve" title="Terpenuhi, tepat waktu">Closed, tepat</span></td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('po/show/po_id') }}" class="view-detail"><i class="fa fa-eye"></i>Detail PO</a></li>
								<li><a href="{{ url('') }}"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
								
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('printing/po/po_id') }}" target="_blank"><i class="fa fa-print"></i>Cetak PO</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>

	<?php //echo $fetch->render() ?>
</div>
@endsection