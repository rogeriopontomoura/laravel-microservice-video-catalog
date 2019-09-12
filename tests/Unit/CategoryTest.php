<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class CategoryTest extends TestCase
{
    /**
     * Testa o fillable do model
     *
     * @return void
     */
    public function testFillable()
    {
        $fillable = ['name', 'description', 'is_active'];
        $category = new Category();
        $this->assertEquals($fillable, $category->getFillable());
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
        $categoryTraits = array_keys(class_uses(Category::class));                
        $this->assertEquals($traits, $categoryTraits);
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
        $category = new Category();             
        $this->assertEquals($casts, $category->getCasts());
    } 

    /**
     * Testa o incrementing do model
     *
     * @return void
     */
    public function testIncrementing()
    {
        $category = new Category();             
        $this->assertFalse($category->incrementing);
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
        $category = new Category();
        // Percorre os resultados comparando os valores
        foreach ($dates as $date) {
            $this->assertContains($date, $category->getDates());
        }
        // Compara a quantidade de elementos
        $this->assertCount(count($dates), $category->getDates());
        
    }
    
}
