<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Auth;
use App\Models\WalletHistory;
use App\Models\User;

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
        //get wallet details
        $user = Auth::user()->id;
        $group = User::get();
        $walletData = Wallet::where('groupInt',$user)->first();
        $walletHistory = WalletHistory::Where('sendBy',$user)->orWhere('receiveBy',$user)->get();
//cari if the wallet owner ada send, or ada receive
        return view('home')->with([
            'walletData'    => $walletData,
            'walletHistory' => $walletHistory,
            'groups'        => $group
        ]);
    }

    //send money
    public function sendMoney(Request $request)
    {

        //check sender account & check receiver account

        $sender = Auth::user()->id;//sender id 1 
        $senderAmount = $request->sendAmount; // sender amount 100
        $senderAccount = Wallet::where('groupInt',$sender)->first();
        // $senderBalance = Wallet::where('group',$sender)->first(); //sender balance 800
        $totalMinus = $senderAccount->amount - $senderAmount;
        
        $receiver = $request->receiverId; //2
        $sendToReceiver = Wallet::where('groupInt',$receiver)->first(); //receiver account
        // $receiverWalletAmount = $sendToReceiver->amount; //receiver balacnce 800
        $totalSend = $sendToReceiver->amount + $senderAmount; //100 + 800

        if($senderAccount->amount != 0){
        
                $sendToReceiver->amount = $totalSend; //900
                
                $sendToReceiver->save();
                $senderAccount->amount = $totalMinus;
                $senderAccount->save();
                
                $walletHistory = new WalletHistory();
                $walletHistory->amount = $senderAmount;
                $walletHistory->groupInt = $sender;
                $walletHistory->sendBy  = $sender;
                $walletHistory->receiveBy   = $receiver;
                $walletHistory->save();
        }

        return redirect('/home')->with('status', 'You send RM '.$senderAmount. ' to Group '. $receiver  );
    }
}
