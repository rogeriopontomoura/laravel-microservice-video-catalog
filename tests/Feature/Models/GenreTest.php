<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;

class GenreTest extends TestCase
{

    use DatabaseMigrations;

    public function testList()
    {
        // Cria um genero
        factory(Genre::class, 1)->create();

        // Joga os generos na váriavel
        $genres = Genre::all();

        // Testa a quantidade de generos retornados
        $this->assertCount(1, $genres);

        // Cria um array com as chaves
        $genreKey = array_keys($genres->first()->getAttributes());

        // Verifica os campos retornados
        // Verifica os campos retornados
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genreKey
        );        
    }

    // Testa a criação de generos
    public function testCreate()
    {
        // Cria um genero com nome test1
        $genre = Genre::create([
            'name' => 'test1'
        ]);

        // Atualiza o banco
        $genre->refresh();

        // Verifica o nome        
        $this->assertEquals('test1', $genre->name);

        // Verifica se o is_category é true
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($genre->is_active);

        // Testa o UUID
        $genre = factory(Genre::class, 1)->create()->first();

        $id = $genre->id;

        // Verifica se o UUID é valido
        $this->assertTrue(Uuid::isValid($id));
    }

    // Testa a atualização
    public function testUpdate()
    {
        // Cria um genero usando factory
        $genre = factory(Genre::class, 1)->create()->first();

        // Cria um array com os campos a modificar
        $data = [
            'name' => 'test_name_updated',
            'is_active' => true
        ];

        // Modifica
        $genre->update($data);

        // Percorre os registros e compara
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    // Testa a exclusão

    public function testDelete()
    {
        // Cria o genero e joga na variável
        $genre = factory(Genre::class, 1)->create()->first();

        // Deleta o genero e joga o resultado na variável
        $delete = $genre->delete();

        // Verifica o resultado da exclusão
        $this->assertTrue($delete);

        // Teste de restore
        $restore = $genre->restore();

        // Verifica o resultado do restore
        $this->assertNotNull($restore);

    }
}
