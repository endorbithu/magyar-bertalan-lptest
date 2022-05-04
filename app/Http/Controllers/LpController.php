<?php

namespace App\Http\Controllers;

use App\Contracts\Services\Select2ServiceInterface;
use App\Models\Composer;
use App\Models\Label;
use App\Models\LpFlat;
use App\Services\LpSaveInstantService;
use App\Services\Select2Service;
use Illuminate\Http\Request;

class LpController extends Controller
{
    public function lps(Request $request)
    {
        $lps = LpFlat::orderBy('name')->get();
        return view('lps', ['lps' => $lps]);
    }

    public function lpPost(Request $request)
    {
        app(LpSaveInstantService::class, [$request])->save();

        return back()->with(['success' => 'LP has been added successfully!']);
    }

    public function labelApi(Request $request)
    {

        return app(Select2ServiceInterface::class)->getResultsForApi(Label::class, (string)$request->q);
    }

    public function composerApi(Request $request)
    {
        return app(Select2ServiceInterface::class)->getResultsForApi(Composer::class, (string)$request->q);
    }
}
