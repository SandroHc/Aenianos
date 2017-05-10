<?php

namespace App\Providers;

use App\Comment;
use App\Department;
use App\Policies\CommentPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\PrinterPolicy;
use App\Policies\RequestPolicy;
use App\Policies\UserPolicy;
use App\Printer;
use App\Request;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Request::class => RequestPolicy::class,
        Comment::class => CommentPolicy::class,
        Printer::class => PrinterPolicy::class,
        Department::class => DepartmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin.dashboard', function ($user) {
            return $user->admin;
        });
    }
}
