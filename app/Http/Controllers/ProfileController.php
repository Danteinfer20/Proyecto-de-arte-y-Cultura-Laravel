<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Obtener el usuario completo del modelo
        $user = User::find(Auth::id());

        // Validación de datos - CON NOMBRES CORRECTOS
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualizar datos básicos
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->phone = $request->phone;
        $user->website = $request->website;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;

        // Procesar imagen de perfil - NOMBRE CORRECTO
        if ($request->hasFile('profile_picture')) {
            // Eliminar imagen anterior si existe
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            
            $profileImagePath = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $profileImagePath;
        }

        // Procesar imagen de cover - NOMBRE CORRECTO
        if ($request->hasFile('cover_picture')) {
            // Eliminar cover anterior si existe
            if ($user->cover_picture) {
                Storage::delete($user->cover_picture);
            }
            
            $coverImagePath = $request->file('cover_picture')->store('cover-pictures', 'public');
            $user->cover_picture = $coverImagePath;
        }

        // Guardar cambios
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}