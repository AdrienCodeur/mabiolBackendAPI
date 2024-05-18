<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckLeaseExpiration extends Command
{
    protected $signature = 'leases:check-expiration';

    protected $description = 'Check leases expiration and notify landlords and tenants';

    public function handle()
    {
        // $leases = Lease::where('end_date', '<=', Carbon::now()->addDays(7))
        //                 ->where('notified', false)
        //                 ->get();

        // foreach ($leases as $lease) {
        //     $lease->landlord->notify(new LeaseExpirationNotification($lease));
        //     $lease->tenant->notify(new LeaseExpirationNotification($lease));

        //     $lease->update(['notified' => true]);
        // }
    }


    // public function handle()
    // {
    //     $leases = Lease::where('end_date', '<=', Carbon::now()->addDays(7))
    //                     ->where('notified', false)
    //                     ->get();
    
    //     foreach ($leases as $lease) {
    //         $lease->landlord->notify(new LeaseExpirationNotification($lease));
    //         $lease->tenant->notify(new LeaseExpirationNotification($lease));
    
    //         // Émettre des événements sockets
    //         broadcast(new LeaseExpirationEvent($lease->landlord));
    //         broadcast(new LeaseExpirationEvent($lease->tenant));
    
    //         // Incrémenter les compteurs de notifications
    //         $lease->landlord->increment('notifications');
    //         $lease->tenant->increment('notifications');
    
    //         $lease->update(['notified' => true]);
    //     }
    // }
    
}