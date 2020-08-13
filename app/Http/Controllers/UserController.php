<?php

namespace App\Http\Controllers;

use App\Logs;
use App\Module;
use App\Permission;
use App\TypeModule;
use App\User;
use App\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_SESSION['user']['id'])) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'usuarios') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            $versions = Version::all();
            foreach ($versions as $key => $value){
                if ($value->date <= date('Y-m-d')) {
                    $versaoQual = $value;
                    $versaoImg = $value->img;
                    $vet = explode('-', $versaoQual->date);
                    $versaoQual->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];$versions[$key]->ano = $vet[0];$versions[$key]->ano = $vet[0];
                }
                else{
                    unset($versions[$key]);
                }
            }
            $users = User::all();
            $user = User::all();
            foreach ($user as $key => $value) {
                if ($value->id == $_SESSION['user']['id']){
                    if(!file_exists(env('APP_DIR')."storage/".$value->img)){
                        $value->img = "user-avatar.svg";
                    }
                    $usuario = $value;
                }
            }
            $param = 'usuarios';
                if ($permissao && $permissao->view) {
                    $Logs = new logs();
                    $Logs->user = $_SESSION['user']['id'];
                    $Logs->action = "Visualizou os Usuários do Sistema";
                    $Logs->save();
                    return view('admin.listAllUsers', [
                        'users' => $users,
                        'typesModules' => $typesModules,
                        'modules' => $modules,
                        'versions' => $versions,
                        'permission' => $permission,
                        'versaoImg' => $versaoImg,
                        'versaoQual' => $versaoQual,
                        'permissao' => $permissao,
                        'user' => $usuario,
                        'param' => $param
                    ]);
                }
                else {
                    return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules,
                        'versions' => $versions,
                        'permission' => $permission,
                        'versaoImg' => $versaoImg,
                        'versaoQual' => $versaoQual,
                        'permissao' => $permissao,
                        'user' => $usuario,
                        'param' => $param]);
                }

        }
        else{
            ?><script>location.href='<?php echo env('APP_URL')?>login?page=usuarios';</script><?php
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'usuarios') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            $versions = Version::all();
            foreach ($versions as $key => $value){
                if ($value->date <= date('Y-m-d')) {
                    $versaoQual = $value;
                    $versaoImg = $value->img;
                    $vet = explode('-', $versaoQual->date);
                    $versaoQual->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];$versions[$key]->ano = $vet[0];$versions[$key]->ano = $vet[0];
                }
                else{
                    unset($versions[$key]);
                }
            }
            $user = User::all();
            foreach ($user as $key => $value) {
                if ($value->id == $_SESSION['user']['id']){
                    $usuario = $value;
                }
            }
            $param = 'usuarios';
            if ($permissao && $permissao->register) {
                return view('admin.newUser', [
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'versions' => $versions,
                    'permission' => $permission,
                    'versaoImg' => $versaoImg,
                    'versaoQual' => $versaoQual,
                    'permissao' => $permissao,
                    'user' => $usuario,
                    'param' => $param]);
            }
            else {
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission,
                    'user' => $usuario,
                    'param' => $param]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if (count($request->allFiles())) {
            for ($i = 0; $i < count($request->allFiles()['file']); $i++) {
                $file = $request->allFiles()['file'][$i];
                $user->img = $file->store('');
            }
        }
        else{
            $user->img = "";
        }
        $user->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Cadastrou o Usuário do Sistema ".$request->name;
        $Logs->save();
        return redirect()->route('user.index');
    }    /**
 * Display the specified resource.
 *
 * @param  \App\User  $user
 * @return \Illuminate\Http\Response
 */
    public function show(User $user)
    {
        if(Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'usuarios') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            $user = User::all();
            foreach ($user as $key => $value) {
                if ($value->id == $_SESSION['user']['id']){
                    $usuario = $value;
                }
            }
            $param = 'usuarios';
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou o Usuário do Sistema ".$user->id;
                $Logs->save();
                return view('admin.listUser', ['user' => $user,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission,
                    'user' => $usuario,
                    'param' => $param]);
            }
            else {
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'usuarios') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            $versions = Version::all();
            foreach ($versions as $key => $value){
                if ($value->date <= date('Y-m-d')) {
                    $versaoQual = $value;
                    $versaoImg = $value->img;
                    $vet = explode('-', $versaoQual->date);
                    $versaoQual->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];$versions[$key]->ano = $vet[0];$versions[$key]->ano = $vet[0];
                }
                else{
                    unset($versions[$key]);
                }
            }
            $user = User::all();
            foreach ($user as $key => $value) {
                if ($value->id == $_SESSION['user']['id']){
                    $usuario = $value;
                }
            }
            $param = 'usuarios';
            if ($permissao && $permissao->register) {
                return view('admin.editUser', [
                    'user' => $user,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'versions' => $versions,
                    'permission' => $permission,
                    'versaoImg' => $versaoImg,
                    'versaoQual' => $versaoQual,
                    'permissao' => $permissao,
                    'user' => $usuario,
                    'param' => $param
                    ]);
            }
            else {
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if (count($request->allFiles())) {
            for ($i = 0; $i < count($request->allFiles()['file']); $i++) {
                $file = $request->allFiles()['file'][$i];
                $user->img = $file->store('');
            }
        }
        $user->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Atualizou o Usuário do Sistema ".$user->id;
        $Logs->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Excluiu o Usuário do Sistema ".$user->id;
        $Logs->save();
        return redirect()->route('user.index');
    }
}
