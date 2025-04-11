<?php

namespace App\Http\Controllers\Admin;
use App\Models\SellerApplication;
use App\Http\Controllers\Controller;
use App\Notifications\SellerStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SellerModerationController extends Controller
{
    public function index()
    {
        $applications = SellerApplication::with('user')
            ->where('status', 0)
            ->get();
            
        return view('admin.seller-moderation', compact('applications'));
    }
    
    public function approve($id)
{
    $application = SellerApplication::findOrFail($id);
    
    DB::transaction(function () use ($application) {
        $application->update(['status' => 1]);
        $application->user->update(['seller' => 1]);
        $application->user->notify(new SellerStatusNotification(1));
    });
    
    return back()->with('success', 'Заявка одобрена');
}

public function reject($id)
{
    $application = SellerApplication::findOrFail($id);
    $application->update(['status' => 2]);
    $application->user->notify(new SellerStatusNotification(2));
    
    return back()->with('success', 'Заявка отклонена');
}
    
}
