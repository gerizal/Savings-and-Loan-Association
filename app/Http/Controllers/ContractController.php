<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Application;
use App\Models\BranchUnit;
use App\Models\Referral;
use App\Models\ServiceUnit;
use App\Models\User;
use App\Models\Bank;
use App\Models\Verification;
use App\Models\Approval;
use App\Models\District;
use App\Models\Document;
use App\Models\SubDistrict;
use App\Models\City;
use App\Models\FamilyMember;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printContract(Request $request, $id)
    {
        $validated = validator($request->all(), [
            'contract_date'=>'required',
            'contract_number'=>'required',
            'interest'=>'required',
            'interest_type'=>'required'
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(), 400);
        }else{
            try {
                $contract = Contract::fromRequest($request, $id);
                if($contract){
                    return Contract::generateContract($id);
                }
                return response()->json(['message'=>'contract not found','status'=>'failed'], 400);
            } catch (\Exceptions $e) {
                return response()->json($e->all(),400);
            }
        }

    }
}
