material = {

	__construct: function(){

	},
	index: {
		init: function(){

			this._openSearchForm();
			this._closeSearchForm();
			this._focusingSearch();
			this._viewDetail();
			this._modifyDept();
			this._delete('Anda yakin ingin menghapus data material ini?');

		},
		_openSearchForm: function(){
			$('.btn-search').on('click', function(){
				$(this).slideUp(300, function(){
					$('.search').slideDown(150).find('input[type="text"]').focus();
				});
			});
		},
		_closeSearchForm: function(){
			$('.search .fa-close').on('click', function(){
				$(this).closest('.search').slideUp(300, function(){
					$('.btn-search').slideDown(150);
				});
			});
		},
		_focusingSearch: function(){
			$('select[name="field"]').on('change', function(){
				$('input[name="s"]').focus();
			});
		},
		_viewDetail: function(){
			$('.view-detail').on('click', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var splitHref = href.split('/');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Material Detail',
					'content'		: popupContent,
					'posButtonText'	: (el.hasClass('no-print') ? 'ok' : 'ubah data material ini &raquo;'),
					'okAction'		: function(){
						if(el.hasClass('no-print')){
							LIBS.popupDialog('close');
						}else{
							window.location.href = options.baseUrl + 'material/edit/' + splitHref[splitHref.length-1];
						}
					},
					'cancelAction'	: function(){
						LIBS.popupDialog('close');
					}
				});
			});
		},
		_delete: function(text){
			$('.delete').on('click', function(e){
				e.preventDefault();
				var el = $(this);

				LIBS.confirmation({
					'text'		: text,
					'okAction'	: function(){
						window.location.href = el.attr('href');
					}
				});
			});
		},
		_modifyDept: function(){
			$('a.modify-dept').on('click', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var splitHref = href.split('/');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Bagian / Departemen',
					'content'		: popupContent,
					'posButtonText'	: 'simpan',
					'okAction'		: function(){
						var data  = 'mat_id=' + splitHref[splitHref.length-1];
							data += '&deptbg_id=' + $('select[name="deptbg_id"]').val();

						LIBS.callAjax('material/modifyDept', data);
						window.location.reload(true);
					},
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			})
		}
	},
	create: {
		init: function(){
			this._openSupplier();
		},
		_openSupplier: function(doSomething){
			var self = this;
			$('.open-supplier').on('click', function(){
				LIBS.popupDialog('open', {
					'caption'		: 'Pilih Supplier',
					'content'		: LIBS.callAjax('supplier/getData'),
					'posButtonText'	: 'YES',
					'okAction'		: function(){  },
					'cancelAction'	: function(){ 
						LIBS.popupDialog('close');
					},
					'doSomething'	: function(){
						$('button.positive').hide();
						self._searchSupplier();
						self._takeMeOut(doSomething);
					}
				});
			});
		},
		_searchSupplier: function(){
			var doFilter = function(){
				var filterVal = $('input[name="filter"]').val();

				if(filterVal == ''){
					$('.sup-item').fadeIn();
				}else{
					$('.sup-item[data-name*="' + filterVal.toUpperCase() + '"]').fadeIn();
					$('.sup-item:not([data-name*="' + filterVal.toUpperCase() + '"])').hide();
				}
			};

			var timer = null;
			$('input[name="filter"]').keydown(function(){
				clearTimeout(timer);
				timer = setTimeout(doFilter, 1000);
			});
		},
		_takeMeOut: function(doSomething){
			$('.pick-button').on('click', function(){
				var name = $(this).parent().next().html();

				$('input[name="sup_id"]').val($(this).attr('data-id'));
				$('input[name="sup_nama"]').val(name);

				LIBS.popupDialog('close');

				if(typeof doSomething === 'function') doSomething();
			});
		}
	},
	edit: {
		init: function(){
			this._setPrivilege();
		},
		_setPrivilege: function(){
			var role = $('input[name="_role"]').val();
			if(role != '3' && role != 4){
				material.create._openSupplier();
			}
		}
	},
	request: {
		init: function(){
			this._viewRequestDetail();
			this._doApprove();
			this._doReject();
			this._cancel();
			
			material.index._delete('Anda yakin ingin menghapus Permintaan Material ini?');
			material.index._openSearchForm();
			material.index._closeSearchForm();
		},
		_viewRequestDetail: function(){
			if($('input[name="pm"]').length > 0){
				$('.view-request-detail').on('click', function(e){
					e.preventDefault();

					var href = $(this).attr('href');
					var popupContent = LIBS.callAjax(href);

					LIBS.popupDialog('open', {
						'caption'		: 'PM Detail',
						'content'		: popupContent,
						'posButtonText'	: 'OK',
						'okAction'		: function(){ LIBS.popupDialog('close'); },
						'cancelAction'	: function(){ LIBS.popupDialog('close'); }
					});
				});
			}
		},
		_doApprove: function(){
			$('.do-approve').on('click', function(e){
				e.preventDefault();
				var el = $(this);

				LIBS.confirmation({
					'text'		: 'Apakah anda yakin akan meng-approve Permintan Material ini?',
					'okAction'	: function(){
						window.location.href = el.attr('href');
					}
				});
			});
		},
		_doReject: function(){
			$('.do-reject').on('click', function(e){
				e.preventDefault();

				var splitHref 		= $(this).attr('href').split('/');
				var popupContent 	= LIBS.callAjax('material/request/getRejectForm', 'pb_id=' + splitHref[splitHref.length-1]);

				LIBS.popupDialog('open', {
					'caption'		: 'PM ditolak - alasan..',
					'content'		: popupContent,
					'posButtonText'	: 'Tolak',
					'okAction'		: function(){
						var data  = 'pb_alasan_tolak=' + $('textarea[name="pb_alasan_tolak"]').val();
							data += '&pb_id=' + $('input[name="pb_id"]').val();

						LIBS.callAjax('material/request/reject', data);
						window.location.href = options.baseUrl + 'material/request';
					},
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		},
		_cancel: function(text){
			$('.cancel').on('click', function(e){
				e.preventDefault();
				var el = $(this);

				LIBS.confirmation({
					'text'		: 'Apakah anda yakin ingin membatalkan Permintaan Material ini?',
					'okAction'	: function(){
						window.location.href = el.attr('href');
					}
				});
			});
		}
	},
	requestCreate: {
		init: function(){
			this._getDatePicker();
			this._openMaterial();
			this._removeRow();
			this._calculateComparison();
			this._addItem();
			this._createPO();

			material.create._openSupplier(function(){
				$('form .data-list tbody').empty();
			});
		},
		_getDatePicker: function(){
			if($('.date-picker').length > 0){
				$('.date-picker').datepicker({
					dateFormat	: 'yy-mm-dd',
					changeMonth	: true,
					changeYear	: true
				});
			}
		},
		_openMaterial: function(){
			var self = this;

			$('.open-material').on('click', function(){
				var supId = $('input[name="sup_id"]').val();
				var el = $(this);

				if(supId == ''){
					$('.info.warning').after('<div class="info error">Anda belum memilih Supplier!</div>');
					$('html, body').animate({ scrollTop : 0 }, 300);
				}else{
					LIBS.popupDialog('open', {
						'caption'		: 'Pilih Material (Supplier: ' + $('input[name="sup_nama"]').val() + ')',
						'content'		: LIBS.callAjax('material/request/getData', 'sup_id=' + supId),
						'posButtonText'	: '',
						'okAction'		: function(){  },
						'cancelAction'	: function(){ 
							LIBS.popupDialog('close');
						},
						'doSomething'	: function(){
							$('button.positive').hide();

							self._searchMaterial();
							self._takeMeOut(el);
						}
					});
				}
			});
		},
		_searchMaterial: function(){
			var doFilter = function(){
				var filterVal = $('input[name="filter"]').val();

				if(filterVal == ''){
					$('.mat-item').fadeIn();
				}else{
					$('.mat-item[data-name*="' + filterVal.toUpperCase() + '"]').fadeIn();
					$('.mat-item:not([data-name*="' + filterVal.toUpperCase() + '"])').hide();
				}
			};

			var timer = null;
			$('input[name="filter"]').keydown(function(){
				clearTimeout(timer);
				timer = setTimeout(doFilter, 1000);
			});
		},
		_takeMeOut: function(el){
			$('.pick-button').on('click', function(){
				var mat_nama 	= $(this).parent().next().html();
				var mat_id		= $(this).attr('data-id');

				var other 	= LIBS.callAjax('material/request/getDetailItem', 'mat_id=' + mat_id);
				other		= JSON.parse(other);

				el.prev().val(other.mat_harga).prev().val(other.mat_perbandingan).prev().val(mat_id).prev().val(mat_nama);
				el.parent().next().html(other.mat_spesifikasi).next().html(other.satuan_p).next().html(other.satuan_r).next().children().val(0).parent().next().empty();

				LIBS.popupDialog('close');
			});
		},
		_removeRow: function(){
			$('.remove-row').on('click', function(){
				$(this).parent().parent().remove();
			});
		},
		_calculateComparison: function(){
			$('input[name="pbs_jml[]"]').on('keyup', function(){
				if(isNaN($(this).val())){ $(this).val(0); }
				else{
					var compareWith = $(this).closest('tr').find('input[name="mat_perbandingan[]"]').val();
					var jmlGudang	= $(this).val() * compareWith;

					$(this).parent().next().html(jmlGudang);
				}
			});
		},
		_addItem: function(){
			var self = this;

			$('.caption .add-item').on('click', function(e){
				e.preventDefault();
				var newTr = LIBS.callAjax('material/request/getRowItem');

				$('.data-list tbody').append(newTr);
				$('html, body').animate({ scrollTop: $(document).height() }, 300);

				self._openMaterial();
				self._removeRow();
				self._calculateComparison();
			});
		},
		_createPO: function(){
			$('select[name="create_po"]').on('change', function(){
				if($(this).val() === '1') $('.create-po-info').slideDown();
				else $('.create-po-info').slideUp();
			});
		}
	},
	requestEdit: {
		init: function(){
			material.create._openSupplier();
			material.requestCreate._getDatePicker();
			material.requestCreate._openMaterial();
			material.requestCreate._removeRow();
			material.requestCreate._calculateComparison();
			material.requestCreate._addItem();
		}
	},

	acceptance: {
		init: function(){
			this._viewDetail();
			this._acceptanceDetail();

			material.index._focusingSearch();

			//this._dataTables();
		},
		_dataTables: function(){
			if($('.main table.data-list.index').length > 0){
				$('.main table.data-list').DataTable({
					'aoColumnDefs' : [
						{ 'bSortable' : false, 'aTargets' : [0, 5, 6] }
					]
				});
			}
		},
		_viewDetail: function(){
			var self = this;

			$('.main table.data-list').on('click', '.view-detail', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var splitHref = href.split('/');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Detail Daftar Penerimaan',
					'content'		: popupContent,
					'okAction'		: function(){ LIBS.popupDialog('close'); },
					'cancelAction'	: function(){ LIBS.popupDialog('close'); },
					'doSomething'	: function(){
						self._expandRetur();
					}
				});
			});
		},
		_expandRetur: function(){
			$('.expand-retur').on('click', function(e){
				var el 		= $(this);
				var penerId = el.attr('data-id');

				if(! el.hasClass('expanded')){
					var returContent = LIBS.callAjax('material/acceptance/returContent', 'penerId=' + penerId);
					$('tr[data-id="' + penerId + '"]:last').after(returContent);

					el.addClass('expanded');
					el.html('Tutup Returan <i class="fa fa-angle-up"></i>')
				}else{
					$('tr[data-retur-content="' + penerId + '"]').remove();
					
					el.removeClass('expanded');
					el.html('Lihat Returan <i class="fa fa-angle-down"></i>');
				}
			});
		},
		_acceptanceDetail: function(){
			$('.main table.data-list').on('click', '.acceptance-detail', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Detail Penerimaan',
					'content'		: popupContent,
					'posButtonText'	: 'ok',
					'okAction'		: function(){ LIBS.popupDialog('close'); },
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			})
		}
	},
	acceptanceCreate: {
		init: function(){
			this._openPO();
			//this._controlDiterima();
		},
		_openPO: function(){
			var self = this;
			$('.open-po').on('click', function(){
				LIBS.popupDialog('open', {
					'caption'		: 'Pilih PO',
					'content'		: LIBS.callAjax('material/acceptance/getPO'),
					'posButtonText'	: 'YES',
					'okAction'		: function(){  },
					'cancelAction'	: function(){ 
						LIBS.popupDialog('close');
					},
					'doSomething'	: function(){
						$('button.positive').hide();
						self._searchPO();
					}
				});
			});
		},
		_searchPO: function(){
			var form = $('.get-po form');
			form.on('submit', function(e){ e.preventDefault(); });
			
			var doFilter = function(){
				var filterVal = $('input[name="filter"]').val();

				if(filterVal != ''){
					var result = LIBS.callAjax(form.attr('action'), form.serialize());
					$('#popup .list table tbody').html(result);
				}
			};

			var timer = null;
			$('input[name="filter"]').keydown(function(){
				clearTimeout(timer);
				timer = setTimeout(doFilter, 1000);
			});
		},
		_controlDiterima: function(){
			$('input.peners').on('change', function(){
				var acceptance 	= $(this).parent().prev().prev().html();
				var received	= $(this).parent().prev().html();
				var diff		= acceptance - received;

				if($(this).val() > diff){
					alert('Maksimal diterima = ' + diff);
					$(this).css('border', '1px solid #ff0000');
				}else{
					$(this).css('border', '1px solid #c2c1c1');
				}
			});
		}
	},
	acceptanceRetur: {
		init: function(){
			this._returDetail();
			this._doApprove();
			this._doReject();

			material.index._openSearchForm();
			material.index._closeSearchForm();
			material.index._focusingSearch();
			material.index._delete('Anda yakin ingin menghapus Retur Penerimaan Material ini?');
		},
		_returDetail: function(){
			$('.view-retur-detail').on('click', function(e){
				var el = $(this);
				e.preventDefault();

				LIBS.popupDialog('open', {
					'caption'		: 'Retur Detail',
					'content'		: LIBS.callAjax(el.attr('href')),
					'posButtonText'	: 'ok',
					'okAction'		: function(){ LIBS.popupDialog('close'); },
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		},
		_doApprove: function(){
			$('.do-approve').on('click', function(e){
				e.preventDefault();
				var el = $(this);

				LIBS.confirmation({
					'text'		: 'Apakah anda yakin akan meng-approve Retur Penerimaan Material ini?',
					'okAction'	: function(){
						if(el.hasClass('vd')){
							$('#confirmation .container').slideUp(300, function(){
								$(this).parent().fadeOut(200, function(){
									LIBS.popupDialog('open', {
										'caption'		: 'Keterangan Tambahan',
										'content'		: LIBS.callAjax('material/acceptance/retur/acceptForm'),
										'cancelAction'	: function(){ LIBS.popupDialog('close'); },
										'okAction'		: function(){
											var $desc = $('textarea[name="returpener_vd_desc"]');

											if($desc.val()){
												var splitted = el.attr('href').split('/');
												var data = 'returpener_id=' + splitted[splitted.length-1] + '&desc=' + $desc.val();

												LIBS.callAjax('material/acceptance/retur/saveVdDesc', data);
											}

											window.location.href = el.attr('href');
										}
									});
								});
							});
						}else{
							window.location.href = el.attr('href');
						}
					}
				});
			});
		},
		_doReject: function(){
			$('.do-reject').on('click', function(e){
				e.preventDefault();

				var splitHref 		= $(this).attr('href').split('/');
				var popupContent 	= LIBS.callAjax('material/acceptance/retur/getRejectForm', 'returpener_id=' + splitHref[splitHref.length-1]);

				LIBS.popupDialog('open', {
					'caption'		: 'Returan ditolak - alasan..',
					'content'		: popupContent,
					'posButtonText'	: 'Tolak',
					'okAction'		: function(){
						var data  = 'returpener_reject_reason=' + $('textarea[name="returpener_reject_reason"]').val();
							data += '&returpener_id=' + $('input[name="returpener_id"]').val();


						LIBS.callAjax('material/acceptance/retur/reject', data);
						window.location.href = options.baseUrl + 'material/acceptance/retur';
					},
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		}
	},
	acceptanceReturCreate: {
		init: function(){
			this._controlDiretur();
		},
		_controlDiretur: function(){
			$('input[name="jml_retur[]"]').on('change', function(){
				var max = parseInt($(this).parent().prev().html());
				if($(this).val() > max){
					alert('Maksimal diretur = ' + max);
					$(this).css('border', '1px solid #ff0000');
				}else{
					$(this).css('border', '1px solid #c2c1c1');
				}
			});
		}
	},
	acceptanceReturAcceptance: {
		init: function(){
			//this._dataTables();
			this._viewDetail();
			material.index._focusingSearch();
		},
		_dataTables: function(){
			if($('.main table.data-list.index').length > 0){
				$('.main table.data-list').DataTable({
					'aoColumnDefs' : [
						{ 'bSortable' : false, 'aTargets' : [7] }
					]
				});
			}
		},
		_viewDetail: function(){
			$('.main table.data-list').on('click', '.view-detail', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var splitHref = href.split('/');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Detail Penerimaan Returan',
					'content'		: popupContent,
					'okAction'		: function(){ LIBS.popupDialog('close'); },
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		}
	},
	acceptanceReturAcceptanceCreate: {
		init: function(){
			this._openPO();
			material.requestCreate._getDatePicker();
			//this._controlDiterima();
		},
		_openPO: function(){
			var self = this;
			$('.open-po').on('click', function(){
				LIBS.popupDialog('open', {
					'caption'		: 'Pilih PO',
					'content'		: LIBS.callAjax('material/acceptance/retur/openRetur'),
					'posButtonText'	: 'YES',
					'okAction'		: function(){  },
					'cancelAction'	: function(){ 
						LIBS.popupDialog('close');
					},
					'doSomething'	: function(){
						$('button.positive').hide();
						self._searchRetur();
					}
				});
			});
		},
		_searchRetur: function(){
			var form = $('.get-po form');
			form.on('submit', function(e){ e.preventDefault(); });
			
			var doFilter = function(){
				var filterVal = $('input[name="filter"]').val();

				if(filterVal != ''){
					var result = LIBS.callAjax(form.attr('action'), form.serialize());
					$('#popup .list table tbody').html(result);
				}
			};

			var timer = null;
			$('input[name="filter"]').keydown(function(){
				clearTimeout(timer);
				timer = setTimeout(doFilter, 1000);
			});
		},
		_controlDiterima: function(){
			$('input.peners').on('change', function(){
				var max = parseInt($(this).parent().prev().prev().html());
				if($(this).val() > max){
					alert('Maksimal diterima = ' + max);

					$(this).css('border', '1px solid #ff0000');
				}else{
					$(this).css('border', '1px solid #c2c1c1');
				}
			});
		}
	},
	expenditure: {
		init: function(){
			material.index._openSearchForm();
			material.index._closeSearchForm();
			material.index._delete('Anda yakin ingin menghapus data Pengeluaran Material ini?');

			this._checkIfDatePicker();
			this._viewExpenditureDetail();
		},
		_checkIfDatePicker: function(){
			$('select[name="field"]').on('change', function(){
				if($(this).val() == 'pengel_date'){
					$('input[name="s"]').datepicker({
						dateFormat	: 'yy-mm-dd',
						changeMonth	: true,
						changeYear	: true
					});
				}else{
					$('input[name="s"]').datepicker('destroy');
				}
			});
		},
		_viewExpenditureDetail: function(){
			$('.view-detail').on('click', function(e){
				e.preventDefault();

				var href = $(this).attr('href');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Detail Pengeluaran Barang',
					'content'		: popupContent,
					'posButtonText'	: 'OK',
					'okAction'		: function(){ LIBS.popupDialog('close'); },
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		}
	},
	expenditureCreate: {
		init: function(){
			material.requestCreate._getDatePicker();

			this._openMaterial();
			this._addRowItem();
			this._removeRow();
		},
		_openMaterial: function(){
			var self = this;

			$('.open-material').on('click', function(){
				var el = $(this);
				LIBS.popupDialog('open', {
					'caption'		: 'Pilih Material',
					'content'		: LIBS.callAjax('material/expenditure/getMaterial'),
					'posButtonText'	: null,
					'okAction'		: null,
					'cancelAction'	: function(){
						LIBS.popupDialog('close');
					},
					'doSomething'	: function(){
						$('button.positive').hide();

						material.index._focusingSearch();
						self._searchMaterial(el);
						self._chooseMaterial(el);
					}
				});
			});
		},
		_searchMaterial: function(el){
			var self = this;
			$('.material-list form').on('submit', function(e){
				e.preventDefault();

				var result = LIBS.callAjax($(this).attr('action'), $(this).serialize());
				$('.material-list .list tbody').html(result);
				
				self._chooseMaterial(el);
			});
		},
		_chooseMaterial: function(el){
			$('.pick-button').on('click', function(){
				var data = LIBS.callAjax('material/expenditure/chooseMaterial', 'mat_id=' + $(this).attr('data-id'));
				row = JSON.parse(data);

				var detail  = '<table class="mat-detail">';
					detail += '<tr><td>Satuan P</td><td>:</td><td>' + row.satuan_p + '</td></tr>';
					detail += '<tr><td>Satuan R</td><td>:</td><td>' + row.satuan_r + '</td></tr>';
					detail += '<tr><td>Perbandingan</td><td>:</td><td>1:' + row.mat_perbandingan + '</td></tr>';
					detail += '<tr><td>Stock Akhir</td><td>:</td><td>' + Math.round((row.mat_stock_akhir * row.mat_perbandingan)) + ' ' + row.satuan_r + '</td></tr></table>';

				if(el.next('.mat-detail').length > 0){
					el.next().remove();
				}

				el.after(detail);
				el.prev().val(row.mat_perbandingan).prev().val(row.mat_id).prev().val(row.mat_nama);
				el.parent().next().html(row.wrn_nama).next().html(row.mat_spesifikasi).next().find('input').focus();

				LIBS.popupDialog('close');
			});
		},
		_addRowItem: function(){
			var self = this;
			
			$('.add-item').on('click', function(e){
				e.preventDefault();
				
				var row = LIBS.callAjax('material/expenditure/getRowItem');
				
				$('.data-list.expenditure > tbody').append(row);
				$('html, body').animate({ scrollTop: $(document).height() }, 300);
				
				self._openMaterial();
				self._removeRow();
			})
		},
		_removeRow: function(){
			$('.remove-row').on('click', function(){
				$(this).parent().parent().remove();
			})
		}
	},
	closingStock: {
		init: function(){
			this._areYouSure();
		},
		_areYouSure: function(){
			$('.form form').on('submit', function(e){
				var form = this;
				e.preventDefault();

				LIBS.confirmation({
					'text'		: 'Pemrosesan Closing Stok tidak bisa diurungkan setelah anda mengklik \'OK\'. Lanjutkan?',
					'okAction'	: function(){ form.submit(); }
				});
			});
		}
	}

}