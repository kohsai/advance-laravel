<?php

namespace App\Http\Controllers;
// Eloquentを使用できるようにAuthorモデルを読み込む

use App\Models\Author;
use Illuminate\Http\Request;


class AuthorController extends Controller
{
    // データ一覧ページの表示
    public function index()
    {
        $authors = Author::Paginate(4);
        return view('index', ['authors' => $authors]);
    }

    // データ追加用ページの表示
    public function add()
    {
        return view('add');
    }


    // 追加機能
    public function create(AuthorRequest $request)
    {
        $form = $request->all();
        Author::create($form);
        return redirect('/');
    }

    // データ編集ページの表示
    public function edit(Request $request){
        $author = Author::find($request->id);
        return view('edit',['form' => $author]);
    }

    // 更新機能
    public function update(AuthorRequest $request)
    {
        $form = $request->all();
        unset($form['_token']);
        Author::find($request->id)->update($form);
        return redirect('/');
    }
    // データ削除用ページの表示
    public function delete(Request $request)
    {
        $author = Author::find($request->id);
        return view('delete', ['author' => $author]);
    }

    // 削除機能
    public function remove(Request $request)
    {
        Author::find($request->id)->delete();
        return redirect('/');
    }
    public function verror()
    {
    return view('verror');
    }

    // リレーションを確認するためにauthorsテーブルのデータを返すアクションとしてrelateアクションを追記
    public function relate(Request $request) //追記
    {
        $hasItems = Author::has('book')->get();
        $noItems = Author::doesntHave('book')->get();
        $param = ['hasItems' => $hasItems, 'noItems' => $noItems];
        return view('author.index', $param);
}
}