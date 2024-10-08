<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        // Currency Format
        Blade::directive('currency', function ( $expression ) {
            if(is_numeric($expression)){
                if($expression >= 0){
                    return "Rp<?php echo number_format($expression,0,',','.'); ?>"; 
                }else{
                    $dana = -($expression);
                    return "-Rp<?php echo number_format($dana,0,',','.'); ?>"; 
                }
            }else{
                return "Rp<?php echo number_format($expression,0,',','.'); ?>"; 
            }            
        });

        //Set Date and Time Zone
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // Tambahan - Pagination Default Laravel
        Paginator::useBootstrapFive();  

        // Tambahan - Gate
        Gate::define('pimpinan', function(User $user){
            return $user->level === 'pimpinan';
        });
    }
}
