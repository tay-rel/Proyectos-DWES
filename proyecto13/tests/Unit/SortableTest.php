<?php

namespace Tests\Unit;
use App\Sortable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortableTest extends TestCase
{
	 // Las pruebas unitarias las empleamos cuando queramos verificar
	 // una funcionalidad de la aplicacion que no lleve asocidad una
	 //peticion HTTP
	 //protected $sortable;
	 
	 /** @test */
	 //1-Comprobar que podemos devolver la clase linkSortable
	 function return_a_css_class_to_indicate_the_column_is_sortable()
	 {
			$sortable = new Sortable();
			
			$this -> assertSame('link-sortable', $sortable -> classes('first_name'));
			
	 }
	 /** @test */
function return_css_classes_to_indicate_the_column_is_sorted_in_ascendent_order()
{
			$sortable = new Sortable();
			$sortable -> setCurrentOrder('first_name');
			
			$this ->assertSame('link-sortable link-sorted-up', $sortable ->classes('first_name'));
}
	 
	 /** @test */
	 function return_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
	 {
			$sortable = new Sortable();
			$sortable -> setCurrentOrder('first_name' , 'desc');
			
			$this ->assertSame('link-sortable link-sorted-down', $sortable ->classes('first_name'));
	 }


}
