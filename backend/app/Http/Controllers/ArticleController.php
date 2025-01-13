<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Article::whereNull("deleted_at")->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $article = new Article();
        $article->admin_id  = $data['admin_id'];
        $article->title = $data['title'];
        $article->content = $data['content'];

        $save = $article->save();

        return response()->json([
            'messsage' => $save ? "Data has been inserted" : "failed during inserting the data",
            "data" => $data,
            "success" => $save
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        dd($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Article::find($id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $Newdata = $request->all();

        $article = Article::find($id);
        $article->admin_id  = $Newdata['admin_id'];
        $article->title = $Newdata['title'];
        $article->content = $Newdata['content'];
        $article->updated_at = now();

        $save = $article->save();
        return response()->json([
            'messsage' => $save ? "Data has been updated " : "failed during updating the data",
            "success" => $save,
            "data" => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateArticleRequest $request, Article $article)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Article::find($id);

        $data->deleted_at = now();

        $save = $data->save();
        return response()->json([
            'messsage' => $save ? "Data has been removeed" : "failed during removing the data",
            "success" => $save,
            "id" => $id
        ]);
    }
}
