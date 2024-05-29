<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use App\Models\BannedIpAddress;
use Carbon\Carbon;

class ActivityLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        // Log request details
        $log = new ActivityLog();
        $log->method = $request->method();
        $log->url = $request->url();
        $log->ip = $request->ip();
        $log->save();

        // Check for suspicious activity
        $suspiciousRequests = ActivityLog::where('ip', $request->ip())
            ->where('created_at', '>=', Carbon::now()->subMinutes(5)) // Check requests within the last 5 minutes
            ->count();

        if ($suspiciousRequests > 20) {
            $blockedIp_exists = BannedIpAddress::where('ip_address', $request->ip())->exists();
            if ($blockedIp_exists == false) {
                // If more than 10 requests from the same IP within 5 minutes, block the IP
                $banExpiry = now()->addHours(4);
                // Update or create the banned IP address
                BannedIpAddress::updateOrCreate(
                    ['ip_address' => $request->ip()],
                    ['ban_expiry' => $banExpiry]

                );
            } else {

                // If the IP address is already blocked, check if the ban has expired
                $bannedIp = BannedIpAddress::where('ip_address', $request->ip())->first();
                if ($bannedIp && $bannedIp->ban_expiry < now()) {
                    // If the ban has expired, update the ban expiry time
                    $bannedIp->ban_expiry = now()->addHours(4);
                    $bannedIp->save();
                }

                // Take appropriate action, e.g., log this action for auditing purposes
                return redirect()->route('blocked_page')->withErrors(['credentials' => __('You have been blocked due to suspicious behavior. You can try again after 4 hours or contact technical support')]);
            }
        }

        // Check if the IP is banned
        $blockedIp = BannedIpAddress::where('ip_address', $request->ip())->first();
        if ($blockedIp && now()->lt($blockedIp->ban_expiry)) {
            // IP is banned; take appropriate action, e.g., log this action for auditing purposes
            return redirect()->route('blocked_page')->withErrors(['credentials' => __('You have been blocked due to suspicious behavior. You can try again after 4 hours or contact technical support')]);
        }

        // If the request is not suspicious, proceed normally
        return $next($request);
    }
}
