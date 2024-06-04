<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-usuario', ['only' => ['index']]);
        $this->middleware('permission:crear-usuario', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-usuario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-usuario', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $searchTerm = $request->get('search');
        $paginationSize = $request->get('size', 15); // Por defecto, muestra 5 usuarios

        // Calcular el número total de usuarios antes de aplicar la paginación
        $totalUsuarios = User::when($searchTerm, function ($query, $searchTerm) {
            return $query->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%");
        })->count();

        // Calcular el número máximo de páginas basado en el tamaño de página seleccionado
        $maxPage = ceil($totalUsuarios / $paginationSize);

        // Obtener la página actual desde la solicitud o establecerla en 1 por defecto
        $currentPage = $request->input('page', 1);

        // Ajustar la página actual si excede el número máximo de páginas
        if ($currentPage > $maxPage) {
            $currentPage = $maxPage;
        }

        // Forzar a Laravel a usar la página actual ajustada
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $usuarios = User::when($searchTerm, function ($query, $searchTerm) {
            return $query->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%");
        })->paginate($paginationSize);

        return view('usuarios.index', compact('usuarios', 'searchTerm', 'totalUsuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //aqui trabajamos con name de las tablas de users
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'sometimes|array' // Permitir que el campo roles sea opcional
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        // Crear el usuario
        $user = User::create($input);
    
        // Asignar el rol "nuevo" si no se seleccionó ningún rol
        $roles = $request->input('roles', ['nuevo']);
        $user->assignRole($roles);
    
        // Redireccionar con mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario agregado con éxito');
    }
    

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('usuarios.editar', compact('user', 'roles', 'userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['La contraseña actual no es correcta.']]], 422);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return response()->json(['errors' => ['new_password' => ['La nueva contraseña no puede ser igual a la contraseña actual.']]], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Contraseña actualizada con éxito.'], 200);
    }

    public function updateProfile(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();
        
        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Guardar los cambios
        $user->save();

        // Responder con éxito
        return response()->json(['success' => 'Perfil actualizado con éxito.']);
    }

    public function getUserList(Request $request)
{
    $searchTerm = $request->get('search');
    $paginationSize = $request->get('size', 15);

    $usuarios = User::when($searchTerm, function ($query, $searchTerm) {
        return $query->where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%");
    })->paginate($paginationSize);

    return view('usuarios.partials.user_list', compact('usuarios'));
}
}
