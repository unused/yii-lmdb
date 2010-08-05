<?php

class MovieTest extends WebTestCase
{
	public $fixtures=array(
		'movies'=>'Movie',
	);

	public function testShow()
	{
		$this->open('?r=movie/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=movie/create');
	}

	public function testUpdate()
	{
		$this->open('?r=movie/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=movie/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=movie/index');
	}

	public function testAdmin()
	{
		$this->open('?r=movie/admin');
	}
}
