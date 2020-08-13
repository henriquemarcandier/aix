<?php

namespace App\Http\Controllers;

use App\Logs;
use App\Module;
use App\Permission;
use App\Priority;
use App\TypeModule;
use App\User;
use App\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            ?><script>location.href='<?php echo env('APP_URL')?>login?page=logsAcesso';</script><?php
        } else {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'logsAcesso') {
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
            $param = "logsAcesso";
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou os Logs de Acesso";
                $Logs->save();
                $logs = Logs::all()->sortByDesc('created_at');
                $users = User::all();
                foreach ($logs as $key => $value){
                    $logs[$key]->usuario = User::where('id', $value->user)->first();
                }
                return view('admin.listAllLogs', [
                    'logs' => $logs,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'versions' => $versions,
                    'permission' => $permission,
                    'versaoImg' => $versaoImg,
                    'versaoQual' => $versaoQual,
                    'permissao' => $permissao,
                    'users' => $users,
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
}
