<?php
namespace App\Http\Controllers;

use App\Banner;
use App\Client;
use App\Logs;
use App\Page;
use App\ParamSite;
use App\Product;
use App\Requests;
use App\State;
use App\Subitem;
use App\TypeDocument;
use App\TypesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Directory;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banners = Banner::all();
        $pages = Page::all();
        $subitens = Subitem::all();
        $typesService = TypesServices::all();
        $typesDocuments = TypeDocument::all();
        $paramSite = ParamSite::all();
        $products = Product::all();
        foreach ($paramSite as $key => $value){
            $parametrosSite[$value->name] = strip_tags(html_entity_decode($value->value));
        }
        if (!$_SESSION){
            $_SESSION['cliente']['id'] = "";
        }
        if (!$_SESSION['cliente']['id']){
            return view('site.homeDeslogado', [
                'banners' => $banners,
                'pages' => $pages,
                'subitens' => $subitens,
                'typesService' => $typesService,
                'typesDocuments' => $typesDocuments,
                'parametrosSite' => $parametrosSite
            ]);
        }
        else{
            $client = Client::where('id', $_SESSION['cliente']['id'])->first();
            $states = State::all();
            return view('site.home', [
                'banners' => $banners,
                'pages' => $pages,
                'subitens' => $subitens,
                'typesService' => $typesService,
                'typesDocuments' => $typesDocuments,
                'parametrosSite' => $parametrosSite,
                'client' => $client,
                'states' => $states,
                'products' => $products
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function alterarSenha()
    {
        $client = Client::all();
        $paramSite = ParamSite::all();
        foreach ($paramSite as $key => $value){
            $parametrosSite[$value->name] = strip_tags(html_entity_decode($value->value));
        }
        $client2 = "";
        foreach ($client as $key => $value) {
            if ($value->remember_token == $_REQUEST['codigo']){
                $client2 = $value;
            }
        }
        if (!$client2){
            ?><script>alert('Nenhum usuário encontrado!'); window.close();</script><?php
        }
        else {
            return view('site.alterarSenha', [
                'client' => $client2,
                'parametrosSite' => $parametrosSite,
                'pages' => null,
                'subitems' => null
            ]);
        }

    }
    public function logout()
    {
        $_SESSION['cliente']['id'] = "";
        $_SESSION['cliente']['nome'] = "";
        $_SESSION['cliente']['email'] = "";
        ?>
        <script>alert('Logout efetuado com sucesso!');</script>
        <?php
        return redirect()->route('home');
    }
    public function efetuarPagamento()
    {
        $pedido = Requests::where('id', $_REQUEST['id'])->first();
        if (!$pedido){
            ?><script>
                alert('Este pedido não consta em nossa lista de pedidos.!');
                window.close();
            </script><?php
        }
        else {
            if ($pedido->status > 3) {
                ?>
                <script>
                    alert('Este pedido já foi pago ou cancelado!');
                    window.close();
                </script><?php
            } else {
                $paramSite = ParamSite::all();
                foreach ($paramSite as $key => $value){
                    $parametrosSite[$value->name] = strip_tags(html_entity_decode($value->value));
                }
                if ($pedido->paymentMethod == 1){
                    return view('site.efetuarPagamentoDeposito', [
                        'pedido' => $pedido,
                        'parametrosSite' => $parametrosSite
                    ]);
                }
                else{
                    require_once(env('APP_DIR')."lib/PayU.php");
                    PayU::$apiKey = "xxxxxxxxxxxx"; //Insira aqui sua própria apiKey.
                    PayU::$apiLogin = "xxxxxxxxxxxx"; //Insira aqui sua própria apiLogin
                    PayU::$merchantId = "1"; //Insira aqui sua ID de Comércio.
                    PayU::$language = SupportedLanguages::ES; //Selecione o idioma
                    PayU::$isTest = false; //Deixá-lo em True quando em testes.
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new Banner();
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
        return redirect()->route('banner.index');
    }    /**
 * Display the specified resource.
 *
 * @param  \App\Banner  $banner
 * @return \Illuminate\Http\Response
 */
    public function show(Banner $banner)
    {
        if (Auth::check() === true) {
            return view('admin.listBanner', ['banner' => $banner]);
        }
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        if(Auth::check() === true) {
            return view('admin.editBanner', [
                'banner' => $banner
            ]);
        }
        return redirect()->route('admin.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {

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
        $banner->save();
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('banner.index');
    }
}
