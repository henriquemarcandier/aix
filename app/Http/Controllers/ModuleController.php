<?php

namespace App\Http\Controllers;

use App\Logs;
use App\Module;
use App\Permission;
use App\TypeModule;
use App\TypesServices;
use App\User;
use App\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            ?><script>location.href='<?php echo env('APP_URL')?>login?page=modulos';</script><?php
        } else {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $modules[$key]->atributes = TypeModule::where("id", $value->getAttribute('typeModule'))->first();
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'modulos') {
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
                if ($value->id == $_SESSION['user']['id']){
                    if(!file_exists(env('APP_DIR')."storage/".$value->img)){
                        $value->img = "user-avatar.svg";
                    }
                    $usuario = $value;
                }
            }
            $param = "modulos";
            if ($permissao && $permissao->view){
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou os Módulos";
                $Logs->save();
                $typeModules = TypeModule::all();
                return view('admin.listAllModules', [
                    'modules' => $modules,
                    'typesModules' => $typesModules,
                    'typeModules' => $typeModules,
                    'versions' => $versions,
                    'permission' => $permission,
                    'versaoImg' => $versaoImg,
                    'versaoQual' => $versaoQual,
                    'user' => $usuario,
                    'param' => $param
                ]);
            }
            else{
                return view('admin.semPermissao', ['modules' => $modules, 'typesModules' => $typesModules,
                    'versions' => $versions,
                    'permission' => $permission,
                    'versaoImg' => $versaoImg,
                    'versaoQual' => $versaoQual,
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
            $typeModule = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $modules[$key]->atributes = TypeModule::where("id", $value->getAttribute('typeModule'))->first();
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'modulos') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.newModule', ['permission' => $permission, 'typeModule' => $typeModule, 'typesModules' => $typeModule, 'modules' => $modules]);
            }
            else{
                return view('admin.semPermissao', ['modules' => $modules, 'typesModules' => $typeModule, 'permission' => $permission
                ]);
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
        $module = new Module();
        $module->name = $request->name;
        $module->typeModule = $request->typeModule;
        $module->slug = $request->slug;
        $module->status = $request->status;
        $module->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Cadastrou o Módulo ".$request->name;
        $Logs->save();
        return redirect()->route('module.index');
    }    /**
 * Display the specified resource.
 *
 * @param  \App\Module  $module
 * @return \Illuminate\Http\Response
 */
    public function show(Module $module)
    {
        if (Auth::check() === true) {
            $modules = Module::all();
            $typesModules = TypeModule::all();
            $typeModule = TypeModule::where('id', $module->typeModule)->first();
            foreach ($modules as $key => $value) {
                $modules[$key]->atributes = TypeModule::where("id", $value->getAttribute('typeModule'))->first();
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'modulos') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->view){
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou o Módulo ".$module->id;
                $Logs->save();
                return view('admin.listModule', ['module' => $module, 'typeModule' => $typeModule, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
            else{
                return view('admin.semPermissao', ['module' => $module, 'typeModule' => $typeModule, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission
                ]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        if(Auth::check() === true) {
            $typeModule = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $modules[$key]->atributes = TypeModule::where("id", $value->getAttribute('typeModule'))->first();
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'modulos') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.editModule', ['module' => $module, 'typeModule' => $typeModule, 'typesModules' => $typeModule, 'modules' => $modules, 'permission' => $permission]);
            }            else{
                return view('admin.semPermissao', ['module' => $module, 'typesModules' => $typeModule, 'modules' => $modules, 'permission' => $permission
                ]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {

        $module->typeModule = $request->typeModule;
        $module->name = $request->name;
        $module->slug = $request->slug;
        $module->status = $request->status;
        $module->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Atualizou o Módulo ".$module->id;
        $Logs->save();
        return redirect()->route('module.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->delete();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Excluiu o Módulo ".$module->id;
        $Logs->save();
        return redirect()->route('module.index');
    }
}
