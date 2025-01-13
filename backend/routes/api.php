<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/login', function (Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if ($request->user()->is_admin) {
                return response()->json([
                    'token' => $request->user()->createToken('admin_token')->plainTextToken,
                    'user' => $request->user(),
                ]);
            }

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    });
});

Route::group(["prefix" => "article"], function () {
    Route::get("/list", [ArticleController::class, "index"]);
    Route::get('/delete/{id}', [ArticleController::class, "destroy"]);
    Route::post('/create', [ArticleController::class, "create"]);
    Route::post('/edit/{id}', [ArticleController::class, "edit"]);
    Route::get('/detail/{id}', [ArticleController::class, "show"]);
});
