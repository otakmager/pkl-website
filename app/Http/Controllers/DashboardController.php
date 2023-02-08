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
        // Transaksi Hari Ini
        $masukHari = (int) TMasuk::whereDate('tanggal', '=', date('Y-m-d'))->sum('nominal');
        $keluarHari = (int) TKeluar::whereDate('tanggal', '=', date('Y-m-d'))->sum('nominal');

        // Transaksi Seminngu
        $masukSeminggu = DB::table(DB::raw("(WITH Recursive days AS ( SELECT DATE_SUB(NOW(), INTERVAL 7 DAY) AS day_date UNION SELECT DATE_ADD(day_date, INTERVAL 1 DAY) FROM days WHERE day_date < NOW() ) SELECT DATE_FORMAT(day_date, '%W, %d %M %Y') AS hari_tanggal, COALESCE(SUM(t_masuks.nominal), 0) AS total FROM days LEFT JOIN t_masuks ON DATE(day_date) = t_masuks.tanggal GROUP BY day_date, DATE(day_date) ORDER BY DATE(day_date)) as sub"))
                        ->get();
        $keluarSeminggu = DB::table(DB::raw("(WITH Recursive days AS ( SELECT DATE_SUB(NOW(), INTERVAL 7 DAY) AS day_date UNION SELECT DATE_ADD(day_date, INTERVAL 1 DAY) FROM days WHERE day_date < NOW() ) SELECT DATE_FORMAT(day_date, '%W, %d %M %Y') AS hari_tanggal, COALESCE(SUM(t_keluars.nominal), 0) AS total FROM days LEFT JOIN t_keluars ON DATE(day_date) = t_keluars.tanggal GROUP BY day_date, DATE(day_date) ORDER BY DATE(day_date)) as sub"))
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
        

        return response()->json([
            'masukHari' => $masukHari,
            'keluarHari' => $keluarHari,
            'masukSeminggu' => $masukSeminggu,
            'keluarSeminggu' => $keluarSeminggu,
            'masukSetahun' => $masukSetahun,
            'keluarSetahun' => $keluarSetahun,
        ]);
    }
}
