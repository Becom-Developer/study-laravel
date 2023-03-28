<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    // 既存のマイグレーション実行
    use RefreshDatabase;
    /**
     * コントローラー存在確認
     * @test
     */
    public function hasUserController(): void
    {
        $this->seed();
        $user_id = 1;
        $res = $this->get("/user/$user_id");
        $res->assertStatus(200);
    }
    /**
     * テンプレートのタイトル
     * @test
     */
    public function hasViewTitle()
    {
        $this->seed();
        $user_id = 2;
        $res = $this->get("/user/$user_id");
        $res->assertSeeText('user show');
    }
    /**
     * データベースのデータ存在確認
     * @test
     */
    public function hasDataBase()
    {
        $this->seed();
        $user_id = 1;
        $res = $this->get("/user/$user_id");
        $res->assertSeeText('Test User');
    }
}
