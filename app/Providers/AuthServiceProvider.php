<?php

namespace App\Providers;

use App\Models;
use App\Policies;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Project::class => Policies\ProjectPolicy::class,
        Models\Flow\Matcher::class => Policies\MatcherPolicy::class,
        Models\Flow::class => Policies\FlowPolicy::class,
        Models\Respond::class => Policies\RespondPolicy::class,
        Models\Recipient::class => Policies\RecipientPolicy::class,
        Models\Recipient\Variable::class => Policies\RecipientVariablePolicy::class,
        Models\Respond\Taxonomy::class => Policies\TaxonomyPolicy::class,
        Models\Mass\Message::class => Policies\MessagePolicy::class,
        Models\Subscription\Channel::class => Policies\SubscriptionChannelPolicy::class,
        Models\Subscription\Channel\Broadcast::class => Policies\ChannelBroadcastPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // Allow all with master permission
        $gate->before(function ($user) {
            if ($user->permissions()->lists('permission')->search('master') !== false) {
                return true;
            }
        });

        // Check for user permission
        $gate->define('permission', function ($user, $permission) {
            return $user->permissions()->lists('permission')->search($permission) !== false;
        });
    }
}
