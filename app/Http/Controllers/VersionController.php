<?php

namespace App\Http\Controllers;

use App\Logs;
use App\Module;
use App\Page;
use App\Permission;
use App\User;
use App\Version;
use App\TypeModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            ?><script>location.href='<?php echo env('APP_URL')?>login?page=versao';</script><?php
        } else {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[$key] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'versao') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            $versions = Version::all();
            $chave = 0;
            foreach ($versions as $key => $value){
                if ($value->date <= date('Y-m-d')){
                    $versaoQual = $value;
                    $versaoImg = $value->img;
                    $vet = explode('-', $versaoQual->date);
                    $versaoQual->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->ano = $vet[0];
                    $versions[$key]->ano = $vet[0];
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
            $param = "versao";
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou as Versões do Sistema";
                $Logs->save();
                return view('admin.listAllVersions', [
                    'versions' => $versions,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission,
                    'versaoImg' => $versaoImg,
                    'versaoQual' => $versaoQual,
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
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() === true) {
            $pages = Page::all();
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'versao') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.newVersion', ['pages' => $pages,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission]);
            }
            else {
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
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
        $version = new Version();
        $version->name = $request->name;
        $version->description = $request->description;
        $version->date = $request->date;
        if (count($request->allFiles())) {
            for ($i = 0; $i < count($request->allFiles()['file']); $i++) {
                $file = $request->allFiles()['file'][$i];
                $version->img = $file->store('');
            }
        }
        else{
            $version->img = "";
        }
        $version->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Cadastrou a Versão do Sistema ".$request->name;
        $Logs->save();
        return redirect()->route('version.index');
    }    /**
 * Display the specified resource.
 *
 * @param  \App\Version  $version
 * @return \Illuminate\Http\Response
 */
    public function show(Version $version)
    {
        if(Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'versao') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou a Versão do Sistema ".$version->id;
                $Logs->save();
                $page = Page::where('id', $version->page)->first();
                return view('admin.listVersion', ['version' => $version, 'page' => $page,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission]);
            }
            else {
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Version  $version
     * @return \Illuminate\Http\Response
     */
    public function edit(Version $version)
    {
        if(Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'versao') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                $pages = Page::all();
                return view('admin.editVersion', [
                    'version' => $version,
                    'pages' => $pages,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission
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
     * @param  \App\Version  $version
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Version $version)
    {
        $version->name = $request->name;
        $version->description = $request->description;
        $version->date = $request->date;
        if (count($request->allFiles())) {
            for ($i = 0; $i < count($request->allFiles()['file']); $i++) {
                $file = $request->allFiles()['file'][$i];
                $version->img = $file->store('');
            }
        }
        $version->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Atualizou a Versão do Sistema ".$version->id;
        $Logs->save();
        return redirect()->route('version.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Version  $version
     * @return \Illuminate\Http\Response
     */
    public function destroy(Version $version)
    {
        $version->delete();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Excluiu a Versão do Sistema ".$version->id;
        $Logs->save();
        return redirect()->route('version.index');
    }
}
