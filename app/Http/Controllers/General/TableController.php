<?php

namespace App\Http\Controllers\General;

use App\Models\User;
use App\Models\Agent;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\BlockNumber;
use App\Models\LuckyNumber;
use App\Models\DefineAmount;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BannerSupport;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
    public function agents(Request $request){
        $data = Agent::latest()->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            if($row['is_suspend'] == 0){
                $actionBtn = '<button id="'. $row['id'] .'" class="cashout-detail btn btn-warning user-btn-edit ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="cashout"><i class="fa-solid fa-money-check-dollar"></i></button><button id="'. $row['id'] .'" data-amt="'. $row['amount'] .'" class="cashout-agent btn btn-warning user-btn-edit ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="cashout"><i class="fa-solid fa-circle-dollar-to-slot"></i></button><button id="'. $row['id'] .'" class="ban_agent btn btn-danger user-btn-edit ml mt-2" data-suspend="'. $row['is_suspend'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate"><i class="fa-solid fa-ban"></i></button><button id="'. $row['id'] .'" class="delete_agent btn btn-danger user-btn-danger ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-user-slash"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-agent mt-2" data-name="'. $row['name'] .'" data-percent="'. $row['percentage'] .'" data-msisdn="'. $row['msisdn'] .'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            } else {
                $actionBtn = '<button id="'. $row['id'] .'" class="cashout-detail btn btn-warning user-btn-edit ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="cashout detail"><i class="fa-solid fa-money-check-dollar"></i></button><button id="'. $row['id'] .'" data-amt="'. $row['amount'] .'" class="cashout-agent btn btn-warning user-btn-edit ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="cashout"><i class="fa-solid fa-circle-dollar-to-slot"></i></button><button id="'. $row['id'] .'" class="ban_agent btn btn-success user-btn-edit ml mt-2" data-suspend="'. $row['is_suspend'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Activate"><i class="fa-solid fa-person-walking-arrow-loop-left"></i></button><button id="'. $row['id'] .'" class="delete_agent btn btn-danger user-btn-danger ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-user-slash"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-agent mt-2" data-name="'. $row['name'] .'" data-percent="'. $row['percentage'] .'" data-msisdn="'. $row['msisdn'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            }
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function customers(Request $request){
        $data = User::where('role','user')->latest()->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            if($row['is_suspend'] == 0){
                $actionBtn = '<button id="'. $row['id'] .'" data-amt="'. $row['amount'] .'" class="cash-agent btn btn-warning user-btn-edit ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="cashout"><i class="fa-solid fa-circle-dollar-to-slot"></i></button><button id="'. $row['id'] .'" class="ban_user btn btn-danger user-btn-edit ml mt-2" data-suspend="'. $row['is_suspend'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate"><i class="fa-solid fa-ban"></i></button><button id="'. $row['id'] .'" class="delete_user btn btn-danger user-btn-danger ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-user-slash"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-customer mt-2"  data-bs-toggle="tooltip" data-name="'. $row['name'] .'" data-msisdn="'. $row['msisdn'] .'" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            } else {
                $actionBtn = '<button id="'. $row['id'] .'" data-amt="'. $row['amount'] .'" class="cash-agent btn btn-warning user-btn-edit ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="cashout"><i class="fa-solid fa-circle-dollar-to-slot"></i></button><button id="'. $row['id'] .'" class="ban_user btn btn-success user-btn-edit ml mt-2" data-suspend="'. $row['is_suspend'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Activate"><i class="fa-solid fa-person-walking-arrow-loop-left"></i></button><button id="'. $row['id'] .'" class="delete_user btn btn-danger user-btn-danger ml mt-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-user-slash"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-customer mt-2" data-name="'. $row['name'] .'" data-msisdn="'. $row['msisdn'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            }
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function lucky_numbers(Request $request){
        $date = $request->query('date');
        $data = LuckyNumber::where('date',$date)->orderBy('created_at', 'ASC')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function cash(Request $request){
        $res = [];
        if($request->query('cash') == 'in'){
          $data = CashIn::orderBy('created_at', 'DESC')->get();  
          foreach($data as $datum){
                $payment = Payment::where('id', $datum->payment_id)->first();
                array_push($res, [
                    "id" => $datum->id,
                    "payment" => $payment->name,
                    "type" => $payment->type,
                    "credential" => $datum->credential,
                    "transaction_id" => $datum->transaction_id,
                    "amount" => $datum->amount,
                    "old_amount" => $datum->old_amount,
                    "new_amount" => $datum->new_amount,
                    "name" => $datum->name,
                    "date" => $datum->date,
                    "approve" => $datum->approve,
                    "request" => 'in'
                ]);
            }
        } else {
            $data = CashOut::orderBy('created_at', 'DESC')->get();
	    //return $data;
            foreach($data as $datum){
                $payment = Payment::where('id', $datum->payment_id)->first();
                array_push($res, [
                    "id" => $datum->id,
                    "payment" => $payment->name,
                    "type" => $payment->type,
                    "credential" => $datum->credential,
                    "amount" => $datum->amount,
                    "old_amount" => $datum->old_amount,
                    "new_amount" => $datum->new_amount,
                    "name" => $datum->name,
                    "date" => $datum->date,
                    "approve" => $datum->approve,
                    "request" => 'out'
                ]);
            }
        }
       
        return DataTables::of($res)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            // if($row['approve'] == 0){
            //     $actionBtn = '<span class="badge bg-danger">Rejected</span>';
            // } else if($row['approve'] == 1){
            //     $actionBtn = '<span class="badge bg-success">Approved</span>';
            // }
            $actionBtn = '<div class="col-md-12"><button id="'. $row['id'] .'" style="margin-left: 5px !important;" class="approve-'. $row['request'] .' btn btn-info user-btn-edit mt-1 mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve"><i class="fa-solid fa-person-circle-check"></i></button><button id="'. $row['id'] .'" style="margin-left: 5px !important;" class="reject-'. $row['request'] .' btn btn-danger user-btn-edit mt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject"><i class="fa-brands fa-creative-commons-nc"></i></button></div>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function notification(Request $request){
        $data = Notification::latest()->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row->id .'" class="btn btn-secondary user-btn-edit ml blast" data-bs-toggle="tooltip" data-bs-placement="top" title="Resend"><i class="fa-solid fa-recycle"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function block_numbers(Request $request){
        $data = BlockNumber::orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" class="delete_block btn btn-danger user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-block"  data-bs-toggle="tooltip" data-bs-placement="top"  data-number="'. $row['number'] .'" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function banners(Request $request){
        $data = BannerSupport::where('type', 'banner')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" class="delete_banner btn btn-danger user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-banner" data-img="'. $row['img'] .'"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function supports(Request $request){
        $data = BannerSupport::orderBy('created_at', 'DESC')->where('type', 'support')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" class="delete_support btn btn-danger user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-support"  data-bs-toggle="tooltip" data-bs-placement="top"  data-body="'. $row['body'] .'" data-name="'. $row['name'] .'" data-img="'. $row['img'] .'" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function marques(Request $request){
        $data = BannerSupport::orderBy('created_at', 'DESC')->where('type', 'marque')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" class="delete_marque btn btn-danger user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-marque"  data-bs-toggle="tooltip" data-bs-placement="top"  data-body="'. $row['body'] .'" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function payment(Request $request){
        $data = Payment::latest()->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" class="delete_payment btn btn-danger user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button><button id="'. $row['id'] .'" class="btn btn-info user-btn-edit ml edit-payment" data-name="'. $row['name'] .'" data-percent="'. $row['percent'] .'" data-holder="'. $row['holder'] .'" data-type="'. $row['type'] .'"  data-account="'. $row['account_number'] .'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function hots(Request $request){
        $date = date('Y-m-d');
        $section = date('h:i A', strtotime($request->query('section')));
        $data = DefineAmount::where('date', $date)->where('section', $section)
        ->select('section', 'date', 'hot_amount')
        ->selectRaw("GROUP_CONCAT(number) as numbers")
        ->groupBy(['section','date','hot_amount'])
        ->get();
       
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<button data-number="'. $row['numbers'] .'" data-section="'. $row['section'] .'"  class="delete_hot btn btn-danger user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function blocksdash(Request $request){
        $date = date('Y-m-d');
        $section = date('h:i A', strtotime($request->query('section')));
        $data = BlockNumber::where('date', $date)->where('section', $section)
        ->select('section', 'date')
        ->selectRaw("GROUP_CONCAT(number) as numbers")
        ->groupBy(['section','date'])
        ->get();
               
        return DataTables::of($data)
        ->make(true);
    }
}
