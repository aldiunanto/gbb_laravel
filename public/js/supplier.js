supplier = {

	__construct: function(){
		
	},
	index: {
		init: function(){

			this._openSearchForm();
			this._closeSearchForm();
			this._viewDetail();
			this._delete();

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
		_viewDetail: function(){
			$('.view-detail').on('click', function(e){
				e.preventDefault();

				var el = $(this);
				var href = el.attr('href');
				var splitHref = href.split('/');
				var popupContent = LIBS.callAjax(href);

				LIBS.popupDialog('open', {
					'caption'		: 'Supplier Detail',
					'content'		: popupContent,
					'posButtonText'	: (el.hasClass('no-print') ? 'OK' : 'ubah data supplier ini &raquo;'),
					'okAction'		: function(){
						if(el.hasClass('no-print')){
							LIBS.popupDialog('close');
						}else{
							window.location.href = options.baseUrl + 'supplier/edit/' + splitHref[splitHref.length-1];
						}
					},
					'cancelAction'	: function(){
						LIBS.popupDialog('close');
					}
				});
			});
		},
		_delete: function(){
			$('.delete').on('click', function(e){
				e.preventDefault();
				var el = $(this);

				LIBS.confirmation({
					'text'		: 'Anda yakin ingin menghapus data Supplier ini?',
					'okAction'	: function(){
						window.location.href = el.attr('href');
					}
				});
			});
		}
	}

}