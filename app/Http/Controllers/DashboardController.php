<?php

namespace App\Http\Controllers;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){        
        // For development
        return view('dashboard.dashboard-admin');

        // For production
        if(auth()->user()->level === 'pimpinan'){
            return view('dashboard.dashboard-admin');
        }else{
            return view('dashboard.dashboard-user');
        }
    }

    public function dashboardData(Request $request){
        // Pakai Bahasa Indonesia tapi kurang baku (Solusi Carbon tidak berfungsi)
        DB::select(DB::raw("SET lc_time_names = 'id_ID'"));

        // Transaksi Hari Ini
        $masukHari = (int) TMasuk::whereDate('tanggal', '=', date('Y-m-d'))->sum('nominal');
        $keluarHari = (int) TKeluar::whereDate('tanggal', '=', date('Y-m-d'))->sum('nominal');

        // Transaksi Seminggu
        $masukSeminggu = DB::table(DB::raw("(WITH Recursive days AS ( SELECT DATE_SUB(NOW(), INTERVAL 7 DAY) AS day_date UNION SELECT DATE_ADD(day_date, INTERVAL 1 DAY) FROM days WHERE day_date < NOW() ) SELECT DATE_FORMAT(day_date, '%W, %d %M %Y') AS hari_tanggal, COALESCE(SUM(t_masuks.nominal), 0) AS total FROM days LEFT JOIN t_masuks ON DATE(day_date) = t_masuks.tanggal GROUP BY day_date, DATE(day_date) ORDER BY DATE(day_date)) as sub"))
                        ->get();
        $keluarSeminggu = DB::table(DB::raw("(WITH Recursive days AS ( SELECT DATE_SUB(NOW(), INTERVAL 7 DAY) AS day_date UNION SELECT DATE_ADD(day_date, INTERVAL 1 DAY) FROM days WHERE day_date < NOW() ) SELECT DATE_FORMAT(day_date, '%W, %d %M %Y') AS hari_tanggal, COALESCE(SUM(t_keluars.nominal), 0) AS total FROM days LEFT JOIN t_keluars ON DATE(day_date) = t_keluars.tanggal GROUP BY day_date, DATE(day_date) ORDER BY DATE(day_date)) as sub"))
                        ->get();

        // Transaksi 4 Minggu
        $masuk4Week = DB::table(DB::raw("(SELECT
                1 AS week,
                DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY) AS start_date,
                DATE_ADD(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 6 DAY) AS end_date
                UNION ALL
                SELECT
                2 AS week,
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 7 DAY),
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 1 DAY)
                UNION ALL
                SELECT
                3 AS week,
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 14 DAY),
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 8 DAY)
                UNION ALL
                SELECT
                4 AS week,
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 21 DAY),
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 15 DAY)
                ) AS q"))
            ->selectRaw("week, DATE_FORMAT(start_date, '%d-%m-%Y') AS start_date, DATE_FORMAT(end_date, '%d-%m-%Y') AS end_date, COALESCE(SUM(nominal),0) AS total")
            ->leftJoin('t_masuks', function ($join) {
            $join->on('t_masuks.tanggal', '>=', 'q.start_date')
            ->on('t_masuks.tanggal', '<=', 'q.end_date');
            })
            ->groupBy("week", "start_date", "end_date")
            ->orderBy("week", "DESC")
            ->get();
        $keluar4Week = DB::table(DB::raw("(SELECT
                1 AS week,
                DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY) AS start_date,
                DATE_ADD(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 6 DAY) AS end_date
                UNION ALL
                SELECT
                2 AS week,
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 7 DAY),
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 1 DAY)
                UNION ALL
                SELECT
                3 AS week,
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 14 DAY),
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 8 DAY)
                UNION ALL
                SELECT
                4 AS week,
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 21 DAY),
                DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 15 DAY)
                ) AS q"))
            ->selectRaw("week, DATE_FORMAT(start_date, '%d-%m-%Y') AS start_date, DATE_FORMAT(end_date, '%d-%m-%Y') AS end_date, COALESCE(SUM(nominal),0) AS total")
            ->leftJoin('t_keluars', function ($join) {
            $join->on('t_keluars.tanggal', '>=', 'q.start_date')
            ->on('t_keluars.tanggal', '<=', 'q.end_date');
            })
            ->groupBy("week", "start_date", "end_date")
            ->orderBy("week", "DESC")
            ->get();

        // Transaksi Setahun Terakhir
        $masukSetahun = DB::table(DB::raw("(WITH Recursive months AS ( SELECT DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 YEAR)), INTERVAL 1 DAY) AS month_date UNION SELECT DATE_ADD(month_date, INTERVAL 1 MONTH) FROM months WHERE month_date < LAST_DAY(NOW()) ) SELECT DATE_FORMAT(month_date, '%M %Y') AS month_year, COALESCE(SUM(t_masuks.nominal), 0) AS total, month_date FROM months LEFT JOIN t_masuks ON months.month_date BETWEEN DATE_SUB(t_masuks.tanggal, INTERVAL DAY(t_masuks.tanggal) - 1 DAY) AND LAST_DAY(t_masuks.tanggal) GROUP BY month_year, month_date ORDER BY month_date LIMIT 12) as sub"))
            ->select("month_year", DB::raw("SUM(total) as total"))
            ->groupBy("month_year")
            ->orderBy("month_date")
            ->get();
        $keluarSetahun = DB::table(DB::raw("(WITH Recursive months AS ( SELECT DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 YEAR)), INTERVAL 1 DAY) AS month_date UNION SELECT DATE_ADD(month_date, INTERVAL 1 MONTH) FROM months WHERE month_date < LAST_DAY(NOW()) ) SELECT DATE_FORMAT(month_date, '%M %Y') AS month_year, COALESCE(SUM(t_keluars.nominal), 0) AS total, month_date FROM months LEFT JOIN t_keluars ON months.month_date BETWEEN DATE_SUB(t_keluars.tanggal, INTERVAL DAY(t_keluars.tanggal) - 1 DAY) AND LAST_DAY(t_keluars.tanggal) GROUP BY month_year, month_date ORDER BY month_date LIMIT 12) as sub"))
            ->select("month_year", DB::raw("SUM(total) as total"))
            ->groupBy("month_year")
            ->orderBy("month_date")
            ->get();
        
        // Parsing Seminggu
        $labelSeminggu = [];
        $dataMasukSeminggu = [];
        $dataKeluarSeminggu = [];
        foreach ($masukSeminggu as $value) {
            $value = (array) $value;
            array_push($labelSeminggu, $value['hari_tanggal']);
            array_push($dataMasukSeminggu, intval($value['total']));
        }
        foreach ($keluarSeminggu as $value) {
            $value = (array) $value;
            array_push($dataKeluarSeminggu, intval($value['total']));
        }
        // Parsing 4 week
        $label4Week = [];
        $dataMasuk4Week = [];
        $dataKeluar4Week = [];
        foreach ($masuk4Week as $value) {
            $value = (array) $value;
            array_push($label4Week, $value['start_date'] . " sd ". $value['end_date']);
            array_push($dataMasuk4Week, intval($value['total']));
        }
        foreach ($keluar4Week as $value) {
            $value = (array) $value;
            array_push($dataKeluar4Week, intval($value['total']));
        }
        // Parsing Data Setahun
        $labelSetahun = [];
        $dataMasukSetahun = [];
        $dataKeluarSetahun = [];
        foreach ($masukSetahun as $value) {
            $value = (array) $value;
            array_push($labelSetahun, $value['month_year']);
            array_push($dataMasukSetahun, intval($value['total']));
        }
        foreach ($keluarSetahun as $value) {
            $value = (array) $value;
            array_push($dataKeluarSetahun, intval($value['total']));
        }
            
        // Sisa uang
        $sisaUang = TMasuk::sum('nominal') - TKeluar::sum('nominal');

        return response()->json([
            'masukHari' => $masukHari,
            'keluarHari' => $keluarHari,
            'labelSeminggu' => $labelSeminggu,
            'dataMasukSeminggu' => $dataMasukSeminggu,
            'dataKeluarSeminggu' => $dataKeluarSeminggu,
            'keluarSeminggu' => $keluarSeminggu,
            'label4Week' => $label4Week,
            'dataMasuk4Week' => $dataMasuk4Week,
            'dataKeluar4Week' => $dataKeluar4Week,
            'labelSetahun' => $labelSetahun,
            'dataMasukSetahun' => $dataMasukSetahun,
            'dataKeluarSetahun' => $dataKeluarSetahun,
            'sisaUang' => $sisaUang,
        ]);
    }
}
