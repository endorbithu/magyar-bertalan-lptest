<?php

namespace App\Services;

use App\Contracts\Services\LpSaveInstantInterface;
use App\Exceptions\StatusBarException;
use App\Models\Composer;
use App\Models\Label;
use App\Models\Lp;
use Illuminate\Http\Request;

class LpSaveInstantService implements LpSaveInstantInterface
{

    public function __construct(
        protected Request $request
    )
    {

    }

    public function save()
    {
        $label = Label::find($this->request->get('label_id'));
        if ($this->request->get('add_label')) {
            $label = new Label();
            $label->name = $this->request->get('add_label');
            $label->save();
        }
        if (!$label) throw new StatusBarException('No label provided');

        $composerIds = is_array($this->request->get('composer_id')) ? $this->request->get('composer_id') : [];
        $addComposers = $this->request->get('add_composer');
        if (is_array($addComposers) && count($addComposers)) {
            foreach ($addComposers as $composerName) {
                if (!$composerName) continue;

                $composer = new Composer();
                $composer->name = $composerName;
                $composer->save();
                $composerIds[] = $composer->id;
            }
        }

        if (empty($composerIds)) throw new StatusBarException('No composer provided');

        if (!$this->request->get('name')) throw new StatusBarException('No name provided');

        $lp = new Lp();
        $lp->name = $this->request->get('name');
        $lp->published_on = $this->request->get('published_on');

        $lp->label_id = $label->id;
        $lp->save();
        $lp->composers()->sync($composerIds);
        $lp->save();

    }

}
