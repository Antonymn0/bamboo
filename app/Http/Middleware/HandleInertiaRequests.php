<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = $request->user();
        $company = $user ? $user->company : null;
        $logo = $company ? $company->media()->where('purpose','logo')->first() : null;
        $avatar = $user ? $user->media()->where('purpose','avatar')->orderBy('created_at','DESC')->first() : null;

        return array_merge(parent::share($request), [
            'auth' => [
                'avatar' => $avatar,
                'user' => $user,
                'company' => $company,
                'logo' => $logo
            ],
        ]);
    }
}
