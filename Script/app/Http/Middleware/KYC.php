<?php

namespace App\Http\Middleware;

use App\Models\Kyc as KYCModel;
use App\Models\UserKyc;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KYC
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $kycTypes = KYCModel::where('status', 1)->pluck('id');
        if(count($kycTypes) > 0){
            $userKyc = UserKyc::where('user_id', Auth::user()->id)->whereIn('kyc_id', $kycTypes)->get();
            $userKycIds = $userKyc->pluck('kyc_id')->toArray();
            $missingKycTypes = array_diff($kycTypes->toArray(), $userKycIds);

            if (!empty($missingKycTypes)) {
                return redirect()->route('user.kyc.settings')->with('error', 'Please submit KYC information to access all the resource');
            }
            $statuses = $userKyc->pluck('status');
            if (!in_array(1, $statuses->toArray())) {
                return redirect()->route('user.kyc.settings')->with('error', 'Your KYC is not approved yet');
            }
        }
        return $next($request);
    }



}
