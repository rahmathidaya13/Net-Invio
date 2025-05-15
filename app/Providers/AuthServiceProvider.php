<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Barang\BarangModel;
use App\Models\BarangKeluar\BarangKeluarModel;
use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\Pelanggan\PelangganModel;
use App\Models\ReturBarang\ReturBarangModel;
use App\Models\StokBarang\StokBarangModel;
use App\Models\Supplier\SupplierModel;
use App\Models\User;
use App\Policies\BarangKeluarPolicy;
use App\Policies\BarangMasukPolicy;
use App\Policies\BarangPolicy;
use App\Policies\PelangganPolicy;
use App\Policies\ReturBarangPolicy;
use App\Policies\StokBarangPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BarangKeluarModel::class => BarangKeluarPolicy::class,
        BarangMasukModel::class => BarangMasukPolicy::class,
        // BarangModel::class => BarangPolicy::class,
        PelangganModel::class => PelangganPolicy::class,
        ReturBarangModel::class => ReturBarangPolicy::class,
        StokBarangModel::class => StokBarangPolicy::class,
        SupplierModel::class => SupplierPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate::define('add-and-edit', function (User $user) {
        //     return $user->can_add || $user->can_edit;
        // });
        Gate::define('view', fn(User $user) => $user->can_view);
        Gate::define('add', fn(User $user) => $user->can_add);
        Gate::define('edit', fn(User $user) => $user->can_edit);
        Gate::define('delete', fn(User $user) => $user->can_delete);
        Gate::define('onlyAdmin', fn(User $user) => $user->role === 'admin');
        Gate::define('onlyDevelop',  fn(User $user) => $user->role === 'develop');
    }
}
