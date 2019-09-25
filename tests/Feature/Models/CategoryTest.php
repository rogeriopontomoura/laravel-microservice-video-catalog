<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{

    use DatabaseMigrations;

    // Testa a listagem de categorias
    public function testList()
    {
        // Cria uma categoria
        factory(Category::class, 1)->create();
        
        // Joga todas as categorias na variável
        $categories = Category::all();
        
        // Faz o teste da quantidade de categorias retornadas
        $this->assertCount(1, $categories);

        // Cria um array com as chaves
        $categoryKey = array_keys($categories->first()->getAttributes());

        // Verifica os campos retornados
        $this->assertEqualsCanonicalizing(
            [
            'id', 
            'name', 
            'description', 
            'is_active',
            'created_at', 
            'updated_at', 
            'deleted_at'
            ],
            $categoryKey
        );
    }

    // Testa a criação de categorias

    public function testCreate()
    {
        // Cria a categoria com nome test1
        $category = Category::create([
            'name' => 'test1'
        ]);
        
        // Atualiza o banco
        $category->refresh();

        // Verifica se há uma categoria chamada test1
        $this->assertEquals('test1', $category->name);
        // Verifica se a descrição é nula
        $this->assertNull($category->description);
        // Verifica se o is_category é true
        $this->assertTrue($category->is_active);
        
        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);

        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test1',
            'description' => 'description 1'
        ]);

        $this->assertEquals('description 1', $category->description);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);

        $this->assertTrue($category->is_active);
    }

}
