<?php

namespace App\Observers;

use App\Models\Lp;
use App\Models\LpFlat;

class LpObserver
{
    /**
     * Handle the Lp "created" event.
     *
     * @param \App\Models\Lp $lp
     * @return void
     */
    public function saved(Lp $lp)
    {
        $lpFlat = LpFlat::find($lp->id) ?? (new LpFlat());
        $lpFlat->id = $lp->id;
        $lpFlat->name = $lp->name;
        $lpFlat->label = $lp->label()->first()->name;
        $lpFlat->composers = $lp->composers()->get()->pluck('name')->implode(', ');

        $lpFlat->save();
    }

    /**
     * Handle the Lp "updated" event.
     *
     * @param \App\Models\Lp $lp
     * @return void
     */
    public function deleted(Lp $lp)
    {
        if ($lpFlat = LpFlat::find($lp->id)) {
            $lpFlat->delete();
        }

    }

}
