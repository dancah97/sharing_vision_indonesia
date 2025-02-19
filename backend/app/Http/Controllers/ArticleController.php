<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function createArticle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:20',
            'content' => 'required|string|min:200',
            'category' => 'required|string|min:3',
            'status' => 'required|in:Publish,Draft,Thrash',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $article = Posts::create($request->all());

        return response()->json($article, 201);
    }

    public function getArticles($limit = 10, $offset = 0, Request $request)
    {
        $input = $request->all();
        $page = isset($input['page']) ? (int) $input['page'] : 1;

        $query = Posts::select(['id', 'title', 'content', 'category', 'status']);

        if (isset($input['status']) && $input['status'] != '') {
            $query->where('status', $input['status']);
        }

        $total = $query->count();
        
        if($limit != 'all') {
            $query->limit($limit)->offset($offset);
        };

        $articles = $query->get();
        
        if (isset($input['page']) && $input['page'] != '' && $limit != 'all') {
            $temp_articles['data'] = $articles;
            $temp_articles['current_page'] = (int) $input['page'];
            $temp_articles['last_page'] = (int) ceil($total / $limit);
            $articles = array();
            $articles = $temp_articles;
        };

        return response()->json($articles);
    }

    public function getArticle($id)
    {
        $article = Posts::select(['id', 'title', 'content', 'category', 'status'])
            ->where('id', $id)
            ->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found.'
            ], 404);
        };

        return response()->json([$article], 200);
    }

    public function updateArticle(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:20',
            'content' => 'required|string|min:200',
            'category' => 'required|string|min:3',
            'status' => 'required|in:Publish,Draft,Thrash',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        };

        $article = Posts::select(['title', 'content', 'category', 'status'])
            ->where('id', $id)
            ->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found.'
            ], 404);
        
        };

        $updateResult = Posts::where('id', $id)->update($request->all());

        $article = Posts::findOrFail($id);

        return response()->json([$article]);
    }

    public function deleteArticle($id)
    {
        $article = Posts::select(['title', 'content', 'category', 'status'])
            ->where('id', $id)
            ->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found.'
            ], 404);
        };

        $article->delete();

        return response()->json(['message' => 'Article successfully deleted.'], 200);
    }
}
