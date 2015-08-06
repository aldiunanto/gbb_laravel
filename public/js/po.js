po = {

	__construct: function(){

	},
	index: {
		init: function(){
			this._openSearchForm();
			this._closeSearchForm();
			this._focusingSearch();
			this._viewDetail();
			this._expandMaterial();
			this._matAcceptanceDetail();
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
				if($(this).val() == 'po_tgl_butuh'){
					$('input[name="s"]').datepicker({
						dateFormat	: 'yy-mm-dd',
						changeMonth	: true,
						changeYear	: true
					});
				}else{
					$('input[name="s"]').datepicker('destroy').removeAttr('id class');
				}

				$('input[name="s"]').focus();
			});
		},
		_viewDetail: function(){
			$('.view-detail').on('click', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'PO Detail',
					'content'		: popupContent,
					'posButtonText'	: (el.hasClass('no-print') ? 'ok' : 'cetak'),
					'okAction'		: function(){
						if(el.hasClass('no-print')){
							LIBS.popupDialog('close');
						}else{
							var splitted = href.split('/');
							window.location.href = options.baseUrl + 'printing/po/' + splitted[splitted.length - 1];
						}
					},
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		},
		/*_viewPmDetail: function(){
			$('.pm-detail').on('click', function(e){
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
		},*/
		_expandMaterial: function(){
			$('.data-list .expand').on('click', function(){
				var poId = $(this).attr('data-po');
				
				if($(this).hasClass('expanded')){
					$('tr.child[data-po="' + poId + '"]').addClass('hidden');
					$(this).removeClass('expanded');
				}else{
					$('a.expand').removeClass('expanded');
					$('tr.child').addClass('hidden');
					$('tr.child[data-po="' + poId + '"]').removeClass('hidden');

					$(this).addClass('expanded');
				}
			});
		},
		_matAcceptanceDetail: function(){
			$('.mat-acceptance').on('click', function(e){
				e.preventDefault();
				var popupContent = LIBS.callAjax($(this).attr('href'));

				LIBS.popupDialog('open', {
					'caption'		: 'Detail Penerimaan Material',
					'content'		: popupContent,
					'posButtonText'	: 'OK',
					'okAction'		: function(){ LIBS.popupDialog('close'); },
					'cancelAction'	: function(){ LIBS.popupDialog('close'); }
				});
			});
		}
	},
	create: {
		init: function(){
			this._getDatePicker();	
			this._generatePoNumb();
			this._calculate();
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
		_generatePoNumb: function(){
			$('.generate-numb').on('click', function(){
				var type = $(this).attr('data-type');
				var output = LIBS.callAjax('po/generateNumb', 'type=' + type);

				$('input[name="po_no"]').val(output);

				if(type == 'ppn'){ $('.row-ppn, .row-final').show(); }
				else{ $('.row-ppn, .row-final').hide(); }
			});
		},
		_calculate: function(){
			$('input[name="pos_discount[]"]').on('keyup', function(){
				var dis 	= parseFloat($(this).val());
				var cost 	= parseFloat($(this).parent().parent().find('input[name="pos_harga[]"]').val());
				var qty		= parseFloat($(this).parent().next().html());

				var subTotal = (cost - ((cost * dis) / 100)) * qty;

				$(this).parent().next().next().find('.money').html(subTotal);

				var total = 0;
				$('.po-sub tbody tr').each(function(){
					var currSubTotal = parseFloat($(this).find('td:last .money').html());
					total += currSubTotal;
				});
				var ppn 		= (total * 0.1);
				var finalTotal	= total + ppn;

				$('.total .row-total td:last .money').html(total);
				$('.total .row-ppn td:last .money').html(ppn);
				$('.total .row-final td:last .money').html(finalTotal);
			});
		}
	}

}