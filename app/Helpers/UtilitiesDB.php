<?php

	function count_request(){
        $role = Auth::user()->hak_akses;
        if($role == 3 || $role == 6 || $role == 7) return 0;

        $count = DB::table('permintaan_barang')->where('visibility', 1);

        switch($role){
            case 1 :
                $count->whereNotIn('pb_status', [4, 5, 7]);
            break;
            case 2 :
                $count->where('pb_status', '=', 3);
                $count->where('pb_role_tolak', '<>', 5);
            break;
            case 4 :
                $count->where('pb_status', '=', 1);
            break;
            case 5 :
                $count->where('pb_status', '=', 2);
                $count->where('pb_role_tolak', '<>', 5);
            break;
            case 8 :
                $count->where('pb_status', '=', 6);
            break;
        }

        return $count->count();
    }
    function countDiterima($pos_id){
    	$total	= 0;
    	$get	= DB::table('penerimaan_sub_laravel')
    					->select('peners_jml')
    					->where('pos_id', '=', $pos_id)
    					->get();

    	foreach($get as $row){
    		$total += $row->peners_jml;
    	}

    	return $total;
    }
    function countReturDiterima($returpeners_id){
        $total  = 0;
        $get    = DB::table('penerimaan_returan_sub')
                        ->select('penereturs_jml')
                        ->where('returpeners_id', '=', $returpeners_id)
                        ->get();

        foreach($get as $row){
            $total += $row->penereturs_jml;
        }

        return $total;
    }
    function getLatest_PenerDate($po_id){
        return DB::table('penerimaan_laravel')
                    ->select('pener_date')
                    ->where('po_id', '=', $po_id)
                    ->orderBy('pener_date', 'DESC')
                    ->take(1)
                    ->pluck('pener_date');
    }
    function count_notif(){
        $role   = Auth::user()->hak_akses;
        $count  = DB::table('gbb_notification')->where('gn_read', 2);

        if($role != 1) $count->where('gn_role', $role);
        return $count->count();
    }
    function count_returApprovement(){
        $role = Auth::user()->hak_akses;
        if($role == 3 || $role == 8) return 0;

        $count = DB::table('retur_penerimaan_laravel')->where('visibility', 1);

        switch($role){
            case 1 : $count->where('returpener_status', '<>', 6); break;
            case 2 : $count->where('returpener_status', 5); break;
            case 4 : $count->where('returpener_status', 3); break;
            case 5 : $count->where('returpener_status', 4); break;
            case 6 : $count->where('returpener_status', 2); break;
            case 7 : $count->where('returpener_status', 1); break;
        }

        return $count->count();
    }
    function isDiterima($po_id){
        return DB::table('penerimaan_laravel')
                    ->where('po_id', $po_id)
                    ->count();
    }
    function getPOId($pener_id){
        return DB::table('penerimaan_laravel')
                    ->select('po_id')
                    ->where('pener_id', $pener_id)
                    ->take(1)
                    ->pluck('po_id');
    }
    function countChecklistQa(){
        $pener     = DB::table('penerimaan_laravel')->where(['qa_check' => 1, 'visibility' => 1])->count();
        $peneretur = DB::table('penerimaan_returan')->where(['qa_check' => 1, 'visibility' => 1])->count();
        $pengel    = DB::table('pengeluaran_laravel')->where(['qa_check' => 1, 'visibility' => 1])->count();

        return ($pener + $peneretur + $pengel);
    }
    function countApprMaterials(){
        if (! in_array(Auth::user()->hak_akses, [1, 2, 8])) return 0;
        return DB::table('material_laravel')->where('visibility', 2)->count();
    }
    function countTransacToday(){
        $pener     = DB::table('penerimaan_laravel')->where('visibility', 1)->whereDate('created_at', '=', now())->count();
        $peneretur = DB::table('penerimaan_returan')->where('visibility', 1)->whereDate('created_at', '=', now())->count();
        $pengel    = DB::table('pengeluaran_laravel')->where('visibility', 1)->whereDate('created_at', '=', now())->count();

        return ($pener + $peneretur + $pengel);
    }