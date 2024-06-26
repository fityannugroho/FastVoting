<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class IsEventEditable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $event = $request->event
            ?? optional($request->option)->event
            ?? optional($request->voter)->event;

        // Ensure if the event is not committed yet.
        if ($event->is_committed) {
            return redirect()->route('events.show', ['event' => $event])->with('error', 'This event has been committed and can\'t be edited anymore.');
        }

        return $next($request);
    }
}
