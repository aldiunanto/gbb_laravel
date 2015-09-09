@extends('base')

@section('content')
<div class="top approving">
	<div class="tools">&nbsp;</div>
	<h2><span>2</span>Persetujuan Retur Penerimaan</h2>
	<div class="clearfix"></div>
</div>
<div class="main approving">	
	{!! session('message') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Supplier</th>
				<th>Tanggal Penerimaan</th>
				<th>Tanggal Diketahui</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-right">1.</td>
				<td>P/006/VIII/JIU/2015</td>
				<td>Aldi Unanto</td>
				<td class="text-center">28-08-2015</td>
				<td class="text-center">30-08-2015</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="" class="view-retur-detail"><i class="fa fa-eye"></i>Lihat Detail</a></li>
								<li class="separator">&nbsp;</li>

								<li><a href="" class="do-approve"><i class="fa fa-check"></i>Setujui</a></li>
								<li><a href="" class="do-reject"><i class="fa fa-remove"></i>Tolak</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
</div>
@endsection