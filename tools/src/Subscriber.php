<?php


namespace Demency\Tools;


use App\User;
use Illuminate\Support\Str;

class Subscriber
{
    /**
     * Determine user tier.
     *
     * @param User $user
     * @return string
     */
    public function determineTier(User $user)
    {
        if ($user->free) {
            return 'free';
        } else {
            return 'premium';
        }
    }

    /**
     * Find current user resource used quota.
     *
     * @param $resource
     * @param $user
     * @return mixed
     */
    public function getUserResourcesQuota($resource, $user)
    {
        return resolve('App\\' . Str::camel(Str::singular($resource)))->where('user_uuid', $user->uuid)->count();
    }

    /**
     * Check if user can apply method on resources.
     *
     * @param $method
     * @param $resource
     * @param User $user
     * @return bool
     */
    public function can($method, $resource, User $user)
    {
        $tier = $this->determineTier($user);
        $quantity = $this->getUserResourcesQuota($resource, $user);
        return ($quantity + 1) <= $this->getOptions($tier, $resource, $method);
    }

    /**
     * Get premium quota limits.
     *
     * @param $resource
     * @param $method
     * @return mixed
     */
    public function getPremiumLimits($resource, $method)
    {
        return $this->calcLimits(config('limits.premium'), $resource, $method);
    }

    /**
     * Get free quota limits.
     *
     * @param $resource
     * @param $method
     * @return mixed
     */
    public function getFreeLimits($resource, $method)
    {
        return $this->calcLimits(config('limits.free'), $resource, $method);
    }

    /**
     * Calculate specific resource tier limits.
     *
     * @param $limits
     * @param $resource
     * @param $method
     * @return mixed
     */
    public function calcLimits($limits, $resource, $method)
    {
        return $limits[$resource][$method];
    }

    /**
     * Get current user tier limits options.
     *
     * @param $tier
     * @param $resource
     * @param $method
     * @return mixed
     */
    public function getOptions($tier, $resource, $method)
    {
        if ($tier === 'free') {
            return $this->getFreeLimits($resource, $method);
        }
        return $this->getPremiumLimits($resource, $method);
    }
}
