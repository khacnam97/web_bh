<?php


namespace App\services;


use App\Models\Script;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScriptService
{
    /**
     * @param $records
     * @return array
     */
    public function dataArr($records): array
    {
        $dataArr = [];
        foreach($records as $record){
            $titleText = $record->isActive ? __('common.Disable') : __('common.Active');
            $classButton = $record->isActive ? 'btn-secondary' : 'btn-success';
            $button ='<button type="button" title="'.$titleText.'" name="active" class="btn '.$classButton.' btn-sm active-script" data-active="' . $record->isActive . '" data-id="' . $record->id . '">'.$titleText.'</button>';
            $button .= '<a href="' . route('script.getEdit', $record->id) . '" class="btn btn-primary btn-sm ml-2 mr-2">'.__('common.Edit').'</a>';
            $button .='<button type="button" name="delete" data-id="' . $record->id . '" class="delete btn btn-danger btn-sm">'.__('common.Delete').'</button>';
            $dataArr[] = [
                'id' => $record->id,
                'name' => $record->name,
                'description' => nl2br($record->description),
                'fileName' => $record->fileName,
                'isActive'    =>$record->isActive ? __('script.execFile') : __('script.supportFile'),
                'action'   => $button
            ];
        }

        return $dataArr;
    }

    /**
     * @return array
     */
    public function getFirstPage(): array
    {
        $records = Script::orderBy('name')->paginate(10);
        return [
            'scripts' =>  $this->dataArr($records),
            'totalItem' => $records->total()
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getScripts(Request $request): array
    {
        $draw = $request->get('draw');
        $start = $request->get("start"); // starting page
        $rowPerPage = $request->get("length"); // rows display per page

        $columnIndex = $request->get('order')[0]['column']; // index of column used for order
        $columnName = $request->get('columns')[$columnIndex]['data']; // name of column used for order
        $sortOrder = $request->get('order')[0]['dir']; // asc or desc

        // get total records with and without filter
        $totalRecords = Script::select('count(*) as allCount')->count();

        $records = Script::orderBy($columnName, $sortOrder)->skip($start)
            ->take($rowPerPage)
            ->get();
        return [
            "draw" => intval($draw), // cast to int to prevent XSS attack, according to jquery table document
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $this->dataArr($records)
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findScript($id) {
        return Script::findOrFail($id);
    }

    /**
     * @param $request
     * @return bool
     */
    public function store($request): bool
    {
        $script = new Script($request->all());
        $scriptNumber = Script::max('orderNumber');
        if ($request->isActive) {
            $script->orderNumber = $scriptNumber + 1;
        }
        $fileName = $request->file('fileName')->getClientOriginalName();
        $file = \File::get($request->file('fileName'));
        Storage::disk('local')->put('scripts/python_code/' . $fileName, $file);
        $script->fileName = $fileName;
        return $script->save();
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function update($request, $id): bool
    {
        $script = $this->findScript($id);
        if ($request->isActive) {
            $scriptNumber = Script::max('orderNumber');
            if(!$script->isActive) {
                $script->orderNumber = $scriptNumber + 1;
            }
        }
        else {
            if($script->isActive) {
                Script::where('orderNumber', '>', $script->orderNumber)->update(['orderNumber' => \DB::raw('orderNumber - 1')]);
            }
            $script->orderNumber = 0;
        }
        if (\File::exists($request->fileName)) {
            $fileName = $request->file('fileName')->getClientOriginalName();
            $file = \File::get($request->file('fileName'));
            //check file exists
            $exists = Storage::disk('local')->exists('scripts/python_code/' . $script->fileName);
            $existsPush = Storage::disk('local')->exists('scripts/python_code/' . $fileName);
            if ($script->fileName !== $fileName && $exists && !$existsPush) {
                Storage::disk('local')->rename('scripts/python_code/' . $script->fileName, 'scripts/python_code/' . $fileName);
            }
            Storage::disk('local')->put('scripts/python_code/' . $fileName, $file);
            $script->fileName = $fileName;
        }
        $script->description = $request->description;
        $script->name = $request->name;
        $script->isActive = $request->isActive;
        return $script->save();
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $script = $this->findScript($id);
        Storage::disk('local')->delete('scripts/python_code/' . $script->fileName);
        return $script->delete();
    }

    /**
     * @param $id
     * @return bool
     */
    public function active($id): bool
    {
        $script = $this->findScript($id);
        if ($script->isActive) {
            Script::where('orderNumber', '>', $script->orderNumber)->update(['orderNumber' => \DB::raw('orderNumber - 1')]);
            $script->orderNumber = 0;
        }
        else {
            $scriptNumber = Script::max('orderNumber');
            $script->orderNumber = $scriptNumber + 1;
        }
        $script->isActive = $script->isActive ? 0 : 1;
        return $script->save();
    }

    /**
     * @return Builder[]|Collection
     */
    public function listActive() {
        return Script::where('isActive', 1)->orderBy('orderNumber')->get();
    }

    /**
     * @param $request
     * @return bool
     */
    public function sort($request)
    {
        $ids = $request->data_id;
        $ids_ordered = implode(',', $ids);
        $script = Script::whereIn('id', $ids)->orderByRaw("FIELD(id, $ids_ordered)")->get();
        foreach ($ids as $key => $id){
            if ($script[$key]->isActive) {
                $script[$key]->update(['orderNumber' => $key + 1]);
            }
            else {
                return false;
            }
        }
        return true;
    }
}
