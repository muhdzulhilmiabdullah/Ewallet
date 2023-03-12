<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Auth;
use App\Models\WalletHistory;
use App\Models\User;
use App\Models\PromoCode;

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
     */
    public function index()
    {
        //role 2 account holder
        $user = Auth::user()->groupInt;
        $group = User::get();
        $walletData = Wallet::where('groupInt',$user)->first();
        
        $walletHistory = WalletHistory::where('sendBy',$user)->orWhere('receiveBy',$user)->orderby('updated_at','desc')->get();
        //cari if the wallet owner ada send, or ada receive

        //admin view
        $data = Wallet::where('groupInt','!=',0)->get();
        
        return view('home')->with([
            'walletData'    => $walletData,
            'walletHistory' => $walletHistory,
            'groups'        => $group,
            'datas'         => $data
        ]);
    }

    //send money
    public function sendMoney(Request $request)
    {

        //check sender account & check receiver account
        $totalMinus = 0;
        $totalSend = 0;
        $sender = Auth::user()->groupInt;//sender id 1 
        $senderAmount = $request->sendAmount; // sender amount 100
        $senderAccount = Wallet::where('groupInt',$sender)->first();
        // $senderBalance = Wallet::where('group',$sender)->first(); //sender balance 800
        $totalMinus = $senderAccount->amount - $senderAmount; //duit account - duit nak hantar
        
        $receiver = $request->receiverId; //2
        $sendToReceiver = Wallet::where('groupInt',$receiver)->first(); //receiver account
        // $receiverWalletAmount = $sendToReceiver->amount; //receiver balacnce 800
        $totalSend = $sendToReceiver->amount + $senderAmount;//100 + 800
        
        //transid
        $str = rand();
        $transId = substr(base_convert(md5($str), 16,32), 0, 12);
    if($sender != $receiver){

        if($totalMinus > 0){ //kalau duit orang tu 0, jadi dia tak dapat hantar
        
                $sendToReceiver->amount = $totalSend; //900
                $sendToReceiver->save();
                $senderAccount->amount = $totalMinus;
                $senderAccount->save();
                
                $walletHistory = new WalletHistory();
                $walletHistory->amount      = $senderAmount;
                $walletHistory->groupInt    = $sender;
                $walletHistory->sendBy      = $sender;
                $walletHistory->receiveBy   = $receiver;
                $walletHistory->transId     = $transId;
                $walletHistory->save();

                return redirect('/home')->with('status', 'You send RM '.$senderAmount. ' to Group '. $receiver  );
        }
        else{
                return redirect('/home')->with('error', 'You do not have enough RM to transfer! Please top-up');
        }
    }

        return redirect('/home')->with('error', 'You cannot send to your own account lah!');
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

        $checkPromo = PromoCode::where('promoCodeNm',$request->redeemCode)->first();
        $group = Auth::user()->groupInt;

         //transid
         $str = rand();
         $transId = substr(base_convert(md5($str), 16,32), 0, 12);

    if($checkPromo){
        if($checkPromo->promoRedeem != 0){

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
                $walletHistory->save();
            }   
        }
        else{
            return redirect('/home')->with('error', 'The Promo Code is fully redeemed. Please try again!');
        }
        return redirect('/home')->with('status', 'You redeem RM '.$checkPromo->promoValue);
    }
    return redirect('/home')->with('error', 'The Promo Code do not exist, maybe exist in another Multiverse!');
}
    
    //promo boleh redeem sekali je
    
}
