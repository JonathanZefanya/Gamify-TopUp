<?php

namespace App\Http\Middleware;

use App\Models\Kyc as KYCModel;
use App\Models\UserKyc;
use App\Traits\ApiValidation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class apiKYC
{
    use ApiValidation;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $kycTypes = KYCModel::where('status', 1)->pluck('id');
        if (count($kycTypes) > 0) {
            $userKyc = UserKyc::where('user_id', Auth::user()->id)->whereIn('kyc_id', $kycTypes)->get();
            $userKycIds = $userKyc->pluck('kyc_id')->toArray();
            $missingKycTypes = array_diff($kycTypes->toArray(), $userKycIds);

            if (!empty($missingKycTypes)) {
                return response()->json($this->withErrors('Please submit KYC information to access all the resource'));
            }
            $statuses = $userKyc->pluck('status');
            if (!in_array(1, $statuses->toArray())) {
                return response()->json($this->withErrors('Please submit KYC information to access all the resource'));
            }
        }
        return $next($request);
    }
}
