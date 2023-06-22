<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Auth;
use App\Models\WalletHistory;
use App\Models\User;
use App\Models\PromoCode;
use App\Models\PromoHistory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    

    

    public function index()
    {
        //role 2 account holder
        $user = Auth::user()->groupInt;
        $group = User::where('groupInt','!=',$user)->orderBy('groupInt','asc')->get();
        $walletData = Wallet::where('groupInt',$user)->first();
        
        $walletHistory = WalletHistory::where('sendBy',$user)->orWhere('receiveBy',$user)->orderby('updated_at','desc')->paginate(50);
        $adminHistory = WalletHistory::orderby('updated_at','desc')->get();
        //cari if the wallet owner ada send, or ada receive

        //admin view
        $data = Wallet::where('groupInt','!=',0)->orderby('amount','desc')->get();
        $transactionCount = WalletHistory::where('groupInt','!=',0)->count();
        
        return view('home')->with([
            'walletData'        => $walletData,
            'walletHistory'     => $walletHistory,
            'groups'            => $group,
            'datas'             => $data,
            'adminHistorys'     => $adminHistory,
            'transactionCounts' => $transactionCount
        ]);
    }

    //send money
    public function sendMoney(Request $request)
{
    $sender = Auth::user()->groupInt;
    $senderAmount = $request->sendAmount;
    $senderWallet = Wallet::where('groupInt', $sender)->firstOrFail();
    $receiver = $request->receiverId;
    $receiverWallet = Wallet::where('groupInt', $receiver)->firstOrFail();

    if ($sender == $receiver) {
        return redirect('/home')->with('error', 'You cannot send to your own account.');
    }

    if ($senderWallet->amount < $senderAmount) {
        return redirect('/home')->with('error', 'You do not have enough RM to transfer! Please top-up.');
    }
    $str = rand();
    $senderWallet->decrement('amount', $senderAmount);
    $receiverWallet->increment('amount', $senderAmount);

    $walletHistory = new WalletHistory();
    $walletHistory->amount = $senderAmount;
    $walletHistory->groupInt = $sender;
    $walletHistory->sendBy = $sender;
    $walletHistory->receiveBy = $receiver;
    $walletHistory->transId = substr(base_convert(md5($str), 16,32), 0, 12);
    $walletHistory->remarks = 'Transaction';
    $walletHistory->save();

    return redirect('/home')->with('status', 'You send RM ' . $senderAmount . ' to Group ' . $receiver);
}
        
    //promo code for admin
    public function addPromoCode(Request $request){

        $permission = Auth::user()->role;

        if($permission == 1){

            $promoCode = new PromoCode();
            $promoCode->promoCodeNm     = $request->promoCodeNm;
            $promoCode->promoRedeem     = $request->promoRedeem;
            $promoCode->promoValue      = $request->promoValue;
            $promoCode->save();

            return redirect('/promoCode')->with('status', 'You created a Promo Code of '.$request->promoCodeNm. ' with '. $request->promoRedeem. ' redemptions.'  );
        }
    }

    public function getPromoCode(){

        $promoCode = PromoCode::get();

        return view('promoCode')->with([
            'promoCodes'    => $promoCode
        ]);
    }

    public function redeemCode(Request $request){
        $checkPromo = null;

        $group = Auth::user()->groupInt;
        $checkPromo = PromoCode::where('promoCodeNm',$request->redeemCode)->first();
        if($checkPromo)
        $checkRedeem = PromoHistory::where('userID',$group)->where('promoID',$checkPromo->id)->first();

         $str = rand();
         $transId = substr(base_convert(md5($str), 16,32), 0, 12);

    if($checkPromo){
        if($checkPromo->promoRedeem != 0 && $checkRedeem == null){

            $addToWallet = Wallet::where('groupInt',$group)->first();
            $wallet = $addToWallet->amount + $checkPromo->promoValue;

            if($addToWallet){

                $checkPromo->PromoRedeem = $checkPromo->promoRedeem - 1;
                $checkPromo->save();
                $addToWallet->amount = $wallet;
                $addToWallet->save();

                $walletHistory = new WalletHistory();
                $walletHistory->amount      = $checkPromo->promoValue;
                $walletHistory->groupInt    = 0;
                $walletHistory->sendBy      = 0;
                $walletHistory->receiveBy   = $group;
                $walletHistory->transId     = $transId;
                $walletHistory->remarks     = 'Promo redeemed';
                $walletHistory->save();

                $promoHistory = new PromoHistory();
                $promoHistory->userID = $group;
                $promoHistory->promoID = $checkPromo->id;
                $promoHistory->save();

            }   
        }
        else{
            if($checkPromo->redeem == 0)
            return redirect('/home')->with('error', 'The Promo Code is fully redeem. Please try again!');
            else return redirect('/home')->with('error', 'You redeemed the code. Please try again!');
        }
        return redirect('/home')->with('status', 'You redeem RM '.$checkPromo->promoValue);
    }
    return redirect('/home')->with('error', 'The Promo Code do not exist, maybe exist in another Multiverse!');
}
    
    //promo boleh redeem sekali je

    public function deductMoney(Request $request){
        
        //group id
        $deductGroup = $request->deductGroup;
        //amount
        $deductAmount = $request->deductAmount;

        $str = rand();
        $transId = substr(base_convert(md5($str), 16,32), 0, 12);
        //update wallet account
        $getDeductWallet = Wallet::where('groupInt', $deductGroup)->firstOrFail(); //33123
        $getDeductWallet->amount = ($getDeductWallet->amount) - $deductAmount;
        $getDeductWallet->save();
        //admin wallet
        $adminWallet = Wallet::where('groupInt',0)->firstOrFail();
        $adminWallet->amount = $adminWallet->amount + $deductAmount;
        $adminWallet->save();
        //update wallet history transaction id 
        $walletHistory = new WalletHistory();
        $walletHistory->amount = $deductAmount;
        $walletHistory->groupInt = $deductGroup;
        $walletHistory->sendBy = $deductGroup;
        $walletHistory->receiveBy = 0; //update  deduct by admin
        $walletHistory->transId = $transId;
        $walletHistory->remarks = 'Denda';
        $walletHistory->save();

        return redirect('/home')->with('status', 'You deduct RM ' . $deductAmount . ' from ' . $deductGroup);
        
    }
    
}
