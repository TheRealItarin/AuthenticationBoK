<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRoleAbility
{
    /**
     * Handle an incoming request.
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $requiredRole  The required role(s) comma-separated (e.g., 'writer,reader')
     */
    public function handle(Request $request, Closure $next, $requiredRole = null): Response
    {
        if (!$request->user() || !$request->user()->currentAccessToken()) {
            return response()->json(['unauthorized' => 'No valid token'], 401);
        }

        $tokenAbilities = $request->user()->currentAccessToken()->abilities;
        
        if (is_string($tokenAbilities)) {
            $tokenAbilities = json_decode($tokenAbilities, true) ?? [];
        }
        if (!is_array($tokenAbilities)) {
            $tokenAbilities = [];
        }

        $requiredAbilities = array_map('trim', explode('|', $requiredRole ?? 'role:*'));
        
        $hasTokenAbility = false;
        foreach ($requiredAbilities as $ability) {
            if ($ability === 'role:*' || in_array($ability, $tokenAbilities)) {
                $hasTokenAbility = true;
                break;
            }
        }
        
        if (!$hasTokenAbility) {
            return response()->json(['forbidden' => 'Insufficient token permissions'], 403);
        }

        $user = $request->user()->fresh(); // Refresh from DB
        if (!$user) {
            return response()->json(['unauthorized' => 'User not found'], 401);
        }

        $tokenRole = null;
        foreach ($tokenAbilities as $ability) {
            if (str_starts_with($ability, 'role:')) {
                $tokenRole = str_replace('role:', '', $ability);
                break;
            }
        }

        if (!$tokenRole || $tokenRole !== $user->role) {
            return response()->json([
                'forbidden' => 'Your role has changed. Please re-authenticate.',
                'current_role' => $user->role
            ], 403);
        }

        return $next($request);
    }
}
