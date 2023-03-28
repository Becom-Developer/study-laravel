<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * 登録済みのユーザーを表示する
     */
    public function show(string $id): View
    {
        // データベースを検索してみる
        $users = DB::select('select * from users where id = ?', [$id]);
        // 1件だけの前提で
        $list = [];
        foreach ($users as $user) {
            array_push($list, [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
        $single = array_shift($list);
        return view('user.profile', ['user' => $single]);
    }
}
