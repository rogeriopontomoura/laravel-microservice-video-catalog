<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;

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

        // Testa o UUID da categoria
        
        // Gera uma categoria
        $category = factory(Category::class, 1)->create()->first();

        // Pega o UUID gerado
        $id = $category["id"];

        // Verifica se o UUID é valido
        $this->assertTrue(Uuid::isValid($id));        

    }

    // Testa a atualização de categorias
    public function testUpdate()
    {
        // Cria uma categoria usando o factory
        $category = factory(Category::class, 1)->create([
            // Sobscreve o description do factory
            'description' => 'test_description',
        ])->first();

        // Cria um array com os campos a modificar
        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description',
            'is_active' => true
        ];

        // Modifica
        $category->update($data);

        // Percorre os registros e compara os resultados
        foreach ($data as $key => $value){
            $this->assertEquals($value, $category->{$key});
        }

    }

    // Testa a exclusão de categorias
    public function testDelete()
    {
        // Cria a categoria e joga na váriavel
        $category = factory(Category::class, 1)->create()->first();

        // Deleta a categoria criada e joga o resultado na variável
        $delete = $category->delete();

        // Verifica o resultado da exclusão
        $this->assertTrue($delete);

        // Teste de restore
        $restore = $category->restore();

        // Verifica o resultado do restore
        $this->assertNotNull($restore);
    }

}
