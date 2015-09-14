material = {

	__construct: function(){

	},
	index: {
		init: function(){

			this._openSearchForm();
			this._closeSearchForm();
			this._focusingSearch();
			this._viewDetail();
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

			material.create._openSupplier();
			/*material.create._openSupplier(function(){
				var supId 	= $('input[name="sup_id"]').val();
				var inform 	= LIBS.callAjax('supplier/getInformation', 'sup_id=' + supId);
				var row		= JSON.parse(inform);

				$('span.sup_alamat').html(row.sup_alamat);
				$('span.sup_kota').html(row.sup_kota);
				$('span.sup_provinsi').html(row.sup_provinsi);
				$('span.sup_cp').html(row.sup_cp);

				$('.supp-info').slideUp(250, function(){
					$(this).slideDown();
				});
			});*/
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
				el.parent().next().html(other.satuan_p).next().html(other.satuan_r).next().children().val(0).parent().next().empty();

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
			this._dataTables();
			this._viewDetail();
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
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		}
	},
	acceptanceCreate: {
		init: function(){
			this._openPO();
			this._controlDiterima();
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
											alert('You clicked OK');
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
	}

}