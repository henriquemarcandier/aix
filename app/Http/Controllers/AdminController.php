<?php

namespace App\Http\Controllers;

use App\BugTracking;
use App\Counter;
use App\Logs;
use App\Module;
use App\Newsletter;
use App\Page;
use App\Permission;
use App\Requests;
use App\TypeModule;
use App\User;
use App\Version;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        global $param;
        if(isset($_SESSION['user']['id'])) {
            $typesModules = TypeModule::all();
            $modules = Module::all();
            foreach ($modules as $key => $value){
                $permission[] = Permission::where('user', $_SESSION['user']['id'])->where('module', $value->id)->first();
            }
            $Logs = new logs();
            $Logs->user = $_SESSION['user']['id'];
            $Logs->action = "Visualizou a página inicial";
            $Logs->save();
            $versions = Version::all();
            foreach ($versions as $key => $value) {
                if ($value->date <= date('Y-m-d')) {
                    $versaoQual = $value;
                    $versaoImg = $value->img;
                    $vet = explode('-', $versaoQual->date);
                    $versaoQual->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->date = $vet[2] . "/" . $vet[1] . "/" . $vet[0];
                    $versions[$key]->ano = $vet[0];
                }
                else{
                    unset($versions[$key]);
                }
            }
            $user = User::all();
            foreach ($user as $key => $value) {
                if ($value->id == $_SESSION['user']['id']){
                    $usuario = $value;
                    if(!file_exists(env('APP_DIR')."storage/".$value->img)){
                        $value->img = "user-avatar.svg";
                    }
                }
            }
            return view('admin.home', [
                'typesModules' => $typesModules,
                'modules' => $modules,
                'permission' => $permission,
                'versions' => $versions,
                'versaoImg' => $versaoImg,
                'versaoQual' => $versaoQual,
                'user' => $usuario,
                'param' => ''
            ]);
        }
        else {
            ?><script>location.href='<?php echo env('APP_URL')?>login';</script><?php
        }
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.newPage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page();
        $page->name = $request->name;
        $page->subname = $request->subname;
        $page->description = $request->description;
        $page->status = $request->status;
        $page->save();
        return redirect()->route('page.index');
    }    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('admin.listPage', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.editPage', [
            'page' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $page->name = $request->name;
        $page->subname = $request->subname;
        $page->description = $request->description;
        $page->status = $request->status;
        $page->save();
        return redirect()->route('page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('page.index');
    }
}
