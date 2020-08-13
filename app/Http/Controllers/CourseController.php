<?php

namespace App\Http\Controllers;

use App\Course;
use App\Logs;
use App\Module;
use App\Permission;
use App\TypeModule;
use App\User;
use App\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            ?><script>location.href='<?php echo env('APP_URL')?>login?page=cursos';</script><?php
        } else {
            $cursos = Course::all();
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'cursos') {
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
            $param = "cursos";
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou os Cursos";
                $Logs->save();
                return view('admin.listAllCourses', [
                    'cursos' => $cursos,
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
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'banner') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.newCourse', [
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission]);
            }
            else{
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
        $banner = new Course();
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->position = $request->position;
        $banner->status = $request->status;
        if (count($request->allFiles())) {
            for ($i = 0; $i < count($request->allFiles()['file']); $i++) {
                $file = $request->allFiles()['file'][$i];
                $banner->img = $file->store('');
            }
        }
        else{
            $banner->img = "";
        }
        $banner->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Cadastrou o banner ".$request->name;
        $Logs->save();
        return redirect()->route('banner.index');
    }    /**
 * Display the specified resource.
 *
 * @param  \App\Course  $banner
 * @return \Illuminate\Http\Response
 */
    public function show(Course $banner)
    {
        if (Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'banner') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->view) {
                $Logs = new logs();
                $Logs->user = $_SESSION['user']['id'];
                $Logs->action = "Visualizou o banner ".$banner->id;
                $Logs->save();
                return view('admin.listCourse', ['banner' => $banner,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission]);
            }
            else{
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $banner)
    {
        if(Auth::check() === true) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value) {
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                if ($value->slug == 'banner') {
                    $permissao = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
                }
            }
            if ($permissao && $permissao->register) {
                return view('admin.editCourse', [
                    'banner' => $banner,
                    'typesModules' => $typesModules,
                    'modules' => $modules,
                    'permission' => $permission
                ]);
            }
            else{
                return view('admin.semPermissao', ['typeModules' => $typesModules, 'modules' => $modules, 'typesModules' => $typesModules, 'permission' => $permission]);
            }
        }
        return redirect()->route('admin.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $banner)
    {
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->position = $request->position;
        $banner->status = $request->status;
        if (count($request->allFiles())) {
            for ($i = 0; $i < count($request->allFiles()['file']); $i++) {
                $file = $request->allFiles()['file'][$i];
                $banner->img = $file;
            }
        }
        $banner->save();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Atualizou o banner ".$banner->id;
        $Logs->save();
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $banner)
    {
        $banner->delete();
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Excluiu o banner ".$banner->id;
        $Logs->save();
        return redirect()->route('banner.index');
    }
}
