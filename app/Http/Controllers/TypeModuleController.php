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

class TypeModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            ?><script>location.href='<?php echo env('APP_URL')?>login?page=tiposModulo';</script><?php
        } else {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value){
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'tiposModulo'){
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
                    $versions[$key]->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];$versions[$key]->ano = $vet[0];
                }
                else{
                    unset($versions[$key]);
                }
            }
            $user = User::all();
            foreach ($user as $key => $value) {
                if ($value->id == $_SESSION['user']['id']) {
                    if(!file_exists(env('APP_DIR')."storage/".$value->img)){
                        $value->img = "user-avatar.svg";
                    }
                    $usuario = $value;
                }
            }
            $param = 'tiposModulo';
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou os Tipos de Módulo";
                $Logs->save();
                return view('admin.listAllTypesModules', [
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
            else{
                return view('admin.semPermissao', [
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
            foreach ($modules as $key => $value){
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'tiposModulo'){
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.newTypeModule', ['modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
            else{
                return view('admin.semPermissao', ['modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
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
        $typeModule = new TypeModule();
        $typeModule->name = $request->name;
        $typeModule->status = $request->status;
        $typeModule->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Cadastrou o Tipo de Módulo ".$request->name;
        $Logs->save();
        return redirect()->route('typeModule.index');
    }    /**
 * Display the specified resource.
 *
 * @param  \App\TypeModule  $typeModule
 * @return \Illuminate\Http\Response
 */
    public function show(TypeModule $typeModule)
    {
        if (Auth::check() === true) {
            $modules = Module::all();
            $typesModules = TypeModule::all();
            foreach ($modules as $key => $value){
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'tiposModulo'){
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou o Tipo de Módulo ".$typeModule->id;
                $Logs->save();
                return view('admin.listTypeModule', ['typeModule' => $typeModule, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
            else{
                return view('admin.semPermissao', ['typeModule' => $typeModule, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TypeModule  $typeModule
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeModule $typeModule)
    {
        if(Auth::check() === true) {
            $modules = Module::all();
            $typesModules = TypeModule::all();
            foreach ($modules as $key => $value){
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'tiposModulo'){
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.editTypeModule', [
                    'typeModule' => $typeModule, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission
                ]);
            }
            else{
                return view('admin.semPermissao', [
                    'typeModule' => $typeModule, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission
                ]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TypeModule  $typeModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeModule $typeModule)
    {

        $typeModule->name = $request->name;
        $typeModule->status = $request->status;
        $typeModule->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Atualizou o Tipo de Módulo ".$typeModule->id;
        $Logs->save();
        return redirect()->route('typeModule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TypeModule  $typeModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeModule $typeModule)
    {
        $typeModule->delete();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Excluiu o Tipo de Módulo ".$typeModule->id;
        $Logs->save();
        return redirect()->route('typeModule.index');
    }
}
