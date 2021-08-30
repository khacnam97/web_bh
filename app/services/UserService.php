<?php


namespace App\services;


use App\Models\AnalyzedFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * @param $records
     * @return array
     */
    public function dataArr($records): array
    {
        $dataArr = [];
        foreach($records as $record){
            $button ='';
            if(auth()->id() !== $record->id) {
                if ($record->trashed()){
                    $button ='<button type="button" name="active" data-id="' . $record->id . '" class="active-user btn btn-success btn-sm">'.__('common.Active').'</button>';
                }else{
                    $button ='<button type="button" name="trash" data-id="' . $record->id . '" class="trash btn btn-secondary btn-sm">'.__('common.Disable').'</button>';
                }
                $button .= '<a href="' . route('user.getEdit', $record->id) . '" class="btn btn-primary btn-sm ml-2 mr-2">'.__('common.Edit').'</a>';
                $button .='<button type="button" name="delete" data-id="' . $record->id . '" class="delete btn btn-danger btn-sm">'.__('common.Delete').'</button>';
            }
            $roleName = $record->getRoleNames()[0] === 'admin' ? __('user.Admin') : __('user.DistributionCenter');
            $dataArr[] = [
                'id' => $record->id,
                'role' => $roleName,
                'username' => $record->username,
                'full_name' => $record->full_name,
                'phone_number' => $record->phone_number,
                'center_name' => $record->center_name,
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
        $records = User::withTrashed()->paginate(10);
        return [
            'users' =>  $this->dataArr($records),
            'totalItem' => $records->total()
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getUsers(Request $request): array
    {
        $draw = $request->get('draw');
        $start = $request->get("start"); // starting page
        $rowPerPage = $request->get("length"); // rows display per page

        $columnIndex = $request->get('order')[0]['column']; // index of column used for order
        $columnName = $request->get('columns')[$columnIndex]['data']; // name of column used for order
        $sortOrder = $request->get('order')[0]['dir']; // asc or desc

        // get total records with and without filter
        $totalRecords = User::withTrashed()->select('count(*) as allCount')->count();

        $records = User::withTrashed()->orderBy($columnName, $sortOrder)->skip($start)
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
     * @return User|User[]|Collection|Model
     */
    public function findUser($id) {
        return User::withTrashed()->findOrFail($id);
    }

    /**
     * @return Collection|Role[]
     */
    public function getRole(){
        return Role::all();
    }

    /**
     * @param $id
     * @return bool
     */
    public function trash($id): bool
    {
        $user = $this->findUser($id);
        return $user->delete();
    }

    /**
     * @param $id
     * @return bool
     */
    public function restore($id): bool
    {
        $user = $this->findUser($id);
        return $user->restore();
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $user = $this->findUser($id);
        $files = AnalyzedFile::where('user_id' , $id)->get();
        foreach ($files as $file) {
            $inputFile = storage_path('app/' . $file->filePath);
            \File::delete($inputFile);
            if ($file->resultPath){
                $resultFile = storage_path('app/' . $file->resultPath);
                \File::delete($resultFile);
            }
        }
        return $user->forceDelete();
    }

    /**
     * @param $request
     * @return bool
     */
    public function store($request): bool
    {
        $user = new User($request->all());
        $password = Hash::make($request->password);
        $user->password = $password;
        $user->assignRole([$request->role_id]);
        return $user->save();
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function update($request, $id): bool
    {
        $user = $this->findUser($id);
        $user->fill($request->all());
        if(auth()->id() !== $id) {
            $user->syncRoles([$request->role_id]);
        }
        return $user->save();
    }

    /**
     * @param $request
     * @return bool
     */
    public function updatePassword($request): bool
    {
       return $this->findUser(auth()->id())->update(['password'=> Hash::make($request->password)]);
    }

}
