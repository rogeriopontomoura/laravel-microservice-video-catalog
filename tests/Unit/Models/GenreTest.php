<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class GenreTest extends TestCase
{
    /**
     * Testa o fillable do model
     *
     * @return void
     */
    public function testFillable()
    {
        $fillable = ['name', 'is_active'];
        $genre = new Genre();
        $this->assertEquals($fillable, $genre->getFillable());
    }

    /**
     * Testa os traits do model
     *
     * @return void
     */
    public function testifUseTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $genreTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);
    }

    /**
     * Testa o cast do model
     *
     * @return void
     */
    public function testCasts()
    {
        $casts = [
            'id' => 'string'
        ];
        $genre = new Genre();
        $this->assertEquals($casts, $genre->getCasts());
    }

    /**
     * Testa o incrementing do model
     *
     * @return void
     */
    public function testIncrementing()
    {
        $genre = new Genre();
        $this->assertFalse($genre->incrementing);
    }

    /**
     * Testa os campos de data do model
     *
     * @return void
     */
    public function testDatesAttribute()
    {
        // Array com os campos de data
        $dates = ['deleted_at', 'updated_at', 'created_at'];
        $genre = new Genre();
        // Percorre os resultados comparando os valores
        foreach ($dates as $date) {
            $this->assertContains($date, $genre->getDates());
        }
        // Compara a quantidade de elementos
        $this->assertCount(count($dates), $genre->getDates());
    }
}
