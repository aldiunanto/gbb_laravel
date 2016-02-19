<?php

	function now($time = false){
        return date('Y-m-d' . ($time == true ? ' H:i:s' : ''));
    }
    function images_url($uri = ''){
    	return 'http://' . $_SERVER['HTTP_HOST'] . '/jaly_images/' . $uri;
    }
    function notif($type, $msg){
    	return '<div class="notif ' . $type . '"><p>' . $msg . '</p></div>';
    }
    function numbFormat($numb){
        $numb = number_format($numb, 2, ',', '.');
        return (strpos($numb, ',') ? rtrim(rtrim($numb, 0), ',') : $numb);
    }
    function current_route($type){
    	$path  = explode('@', Route::currentRouteAction());
    	$pathc = explode("\\", $path[0]);

    	if($type == 'class') return strtolower(end($pathc));
    	else return end($path);
    }
    function isWeekend($date) {
        return (date('N', strtotime($date)) >= 6);
    }
    function is_active($expect){
        if(current_route('class') == $expect) return 'class="active"';
    }
    function isDecimal($numb){
        if ( strpos( $numb, "." ) !== false ) {
            return true;
        }
        return false;
    }
    function convert_date($the_date, $date2, $view = 'short'){ 
        if($date2 == '') return '-';
        
        $str = '';
        switch($view){
            case 'short' :
                $d['y'] = '-T';
                $d['m'] = '-B';
                $d['d'] = '-H';
            break;
            default :
                $d['y'] = ' Tahun';
                $d['m'] = ' Bulan';
                $d['d'] = ' Hari';
            break;
        }
            
        $now = new DateTime($date2);
        $ref = new DateTime($the_date);
        $diff = $now->diff($ref);
            
        $date1 = strtotime($date2);
        $date2 = strtotime($the_date);
            
        if($date2 <= $date1){
            if($diff->y > 0){ $str .= $diff->y.$d['y'].', '; }
            if($diff->m > 0){ $str .= $diff->m.$d['m'].', '; }
            if($diff->d == 0){
                $str .= ($diff->d + 1).$d['d'];
            }else{
                $str .= $diff->d.$d['d'];
            }
        }else{
            $str .= '<span style="font-size: 10px; font-style: italic;">(Belum masuk kerja)</span>';
        }
            
        return $str;
    }
    function to_indDate($date){
        $path = explode('-', $date);
        return $path[2] . '-' . $path[1] . '-' . $path[0];
    }
    function romawi(){
        return [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
    }
    function libMonths(){
        return [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
    }
    function dateDiff($permintaan, $kedatangan){
        $str = '';
        $d = ['y' => ' Tahun', 'm' => ' Bulan', 'd' => ' Hari'];
            
        $now = new DateTime($kedatangan);
        $ref = new DateTime($permintaan);
        $diff = $now->diff($ref);
        
        $date1 = strtotime($kedatangan);
        $date2 = strtotime($permintaan);
        
        if($date1 > $date2){
            $str .= '<span class="status pm-reject-vice label">Terlambat ';
        }elseif($date1 < $date2){
            $str .= '<span class="status po-done label">Lebih cepat ';
        }else{
            return '<span class="status vice-approve label">Tepat waktu';
        }

        if($diff->y > 0){ $str .= $diff->y.$d['y'].', '; }
        if($diff->m > 0){ $str .= $diff->m.$d['m'].', '; }
        if($diff->d == 0){
            $str .= ($diff->d + 1).$d['d'];
        }else{
            $str .= $diff->d.$d['d'];
        }

        return $str . '</span>';
    }
    function poDateDiff($f, $s){
        $first  = new DateTime($f);
        $second = new DateTime($s);
        $diff = $first->diff($second);
        
        $date1 = strtotime($f); // tanggal penerimaan terakhir
        $date2 = strtotime($s); // tanggal permintaan

        if($date1 < $date2){
            $text['s']['t'] = 'lebih awal ' . $diff->d . ' hari';
            $text['s']['c'] = '+' . $diff->d . 'D';
            $text['s_type'] = 'fast';
        }elseif($date1 > $date2){
            $text['s']['t'] = 'telat ' . $diff->d . ' hari';
            $text['s']['c'] = '-' . $diff->d . 'D';
            $text['s_type'] = 'slow';
        }else{
            $text['s']['t'] = 'tepat waktu';
            $text['s']['c'] = 'tepat';
            $text['s_type'] = 'ontime';
        }

        return $text;
    }
    function generatePoNumb($get){
        if($get->count() > 0){
            $row = $get->first();
            $path = explode('/', $row->po_no);

            if(date('Y') == ($path[4] + 1)){
                $numb = $path[0] . '/' . '001' . '/' . romawi()[date('n')] . '/' . 'JIU' . '/' . date('Y');
            }else{
                $preffix = ''; $path[1]++;
                for($x = 0; $x < (3 - strlen($path[1])); $x++){
                    $preffix .= '0';
                }

                $numb = $path[0] . '/' . ($preffix . $path[1]) . '/' . romawi()[date('n')] . '/' . 'JIU' . '/' . date('Y');
            }
        }else{
            $numb = ($_POST['type'] == 'ppn' ? 'P' : 'NP') . '/' . '001' . '/' . romawi()[date('n')] . '/' . 'JIU' . '/' . date('Y');
        }

        return $numb;
    }