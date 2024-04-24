<?php



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\MyMessageController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Proprieter\ProprieterController;
use App\Http\Controllers\Abonnees\AbonneesController;
use App\Http\Controllers\Pays\PaysController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Finances\FinancesController;
use App\Http\Controllers\TypeUser\TypeUserController;
use App\Http\Controllers\Location\LocationsController;
use App\Http\Controllers\Utilisateur\UtilisateurController;
use App\Http\Controllers\TypeAbonnees\TypeAbonneeController;
use App\Http\Controllers\TypeBiens\TypeBienController;
use App\Http\Controllers\Contrat\ContratController;
use App\Http\Controllers\Utilisateur\LocataireController;
use App\Http\Controllers\Ville\VilleController;

Route::prefix('v1')->group(
    function () {
        Route::prefix('/proprieter')->group(function () {
            // route  get pour le model Proprieter
            Route::get('/', [ProprieterController::class, 'getAllProprieter']);
            Route::get('/show/{id}', [ProprieterController::class, 'showProprieter']);
            Route::get('/showForProprietaire/{proprietaire_id}', [ProprieterController::class, 'getAllProprieterForProprietaire']);
            // route post put pour Propertier
            Route::put('/edit/{id}', [ProprieterController::class, 'updateProprieter']);
            Route::post('/create', [ProprieterController::class, 'registerProprieter']);
            Route::delete('/delete/{id}', [ProprieterController::class, 'deleteProprieter']);
        });
        Route::prefix('/pays')->group(function () {
            // route  get pour le model Pays
            Route::get('/', [PaysController::class, 'getAllPays']);
            Route::get('/show/{pays}', [PaysController::class, 'showPays']);
            // route post put pour le model Pays
            Route::put('/edit/{id}', [PaysController::class, 'updatePays']);
            Route::post('/create', [PaysController::class, 'registerPays']);
        });
        Route::prefix('/ville')->controller(VilleController::class)->group(function () {
            // route  get pour le model Ville
            Route::get('/',  'getAllVille');
            Route::get('/show/{id}',  'showVille');
            // route post put pour le model Ville
            Route::post('/create',  'registerVille');
            Route::put('/edit/{id}',  'updateVille');
        });
        Route::prefix('/region')->controller(RegionController::class)->group(function () {
            // route  get pour le model Region
            Route::get('/', 'getAllRegion');
            Route::get('/show/{id}', 'showRegion');
            // route post put pour le model Region
            Route::post('/create', 'registerRegion');
            Route::put('/edit/{id}', 'updateRegion');
        });
        Route::prefix('/typeBien')->group(function () {
            // route  get pour le model Ville
            Route::get('/', [TypeBienController::class, 'getAllTypeBien']);
            Route::get('/show/{TypeBienController}', [TypeBienController::class, 'showTypeBien']);
            // route post put pour le model Ville
            Route::post('/create', [TypeBienController::class, 'registerTypeBien']);
            Route::put('/edit/{typebien}', [TypeBienController::class, 'updateTypeBien']);
        });
        Route::prefix('/contrat')->group(function () {
            // route  get pour le model Contrat
            Route::get('/', [ContratController::class, 'getAllContrat']);
            Route::get('/show/{contrat}', [ContratController::class, 'showContrat']);
            // route post pour le model Contrat 
            Route::post('/create', [ContratController::class, 'registerContrat']);
            Route::put('/edit/{contrat}', [ContratController::class, 'updateContrat']);
        });
        Route::prefix('/location')->group(function () {
            // route  get pour le model Location
            Route::get('/', [LocationsController::class, 'getAllLocations']);
            Route::get('/show/{id}', [LocationsController::class, 'showLocation']);
            // route post put pour le model Location
            Route::put('/edit/{id}', [LocationsController::class, 'updateLocation']);
            Route::post('/create', [LocationsController::class, 'registerLocation']);
        });
        Route::prefix('/typeAb')->group(function () {
            // route  get pour le model Finance
            Route::get('/', [TypeAbonneeController::class, 'getAllTypeAb']);
            Route::get('/show/{id}', [TypeAbonneeController::class, 'showTypeAb']);
            // route post put pour le model Finance
            Route::put('/edit/{id}', [TypeAbonneeController::class, 'updateTypeAb']);
            Route::post('/create', [TypeAbonneeController::class, 'registerTypeAb']);
        });
        Route::prefix('/finance')->group(function () {
            // route  get pour le model Finance
            Route::get('/', [FinancesController::class, 'getAllFinance']);
            Route::get('/show/{id}', [FinancesController::class, 'showFinance']);
            // route post put pour le model Finance

            Route::post('/create', [FinancesController::class, 'registerFinance']);
            Route::put('/edit/{id}', [FinancesController::class, 'showFinance']);
        });
        Route::prefix('/typeUser')->group(function () {
            // route post put pour le model TyperUser
            Route::post('/create', [TypeUserController::class, 'registerTypeUser']);
            Route::put('/edit/{typeuser}', [TypeUserController::class, 'updateTypeUser']);
            // route  get pour le model TyperUser
            Route::get('/', [TypeUserController::class, 'getAllTypeUser']);
            Route::get('/show/{typeuser}', [TypeUserController::class, 'showTypeUser']);
        });
        Route::prefix('/abonnee')->group(function () {
            // route  get pour le model TyperUser
            Route::get('/', [AbonneesController::class, 'getAllAbonnee']);
            Route::get('/show/{id}', [AbonneesController::class, 'showAbonnee']);
            // route post put pour le model TyperUser
            Route::post('/create', [AbonneesController::class, 'registerAbonnee']);
            Route::put('/edit/{id}', [AbonneesController::class, 'updateAbonnee']);
        });
        Route::prefix('/message')->controller(MyMessageController::class)->group(function () {
            // route  get pour le model TyperUser
            Route::get('get/',  'getAllMessages');
            Route::get('/show/{message}',  'showMessage');
            // route post put pour le model TyperUser
            Route::post('/create',  'registerMessage');
            Route::put('/edit/{message}',  'updateMessage');
        });
    }

);
Route::prefix('v1/utilisateurs')->group(function () {
    // routes en post put p
    Route::get('/', [UtilisateurController::class, 'index']);
    Route::get('/getLocataires/{proprietaire_id}', [UtilisateurController::class, 'getLocataires']);
    Route::get('/show/{id}', [UtilisateurController::class, 'showUtilisateur']);
    // route post et put pour le model utitlisateur 
    Route::put('/edit/{id}', [UtilisateurController::class, 'editUtilisateur']);
    Route::put('/editStatus/{id}', [UtilisateurController::class, 'updateStatus']);
    Route::post('/create', [UtilisateurController::class, 'createUtilisateur']);
    Route::delete('/delete/{id}', [UtilisateurController::class, 'deleteUtilisateur']);

    // 
    Route::post("/create_and_login", [UtilisateurController::class, 'createAndLoginUser']);
});
Route::prefix('v1/locataire')->group(function () {
    // routes en post put p
    Route::get('/', [LocataireController::class, 'index']);
    Route::get('/show/{id}', [LocataireController::class, 'showLocataire']);
    // route post et put pour le model utitlisateur 
    Route::get('/getProprietaires/{locataire_id}', [LocataireController::class, 'getProprietaire']);
    Route::put('/edit/{id}', [LocataireController::class, 'editLocataire']);
    Route::post('/create', [LocataireController::class, 'createLocataire']);
    Route::delete('/delete/{id}', [LocataireController::class, 'deleteLocataire']);
});
Route::prefix('v1/user')->group(function () {
    Route::post('/login', [UserController::class, 'dologin']);
    Route::post("/register", [UserController::class, 'store']);
});

// ??
Route::post("v1/utilisateurs/login", [UserController::class, 'loginUtilisateur']);

Route::get("/login", function () {
    return "  formulaire de login  vous n'etes pas connecter ";
})->name('login');


Route::prefix('v1/utilisateur')->group(function () {
    // route  get pour le authentifications
    Route::get("/CheckAuth",  [UserController::class, 'checkAuth']);
    Route::post('/login', [UserController::class, 'dologin']);
    Route::post("/register", [UserController::class, 'store']);
});
